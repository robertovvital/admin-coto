# Admin Coto 🏘️

Sistema web para la administración de cotos residenciales. Digitaliza el registro de residentes, control de pagos de mantenimiento y seguimiento de adeudos.

## Tecnologías

- **Laravel 12** — Framework PHP
- **PHP 8.2** — Lenguaje backend
- **SQLite** — Base de datos (configurable a MySQL)
- **Tailwind CSS** — Estilos y componentes UI
- **Vite** — Bundler de assets
- **Laravel Breeze** — Autenticación
- **REST Countries API** — Datos internacionales de residentes

---

## Módulos del sistema

| Módulo | Descripción |
|---|---|
| Dashboard | Resumen general: pagos, adeudos, residentes |
| Cotos | CRUD de cotos residenciales |
| Residentes | CRUD con integración de API REST Countries |
| Pagos | Registro y historial de pagos de mantenimiento |
| Adeudos | Vista de residentes con pagos pendientes/vencidos |
| Reportes | Reportes por fechas, por coto y financiero anual |

---

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- XAMPP (o cualquier servidor con PHP y MySQL/SQLite)

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/admin-coto.git
cd admin-coto

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Ejecutar migraciones y datos de prueba
php artisan migrate --seed

# 6. Compilar assets
npm run build

# 7. Iniciar servidor
php artisan serve
```

Accede en: `http://localhost:8000`

---

## Credenciales de prueba

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | admin@admincoto.com | password |
| Empleado | empleado@admincoto.com | password |

---

## Estructura del proyecto

```
app/
├── Http/Controllers/
│   ├── Api/CountryController.php   # Integración REST Countries
│   ├── CotoController.php
│   ├── DashboardController.php
│   ├── PagoController.php
│   ├── ReporteController.php
│   └── ResidenteController.php
├── Models/
│   ├── Coto.php
│   ├── Pago.php
│   ├── Residente.php
│   └── User.php
database/
├── migrations/                     # Esquema de base de datos
└── seeders/DatabaseSeeder.php      # Datos de prueba
resources/
├── css/app.css                     # Tailwind CSS + componentes
└── views/
    ├── layouts/app.blade.php       # Layout principal con navbar
    ├── dashboard.blade.php
    ├── cotos/
    ├── residentes/
    ├── pagos/
    └── reportes/
routes/
├── web.php                         # Rutas web protegidas
└── api.php                         # API REST Countries proxy
```

---

## API REST Countries

El sistema consume `https://restcountries.com/v3.1` a través de un proxy interno en `/api/countries`.

Al registrar o editar un residente, al seleccionar el país se autocompletan:
- Nombre oficial del país
- Capital
- Moneda
- Idioma(s)
- Zona horaria
- Bandera (imagen)

Los datos se cachean por 1 hora para optimizar las peticiones.

---

## Roles de usuario

| Rol | Acceso |
|---|---|
| `administrador` | Acceso completo al sistema |
| `empleado` | Registro y consulta de pagos |
| `residente` | Consulta de sus propios pagos |

---

## Relación principal del sistema

```
COTO → RESIDENTE → PAGO
```

---

## Componentes Tailwind CSS implementados

1. **Navbar responsive** — Con menú hamburguesa para mobile, links activos y dropdown de usuario
2. **Cards de dashboard** — Tarjetas de estadísticas con iconos y colores por categoría
3. **Formularios estilizados** — Inputs, selects, labels y mensajes de error con clases personalizadas

---

## Licencia

MIT
