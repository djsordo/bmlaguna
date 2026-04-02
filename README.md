# BMLaguna

Aplicación Laravel del club.

## Documentación operativa

- [Despliegue en producción (explotación)](docs/ops/despliegue-produccion.md)

## Desarrollo local

```bash
composer install
cp .env.example .env   # si aplica
php artisan key:generate
php artisan migrate
```

Ajusta `.env` con la base de datos y el entorno correspondientes.
