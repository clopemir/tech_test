# Proyecto Laravel y Vue.js

**Descripción:**
Aplicación web que simula funciones CRUD de Posts y Comentarios para Prueba Tecnica.

**Requisitos previos:**
* PHP >= 8.0 o mayor
* Composer
* Node.js y npm (o yarn)
* Base de datos: SQLite o MySQL

**Instalación:**
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/clopemir/tech_test.git

2. Instalar dependencias:
   ```bash
    cd tu-repositorio
    composer install
    npm install

3. Configurar archivo .env:
   ```bash
    Copiar .env.example a .env y configurar las variables.

    Si Creas tu BD en MySQL:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tu_base_de_datos
    DB_USERNAME=usuario
    DB_PASSWORD=contraseña

    Si usas SQLite:

    DB_CONNECTION=sqlite
    # DB_HOST=
    # DB_PORT=
    # DB_DATABASE=
    # DB_USERNAME=
    # DB_PASSWORD=


4. Ejecutar comandos Artisan:
   ```bash
    php artisan key:generate
    php artisan migrate

5. Ejecutar Localmente:
   ```bash
    php artisan serve
    npm run dev

**Acceso:**
* Ahora puedes acceder desde http://localhost:8000
* Desde la página de inicio puedes comenzar a crear Posts.
* Al crear un nuevo post tienes las opciones de editar o borrar, al dar clic sobre el nombre del mismo, puedes acceder a los detalles del post y añadir comentarios.
