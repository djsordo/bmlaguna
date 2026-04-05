# Almacenamiento con OpenMediaVault (OMV) y la aplicación

Documento orientado a usar una **máquina virtual con OpenMediaVault** y **almacenamiento suficiente** como destino de fotos y documentos del club, en lugar de (o además de) el disco del servidor donde corre **BMLaguna** (Laravel).

---

## 1. Qué aporta OMV en este contexto

**OpenMediaVault** es un sistema tipo NAS (basado en Debian) que gestiona volúmenes, usuarios y protocolos de red (**NFS**, **SMB/CIFS**, FTP, etc.), con soporte habitual de **Docker** para servicios adicionales.

Con una VM OMV y disco amplio tenéis un **NAS propio**: encaja como **destino de los ficheros** sin pagar almacenamiento en la nube pública, a cambio de **operar** red, seguridad y copias de seguridad vosotros mismos.

---

## 2. Enfoques que encajan con Laravel (BMLaguna)

### 2.1 Carpeta de red montada en el servidor de la aplicación (lo más directo)

1. En OMV se crea un **recurso compartido** (NFS o SMB/CIFS).
2. En el servidor donde corre **Laravel**, se monta ese recurso en un directorio (p. ej. `/mnt/omv-docs`).
3. La aplicación escribe y lee ahí en lugar de `public/docs` / `public/fotos`, o se usa un **enlace simbólico** `public/docs` → `/mnt/omv-docs/docs` (con cuidado con permisos y despliegues).

| Ventajas | Riesgos / notas |
|----------|-----------------|
| Poca complejidad de código; rutas “como fichero local” | Si cae la red o la VM, **la app no sirve ficheros** |
| Reutilizáis el patrón actual de `move()` / `unlink` con otro path base | Latencia algo mayor que disco local |
| | Hay que alinear **permisos** (p. ej. usuario `www-data` o el que use PHP) |

**Encaja si:** la VM OMV y el servidor web están en la **misma red fiable** (LAN, VPN site-to-site).

### 2.2 MinIO (u otro compatible S3) en Docker sobre OMV

1. En la VM OMV se instala **Docker** (plugin habitual en OMV) y se levanta **MinIO** con los datos en el volumen grande.
2. MinIO expone API **compatible S3**; Laravel usa el **disco `s3`** apuntando al endpoint de MinIO (interno o tras reverse proxy con HTTPS).

| Ventajas | Notas |
|----------|--------|
| Mismo modelo que almacenamiento **tipo S3** (subidas, borrados, URLs firmadas si se configuran) | Más piezas que un simple montaje NFS/SMB |
| Migración parecida a “ir a AWS” pero **en infraestructura propia** | Conviene HTTPS y firewall si se expone algo |

**Ideal si:** queréis **privado + URLs firmadas** para documentos sensibles (DNI) sin exponer un bucket público a Internet.

### 2.3 Solo copias de seguridad / archivo frío (rsync, Borg, etc.)

- El servidor de producción sigue guardando en disco local o en un volumen montado.
- **Rsync** (o tareas programadas en OMV) copian periódicamente a OMV.

| Ventajas | Límites |
|----------|---------|
| Bajo esfuerzo; OMV como **caja de respaldo** con mucho espacio | **No** libera disco en el servidor principal salvo que el origen sea solo temporal o se vacíe tras la copia |

---

## 3. Qué se puede hacer en la práctica con OMV

| Objetivo | Uso razonable de OMV |
|----------|----------------------|
| Sustituir `public/docs` / `public/fotos` por almacenamiento en la VM | NFS/SMB montado en el servidor web, o **MinIO** + disco S3 en Laravel. |
| Evitar coste de object storage en la nube pública | Sí; el coste es la **VM, electricidad y tiempo de operación**. |
| Datos bajo vuestro control (RGPD / sensación de control) | Sí, si la VM está en **vuestro entorno** o hosting bajo contrato claro. |
| Servir ficheros a Internet sin pasar por el servidor de aplicación | **No** abrir SMB/NFS a Internet; si hace falta acceso público, usar **nginx** en el servidor de app o **MinIO** con HTTPS y reglas estrictas. |

---

## 4. Cuidados imprescindibles

1. **Copias de seguridad:** OMV no sustituye una política de backup; conviene copias del volumen (otro disco, otro nodo o almacenamiento frío externo).
2. **Seguridad:** acceso a recursos compartidos solo desde **IP del servidor web** o **VPN**; no exponer NFS/SMB a Internet.
3. **Disponibilidad:** una sola VM/NAS es **punto único de fallo**; valorar RAID, snapshots o redundancia según criticidad.
4. **Rendimiento:** muchas miniaturas en listados implica muchas lecturas; la red entre la app y OMV debe ser **estable** (idealmente misma red, 1 Gbps si es posible).

---

## 5. Resumen de decisión

| Prioridad | Opción razonable |
|-----------|------------------|
| **Simplicidad** | Compartido NFS/SMB en OMV montado en el servidor de la aplicación y rutas (o symlinks) apuntando ahí. |
| **Diseño tipo “nube” sin AWS** | **MinIO en la VM OMV** + disco `s3` en Laravel. |
| **Solo respaldo** | OMV como **destino de rsync** u otras copias programadas. |

---

## 6. Relación con otros documentos

- **`docs/almacenamiento-documentos-nube.md`** — Alternativas en la nube (S3, R2, costes, CDN). OMV puede **complementar** (backup) o **sustituir** la nube si la conectividad y la operación lo permiten.

---

*Documento interno — BMLaguna.*
