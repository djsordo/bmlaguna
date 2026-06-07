# Despliegue en producción (explotación)

Servidor de referencia: **Ubuntu 20.04**, aplicación en **`/var/www/bmlaguna`**, **Nginx** + **PHP 7.3-FPM** (`php7.3-fpm`).

Antes de desplegar: asegurarse de que el código está en **`master`** y mergeado en el remoto.

## Procedimiento estándar

Conectarse por SSH y ejecutar (como usuario con permisos sobre el proyecto; en el servidor habitualmente `root`):

```bash
cd /var/www/bmlaguna
```

### 1. Mantenimiento (opcional pero recomendado)

```bash
php artisan down
```

### 2. Código

```bash
git fetch --all --prune
git checkout master
git pull --ff-only
git log -1 --oneline
```

### 3. Dependencias (producción)

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
```

### 4. Migraciones

```bash
php artisan migrate --force
```

### 5. Cachés

**No usar `php artisan route:cache`** en este proyecto: falla por rutas que usan *closures* (por ejemplo `api/user`). Sí se pueden cachear configuración y vistas:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan view:cache
```

### 6. Servicios

```bash
systemctl reload php7.3-fpm
systemctl reload nginx
```

### 7. Fin de mantenimiento

```bash
php artisan up
```

### 8. Comprobaciones rápidas

```bash
php artisan migrate:status | tail -n 15
curl -I http://127.0.0.1/tecnicos
```

Ajusta la URL o el host si comprobáis por dominio público.

---

## Tabla `migrations` (baseline en producción)

Si en algún momento `php artisan migrate --force` intenta crear tablas que **ya existen**, suele indicar que la tabla **`migrations`** estaba vacía o desincronizada respecto a la BD real.

En ese caso se puede alinear marcando como ejecutadas las migraciones del disco **sin volver a ejecutarlas** (por ejemplo insertando los nombres de archivo de `database/migrations` en `migrations` con un `batch` alto, p. ej. `9999`). Eso se hace **una vez** por servidor, con backup previo de la base de datos.

Después de eso, los despliegues futuros vuelven a usar solo `php artisan migrate --force` como en la sección anterior.

---

## Notas

- **APP_URL**: debe coincidir con el dominio público (p. ej. `http://bmlaguna.duckdns.org`). Los enlaces firmados de preinscripción del correo se generan con esta URL; si es incorrecta, los enlaces del email no funcionarán.
- **PHP-FPM**: el servidor puede tener varios (`php8.0-fpm`, etc.); el sitio que sirve esta app debe usar **`php7.3-fpm`** (comprobar `fastcgi_pass` en la config de Nginx del virtual host).
- **Colas / Supervisor**: si en el futuro se usan colas, añadir `php artisan queue:restart` y el reinicio de Supervisor según corresponda.
