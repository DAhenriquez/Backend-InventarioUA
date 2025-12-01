# Backend - Sistema de Inventario ICINF UA

Este es el backend del sistema de inventarioUA desarrollado en **Laravel 11** utilizando **SQLite** como base de datos. Provee una API REST protegida con **Sanctum** para gestionar componentes, préstamos y usuarios.

## Requisitos Previos

Asegúrate de tener instalado en tu computadora:

  * [PHP](https://www.php.net/) (Versión 8.2 o superior)
  * [Composer](https://getcomposer.org/)
  * [Git](https://git-scm.com/)

-----

## Cómo Instalar 

1.  **Clonar el repositorio:**

    ```bash
    git clone https://github.com/DAhenriquez/Backend-InventarioUA.git
    cd Backend-InventarioUA
    ```

2.  **Instalar dependencias de PHP:**

    ```bash
    composer install
    ```

3.  **Configurar el entorno:**
    Duplica el archivo de ejemplo y nómbralo `.env`:

    ```bash
    cp .env.example .env
    ```

4.  **Configurar Base de Datos (SQLite):**
    Abre el archivo `.env` y busca la sección de base de datos. Modifícala para que quede así (borra las configuraciones de MySQL):

    ```ini
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # ... borra el resto de líneas DB_ ...
    ```

    Luego, crea el archivo de base de datos vacío:

      - **En Mac/Linux:** `touch database/database.sqlite`
      - **En Windows:** Crea un archivo vacío llamado `database.sqlite` dentro de la carpeta `database`.

5.  **Generar clave de aplicación:**

    ```bash
    php artisan key:generate
    ```

-----

## Cómo ejecutar Migraciones y Seeds

Para crear las tablas e insertar los datos de prueba (Usuario Admin, Alumnos y Componentes), ejecuta:

```bash
php artisan migrate:fresh --seed
```

> **Importante!!!:** Este comando borra la base de datos y la vuelve a crear desde cero. Úsalo con cuidado si ya tienes datos reales.

### Credenciales por defecto (Admin)

Al ejecutar el comando anterior, se crea el siguiente usuario administrador para hacer login:

  * **Email:** `admin@admin`
  * **Contraseña:** `admin`

-----

## Cómo levantar el servidor

Para iniciar el servidor de desarrollo local:

```bash
php artisan serve
```

El backend estará disponible en: `http://127.0.0.1:8000`

-----

## Documentación de la API

Todas las rutas (excepto Login) requieren que envíes el **Token** en el Header de la petición:

  * **Header:** `Authorization`
  * **Valor:** `Bearer <tu_token_aqui>`
  * **Header:** `Accept: application/json`

### Autenticación

| Método | Endpoint | Descripción | Cuerpo (JSON) |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | Iniciar sesión y obtener Token | `{ "email": "...", "password": "..." }` |
| `POST` | `/api/logout` | Cerrar sesión (revocar token) | *(Requiere Token)* |

### Inventario (Componentes)

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/componentes` | Obtener lista de todos los componentes y su stock. |
| `POST` | `/api/componentes` | Crear un nuevo componente. Requiere JSON con `nombre`, `cantidad`, `inventario`, `imagen` (url o nombre archivo). |

### Préstamos

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/prestamos` | Ver lista de préstamos activos. |
| `POST` | `/api/prestamos` | Crear un préstamo (Resta stock automáticamente). Body: `{ "rut": "...", "component_id": 1, "cantidad": 1 }` |
| `PUT` | `/api/prestamos/{id}/devolver` | Marcar como devuelto (Suma stock automáticamente). |

### Dashboard y Usuarios

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/users` | Lista de todos los usuarios registrados (Alumnos y Admins). |
| `GET` | `/api/bajas` | Lista de componentes eliminados/dados de baja. |

-----

## Deploy (Koyeb)

Este proyecto está configurado para desplegarse en **Koyeb** usando Buildpacks.
Asegúrate de configurar las siguientes **Variables de Entorno** en el panel de Koyeb:

  * `APP_KEY`: (Copia la de tu .env local)
  * `DB_CONNECTION`: `sqlite`
  * `DB_DATABASE`: `database/database.sqlite`
  * `SESSION_DRIVER`: `file`
  * **Run Command:** `touch database/database.sqlite && php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=8000`
