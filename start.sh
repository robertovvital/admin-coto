#!/bin/bash
set -e

# Crear la base de datos SQLite si no existe
touch /app/database/database.sqlite

# Ejecutar migraciones
php artisan migrate --force

# Sembrar datos solo si la tabla users está vacía
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
