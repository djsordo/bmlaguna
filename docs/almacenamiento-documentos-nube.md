# Almacenamiento de documentos y fotos fuera del servidor

Documento técnico: alternativas para sacar ficheros de `public/docs`, `public/fotos` y volumen similar hacia la nube u otro sistema, aplicación **BMLaguna** (Laravel 5.7, PHP 7.1).

---

## 1. Cómo está montado hoy en el código

- **Subidas** a `public/docs/` (p. ej. `DocumentosMiembroController`, partes de `MiembroController` para DNI) mediante `move(public_path().'/docs/', ...)`.
- **Fotos** también se guardan en **`public/fotos/`** en algunos flujos de `MiembroController`.
- En **vistas** las URLs son fijas: `'/docs/'.$ruta` (y análogo con fotos).
- **Borrado** de ficheros: `unlink(public_path().'/docs/...')` y en `Miembro::borrar()` rutas bajo `/fotos/`.
- **`config/filesystems.php`** ya incluye el **disco `s3`** configurable (`FILESYSTEM_DRIVER`, credenciales AWS), pero el código **no** usa aún `Storage::disk(...)` para estos archivos.

En la práctica, el volumen “de usuario” vive en **disco del propio servidor**, servido como estático bajo `/docs` y `/fotos`. Migrar implica **cambiar dónde se escribe/lee** y **cómo se construye la URL** en las vistas (o un proxy).

---

## 2. Estrategias posibles

### 2.1 Almacenamiento de objetos + misma aplicación (recomendado como base)

**Idea:** mantener la aplicación donde está y mover **solo los binarios** a un **bucket** (S3, Azure Blob, GCS, etc.).

| Ventajas | Notas |
|----------|--------|
| El servidor deja de crecer en disco | Copias, versionado y CDN suelen ser sencillos |
| Encaje con Laravel | Disco `s3` (o compatible) + `Storage::put()`, `Storage::url()` / URLs firmadas |

**Proveedores habituales**

| Opción | Notas |
|--------|--------|
| **AWS S3** | Estándar; **CloudFront** delante para imágenes/PDF y menos carga al origin |
| **Google Cloud Storage** | Encaja si ya se usa GCP; CDN integrada |
| **Azure Blob** | Encaje con ecosistema Microsoft |
| **Wasabi / Backblaze B2 / DigitalOcean Spaces** | API **tipo S3**; a menudo más baratos en almacenamiento/egreso según uso (revisar condiciones) |

**Visibilidad del bucket**

- **Público (solo lectura de objetos concretos):** URLs estables tipo `https://cdn.dominio/...` — simple para `<img src="...">` y enlaces a PDF.
- **Privado + URL firmada (temporal):** adecuado si los documentos son sensibles (DNI); la vista obtiene una URL que caduca o un controlador hace `Storage::temporaryUrl()` (según driver) o stream con autenticación.

Para fotos de carnet y DNI, muchos clubs combinan **privado** con **sesión autenticada** o **URLs firmadas** de corta duración.

### 2.2 S3-compatible económico + CDN delante

Misma arquitectura: un **CDN** (Cloudflare, CloudFront, etc.) cachea imágenes y reduce peticiones repetidas al bucket. Conviene valorar el **coste de egreso** (tráfico saliente del bucket).

### 2.3 Solo CDN delante del servidor actual (mitad de camino)

**Cloudflare** (u otro) cacheando `/docs/*` y `/fotos/*`. **No libera espacio en disco** del servidor; mejora rendimiento y a veces el coste de ancho de banda. Útil como **complemento**, no como sustituto del almacenamiento.

### 2.4 Otro servidor con más disco (VPS, volumen, NAS, SMB)

Segundo servidor o volumen de red (NFS, SMB, sincronización). Sigue siendo **operación propia**: copias, escalado y mantenimiento. Puede tener sentido si no se quiere cloud por política; no suele ser más barato que object storage bien dimensionado.

### 2.5 Servicios SaaS de ficheros (poco habitual para este caso)

Dropbox Business, Google Drive API, etc.: posible pero **más complejo** (OAuth, cuotas, no es el patrón natural para miles de miniaturas en listados). Normalmente no compensa frente a S3 + CDN.

---

## 3. Cambio técnico en la aplicación (resumen)

1. Definir un disco (`s3` o compatible) en `config/filesystems.php` y variables en `.env`.
2. Sustituir `move(public_path().'/docs/', ...)` por `Storage::disk('documentos')->put(...)` (o el nombre de disco elegido).
3. Guardar en base de datos el **path dentro del bucket** (como ahora el nombre de fichero o ruta relativa); opcionalmente prefijo por entorno (`prod/miembros/...`).
4. Sustituir en Blade `'/docs/'.$ruta` por URL pública del bucket/CDN, un **helper** `documento_url($ruta)` o la ruta completa almacenada en BD.
5. Borrados: `Storage::delete(...)` en lugar de `unlink`.
6. **Migración one-off:** comando Artisan o herramienta tipo `aws s3 sync` para subir `public/docs` y `public/fotos` al bucket y validar.
7. **Coherencia fotos/docs:** en el código aparecen rutas **`/docs/`** en vistas y **`/fotos/`** en borrados de documentos; conviene **unificar criterio** (carpeta lógica en el bucket) al migrar.

**Paquetes:** Laravel 5.7 suele usar **`league/flysystem-aws-s3-v3`** vía Composer; hay que fijar una versión compatible con **PHP 7.1**.

---

## 4. Criterios para elegir solución

- **Presupuesto:** almacenamiento + **egreso** (descargas/visualizaciones) + número de peticiones.
- **Privacidad:** DNI y datos sensibles → bucket **privado** + URLs firmadas o descarga solo con login.
- **Rendimiento:** CDN para imágenes en listados.
- **Residencia de datos:** región **UE** (AWS/GCP/Azure) si aplica RGPD estricto.
- **Copias de seguridad:** versionado en el bucket, política de retención o réplica entre regiones.

---

## 5. Valoración económica (orientación al coste)

Los precios públicos **cambian** (región, moneda, descuentos). Lo siguiente es **orientativo** para comparar órdenes de magnitud; conviene contrastar siempre con la **página oficial** del proveedor y la región elegida (p. ej. UE para RGPD).

### 5.1 Qué componentes suman en la factura

| Concepto | Por qué importa en un club con muchas fotos/listados |
|----------|------------------------------------------------------|
| **Almacenamiento (GB/mes)** | Crece con años de temporadas, DNI, PDFs. Suele ser la partida más predecible. |
| **Egreso (tráfico saliente a Internet)** | Cada visualización de miniatura o descarga cuenta. En **S3 “a pelo”** suele ser la sorpresa más grande si hay mucho tráfico. |
| **Peticiones (GET/PUT)** | Miles de miniaturas en listados = muchos GET; impacto suele ser menor que almacenamiento + egreso salvo volumen extremo. |
| **CDN** | Coste propio (CloudFront, etc.) pero **reduce** lecturas repetidas al bucket y, en AWS, el tráfico **S3 → CloudFront** suele estar **exento** de egreso de S3 a Internet. |
| **Mínimos / condiciones** | Algunos proveedores imponen mínimo facturable, duración mínima del objeto o límites de “egreso gratis” con letra pequeña. |

**Regla práctica:** para una app con **muchas imágenes vistas en bucle** (listados de miembros, equipos), el **egreso** puede dominar la factura si solo se usa almacenamiento barato sin CDN ni proveedor con egreso favorable.

### 5.2 Órdenes de magnitud (referencia aproximada)

Cifras típicas en documentación pública (USD, **no** incluyen impuestos; región USA/EU puede variar):

| Enfoque | Almacenamiento (orden de magnitud) | Egreso a Internet |
|--------|-------------------------------------|-------------------|
| **AWS S3 Standard** | ~**0,02 USD/GB-mes** (primeros TB; varía por clase y región) | Tras cupo gratuito mensual, del orden de **~0,09 USD/GB** hacia Internet (sí importa el volumen de vistas) |
| **S3 + CloudFront** | S3 como arriba + tarifa CloudFront | Tráfico **desde S3 a CloudFront** habitualmente sin cargo de egreso S3; se paga **CloudFront** al usuario (a menudo más barato que egreso directo S3) |
| **Cloudflare R2** | Del orden de **~0,015 USD/GB-mes** (verificar tier actual) | **Egreso a Internet: 0 USD** con R2 (punto fuerte frente a S3 clásico) |
| **Wasabi** | Del orden de **~7 USD/TB-mes** (equivale a pocos milésimos/GB), con **mínimos** y condiciones (p. ej. duración mínima de almacenamiento) | Política de “egreso incluido” con **límites de uso razonable** (revisar letra pequeña) |
| **Backblaze B2** | Del orden de **~6 USD/TB-mes** | Primeros GB de egreso con reglas específicas; partner/CDN puede reducir egreso |
| **Google / Azure** | Competitivos con S3 según tier y región | Egreso y peticiones en estructura similar: hay que calcular escenario |

**Conclusión cualitativa:**

- **Más “predecible” en escenarios con muchas descargas/visualizaciones:** **R2** (sin egreso), **Wasabi/B2** (precio TB claro; revisar fair use), o **S3 + CloudFront** bien configurado.
- **S3 solo** sin CDN: suele ser **correcto en almacenamiento**, **riesgoso en egreso** si el tráfico de lectura es alto.

### 5.3 Comparativa rápida por “tipo de decisión”

| Prioridad | Opción económica razonable |
|-----------|----------------------------|
| **Mínimo coste recurrente** y muchas vistas | Valorar **R2** o proveedores con **egreso muy limitado** en el precio; **CDN** delante de cualquier bucket con mucho tráfico. |
| **Ecosistema ya en AWS** | **S3 + CloudFront** (o sólo S3 si el tráfico es bajo). |
| **Simplicidad de factura** (un precio por TB) | **Wasabi** / **B2** (con lectura de condiciones y mínimos). |
| **No pagar cloud de objetos** | **Más disco en el mismo hosting** o **VPS barato con volumen**: coste fijo mensual (p. ej. decenas de €/año por bloques de 50–200 GB según proveedor), pero **tú** sigues con backups y escalado manual. |
| **Solo aliviar ancho de banda, no disco** | **Cloudflare** delante del origen: puede bajar transferencia desde el servidor; **no** sustituye ampliar almacenamiento. |

### 5.4 Ejemplo numérico muy simplificado

Supongamos **50 GB** almacenados y **100 GB/mes** de tráfico saliente (miniaturas + PDFs vistos desde fuera del servidor):

- **Solo S3 (storage + egress aprox.):** del orden de **1 USD/mes** de almacenamiento + **~9 USD/mes** de egreso (tras cupos) → **≈10 USD/mes** solo por tráfico y disco en ese orden (ilustrativo).
- **R2 (misma suposición de storage; egreso 0 en modelo R2):** del orden de **0,75 USD/mes** de almacenamiento + **0** egreso → la factura baja mucho **si** el patrón de uso encaja y el precio vigente se mantiene.

Los números reales dependen de región, cupos, CDN y picos de uso; el ejemplo sirve para ver **por qué el egreso importa**.

### 5.5 Resumen económico

1. Para **clubes con muchas consultas a fotos/documentos**, el **egreso** puede superar con creces el coste del **almacenamiento** si se elige mal el patrón (S3 público sin CDN, etc.).
2. **R2**, **Wasabi/B2** (con condiciones) o **S3+CloudFront** suelen estar entre las opciones **más racionales en coste total** frente a S3 “expuesto” a Internet sin optimizar.
3. Un **VPS con más disco** puede ser barato en €/GB/año pero con **coste oculto** (tiempo, backups, rotura de disco).
4. **Verificar siempre** precios actuales, región **UE**, moneda e impuestos antes de comprometer presupuesto.

---

## 6. Resumen técnico

- Lo más alineado con **sacar el volumen del servidor de la aplicación** es **almacenamiento de objetos en la nube** (idealmente **S3 o API compatible**) + opcionalmente **CDN** y bucket **privado** para documentación sensible.
- El proyecto **ya incluye** la base de Flysystem en `filesystems.php`; falta **usarla en controladores/vistas** y **migrar** archivos existentes.
- **CDN sin mover ficheros** no soluciona el límite de disco.
- Un **segundo servidor solo para disco** es alternativa si la política evita cloud, pero no suele ser más simple que un bucket bien configurado.

---

*Documento interno — BMLaguna.*
