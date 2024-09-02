
# **GymBros Project**

Es un sistema web para gestión de un gimnasio usando como frameworks Laravel 11.15, Vue 3.4 y TailwindCSS 3.2 diseñado para optimizar el registro de miembros, el seguimiento de la asistencia, la gestión de horarios y la gestión de pagos. El sistema ofrece una interfaz intuitiva tanto para los administradores del gimnasio como para los miembros, con el objetivo de mejorar la experiencia general y la eficiencia operativa del gimnasio.




## *Instalación*

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/NarutoGM/GymBros.git
   cd GymBros
   ```
2. **Instalar dependencias:**
   ```bash
   npm install
   composer install
   ```
3. **Crear archivo .env en la carpeta GymBros:**
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:6m3/sEU1AlY2cWwF72rWRC7GKvRr9ZrjCYDEOueEO20=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
 DB_HOST= // host
 DB_PORT= // puerto
 DB_DATABASE= // nombre de tu base de datos
 DB_USERNAME= // usuario
 DB_PASSWORD= // contraseña
DB_COLLATION=utf8mb4_unicode_ci

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
 ```
4. **Ejecutar el proyecto:**
   ```bash
   php artisan serve
   npm run dev
   ```