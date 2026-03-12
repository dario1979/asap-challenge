# ASAP Challenge - Sistema de Blog

Este proyecto es una API de blog desarrollada con Laravel 12, que incluye gestión de artículos, categorías y autenticación JWT.

## Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM (opcional, para compilación de assets si fuera necesario)

## Pasos para la Instalación

1. **Clonar el repositorio:**

    ```bash
    git clone <url-del-repositorio>
    cd asap-challenge
    ```

2. **Instalar dependencias de PHP:**

    ```bash
    composer install
    ```

3. **Configurar el archivo de entorno:**
   Copia el archivo de ejemplo y configuralo con tus credenciales de base de datos en el archivo `.env`:

    ```bash
    cp .env.example .env
    ```

4. **Generar la clave de la aplicación:**

    ```bash
    php artisan key:generate
    ```

5. **Configurar la base de datos:**
   Asegurate de tener creada la base de datos que definiste en el `.env` (por defecto `asap_challenge`).

6. **Ejecutar migraciones y seeders:**
   Esto creará las tablas necesarias y cargará datos de prueba (incluyendo usuarios):

    ```bash
    php artisan migrate --seed
    ```

7. **Generar la clave secreta de JWT:**
   Necesaria para manejar la autenticación de usuarios:
    ```bash
    php artisan jwt:secret
    ```

## Cómo Correr el Sistema

1. **Iniciar el servidor de desarrollo:**

    ```bash
    php artisan serve
    ```

    La API estará disponible por defecto en `http://localhost:8000`.

2. **Endpoints principales:**
    - **Autenticación**: `POST /api/login`, `POST /api/logout`, `GET /api/me`
    - **Artículos**: `GET /api/articles`, `POST /api/articles`, `PUT /api/articles/{id}`, `DELETE /api/articles/{id}`
    - **Categorías**: `GET /api/categories`
