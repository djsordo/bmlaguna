# WhatsApp y la aplicación BMLaguna — Opciones técnicas

Documento orientado a decisión: uso de números de teléfono de miembros y posibilidades de contacto por WhatsApp.

---

## 1. Situación actual en la aplicación

Los teléfonos de los miembros ya están recogidos de forma estructurada:

- Tabla **teléfonos** (relación con miembro): número y descripción (p. ej. móvil, fijo).
- Se gestionan desde las fichas de miembro y flujos relacionados (incluida preinscripción).

Eso permite usar esos datos como base de destinatarios, siempre que el formato sea válido para el canal elegido.

---

## 2. Dos niveles distintos de “enviar WhatsApp”

### A) Enlaces `wa.me` (sin API de WhatsApp Business)

Es un **enlace web** que, al abrirlo, intenta abrir WhatsApp con:

- Un chat dirigido al **número internacional** indicado en la URL.
- Opcionalmente, un **texto pre-rellenado** en el cuadro de mensaje (la persona revisa y pulsa “Enviar”).

Ejemplo de formato:

```text
https://wa.me/34612345678?text=Mensaje%20codificado%20en%20URL
```

- El número va **sin** `+`, **sin** espacios ni guiones, con prefijo de país (España: `34`).
- El texto debe ir **codificado en URL**.

**Importante — quién aparece como remitente**

`wa.me` **no envía nada desde un servidor**. Abre WhatsApp en **el dispositivo de quien hace clic**.

- El mensaje sale desde **la cuenta de WhatsApp activa** en ese momento (móvil o WhatsApp Web vinculado).
- Si quien gestiona la campaña usa su WhatsApp **personal**, el jugador verá ese número **personal**, no el del club.
- Para que el mensaje salga **desde el número del club**, quien envíe debe usar WhatsApp (o WhatsApp Business) **con ese número** (p. ej. el móvil del club).

**No es obligatorio** tener “cuenta de empresa” de Meta para usar `wa.me`; lo que define el remitente es **qué sesión de WhatsApp** está usando quien envía.

| Ventajas | Límites |
|----------|---------|
| Implementación sencilla en la web (botones, listas). | No hay envío automático desde el servidor; hace falta **acción humana** (abrir y enviar). |
| Sin coste de API ni alta en Meta Business para este modo. | No queda registro automático en la aplicación de “mensaje enviado” salvo que se diseñe aparte. |
| Encaja con campañas puntuales y listas por equipo. | Mensajes muy largos pueden dar problemas; conviene textos razonables y números bien normalizados (formato internacional). |

### B) API oficial de WhatsApp (Meta Cloud API o proveedor: Twilio, 360dialog, etc.)

- Permite **envío real desde el servidor**, plantillas para mensajes fuera de la ventana de 24 horas, y trazabilidad.
- Requiere **cuenta de negocio**, número verificado, cumplimiento de políticas de WhatsApp y **coste** según proveedor y volumen.
- Encaja con **automatización** (avisos programados, muchos destinatarios sin abrir uno a uno).

---

## 3. Encaje con los usos que plantea el club

Escenarios mencionados: campañas (p. ej. preinscripción), avisos a jugadores de un **equipo concreto** (reconocimientos médicos, horario y sede de partidos, etc.).

| Objetivo | Enlaces `wa.me` | API oficial |
|----------|-----------------|-------------|
| Botón “Contactar por WhatsApp” en ficha o preinscripción, texto ya redactado | **Muy adecuado** | Posible pero innecesariamente complejo si basta con un clic del staff |
| Lista de un equipo: mismo aviso para muchos jugadores (enlaces por fila) | **Adecuado**: el staff recorre la lista; evita copiar números a mano | Mejor si el volumen es muy alto y se quiere sin intervención |
| Envío automático a hora fija o masivo sin que nadie pulse nada | **No cubierto** por `wa.me` | **Aquí sí** |

---

## 4. Normalización de números

En base de datos los teléfonos pueden estar en formatos variados. Para `wa.me` (y para cualquier API futura) conviene:

- Pasar a formato **internacional E.164** (p. ej. `+34612345678` en lógica interna; en la URL de `wa.me` el mismo número **sin** el `+`).
- Decidir qué hacer si un miembro tiene **varios** teléfonos (p. ej. priorizar “móvil” o el primero).

---

## 5. Privacidad y comunicaciones (RGPD)

Independientemente de la técnica:

- Los datos de contacto deben usarse con **finalidad legítima** y transparencia.
- Comunicaciones comerciales o masivas pueden requerir **consentimiento** u otra base legal según el caso.
- Conviene poder documentar el criterio del club (p. ej. qué mensajes se envían y con qué finalidad).

---

## 6. Contactos en el WhatsApp de origen (operativa)

En la práctica, conviene distinguir:

- El enlace `wa.me` **apunta a un número**; en muchos casos el chat se abre **aunque ese número no esté guardado** en la agenda del móvil que envía.
- Si en el día a día se observa que **va mejor tener el número guardado**, suele deberse a: **comodidad** (nombre del jugador o tutor en lugar de solo dígitos), **WhatsApp Web** vinculado a un teléfono cuya agenda alimenta la experiencia, o **diferencias entre versiones** de la app.

**Recomendación:** en el **móvil del club**, ir guardando los números a los que se escribe con frecuencia (por ejemplo en una carpeta de contactos “Club”), para alinear el historial de WhatsApp con los datos de la aplicación y localizar conversaciones con facilidad.

---

## 7. Grupos

**No** se pueden **crear grupos** con el sistema de enlaces `wa.me`.

- `wa.me` abre un chat **individual** con **un** número (y texto opcional). No existe un parámetro oficial para “crear grupo”, añadir varios participantes ni elegir varios destinatarios a la vez.
- Los **grupos de WhatsApp** se crean **dentro de la app** (nuevo grupo, añadir contactos) o mediante **enlace de invitación al grupo** generado por un administrador.
- La **API de WhatsApp Business** no sustituye el flujo informal de “crear un grupo con todo el equipo” con un clic desde la web; además el uso de grupos y difusión masiva está sujeto a políticas distintas.

**En la práctica:** para un equipo se puede crear **a mano** un grupo en el móvil del club y usarlo para avisos, o seguir con **mensajes uno a uno** desde enlaces por miembro. Para **difusión a muchos** sin grupo, las vías habituales son **API + plantillas**, **canales** (donde aplique y con cuenta de negocio) u otros canales (correo, etc.), no `wa.me` hacia un grupo.

---

## 8. ¿Se puede enviar un mensaje a un grupo?

**Con el mismo mecanismo `wa.me` que para personas: no.** Ese enlace está pensado para **un número de teléfono** (chat 1 a 1), no para un grupo.

**Qué existe aparte**

- **Enlace de invitación al grupo** (`https://chat.whatsapp.com/...`): lo genera un administrador en WhatsApp → *Invitar con enlace*. Sirve para **entrar al grupo** o **abrirlo** si ya se es miembro; **no** equivale a un “envío” desde la aplicación con destinatario = grupo como en `wa.me`.
- El parámetro `?text=` de `wa.me` **no** está pensado para publicar en un grupo; el flujo útil con `wa.me` es el **individual**.

**Conclusión:** enviar un mensaje “al grupo” **no** se hace con `wa.me` hacia el grupo. Lo habitual es **abrir el grupo en WhatsApp** (acceso directo, enlace de invitación o acceso manual) y **escribir ahí** el mensaje, o copiar/pegar un texto generado por la aplicación. La API de WhatsApp Business plantea **otros modelos** (mensajes a usuarios, casos empresariales); no un sustituto sencillo de “enviar a este grupo” como un `wa.me` por grupo.

---

## 9. Qué más se puede hacer con el sistema de enlaces (además de escribir a un móvil)

Todo lo siguiente asume el mismo tipo de solución (**enlaces que abren WhatsApp**, principalmente `wa.me`), **sin** contar con envío invisible desde el servidor: alguien abre el enlace y confirma en WhatsApp.

### Posibilidades que encajan con `wa.me`

1. **Abrir el chat sin mensaje** — Misma URL **sin** `?text=` (o sin texto): solo abre la conversación con ese número.

2. **Textos distintos según contexto** — Mismo mecanismo para **plantillas**: preinscripción, recordatorio médico, horario de partido, etc., cambiando el texto en la URL (variables generadas en la aplicación: nombre, fecha, equipo).

3. **Enlace “Contactar al club”** — Un `wa.me` al **número del club** (no al jugador): las familias pulsan y escriben al club. Flujo **inverso** al de contactar a cada miembro.

4. **Reutilizar el enlace en muchos soportes** — Los enlaces funcionan en **web, PDF, correos, intranet** y en **códigos QR** (el QR apunta a la misma URL). Útil para carteles, carnets o documentos generados por la app.

5. **Atajos operativos** — Listados con un enlace por fila (como en la lista de miembros), columnas en **exportaciones** o informes con la URL ya montada, para que el personal **recorra** contactos sin copiar números a mano.

6. **Compartir desde el móvil** — En muchos dispositivos, abrir el enlace abre directamente la app de WhatsApp.

### Relacionado pero distinto

- **Enlace de grupo** (`https://chat.whatsapp.com/...`): para **unirse o abrir un grupo**, no para sustituir el envío 1 a 1 con `wa.me`.

### Lo que no ofrece solo este sistema de enlaces

- Envíos **programados** o **masivos sin clic**, **estadísticas** de entrega en base de datos propia, **respuestas automáticas** o integración tipo CRM **seria** → eso apunta a la **API de WhatsApp Business** u otros canales.

En resumen: con enlaces se puede **personalizar destinatarios y mensajes**, **reutilizarlos en QR, correos y documentos** y **facilitar el contacto hacia el club**; el valor añadido es **comodidad y contexto**, no nuevas capacidades “invisibles” de WhatsApp detrás del servidor.

---

## 10. Resumen para decisión

1. **Solo enlaces `wa.me`** desde la aplicación: **viable**, económico y rápido de implementar, adecuado si el club acepta que un **responsable** envíe desde el **móvil del club** (o la sesión correcta) y, si hace falta, **recorra** listas por equipo o preinscripción.
2. **Automatización real y envíos masivos sin intervención**: requiere **API oficial** (y cuenta de negocio), no se sustituye de forma fiable solo con `wa.me`.
3. El hecho de que el club tenga un **móvil propio** sin “cuenta empresa” **no impide** usar `wa.me`; lo que importa es **desde qué WhatsApp** se pulse “Enviar” al usar esos enlaces.
4. **Grupos y mensajes al grupo** no se cubren con `wa.me`; la operativa de grupos es **dentro de WhatsApp** o con **enlaces de invitación**, no con el mismo truco que para números individuales.

---

*Documento generado para revisión con el cliente — aplicación BMLaguna (Laravel, datos de miembros en tabla `telefonos`).*
