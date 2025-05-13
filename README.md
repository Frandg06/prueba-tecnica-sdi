# Prueba Técnica – Laravel + MySQL (Docker)

> **Objetivo**: Guía rápida para clonar el proyecto, configurar las variables de entorno y levantarlo en local usando Docker Compose.

---

## Requisitos previos

| Herramienta        | Versión recomendada | Notas                                                  |
| ------------------ | ------------------- | ------------------------------------------------------ |
| **Git**            | ≥ 2.30              | Para clonar el repositorio.                            |
| **Docker**         | ≥ 24 ⚙︎             | Incluye Docker Engine y Docker CLI.                    |
| **Docker Compose** | ≥ 2.20              | Suele venir integrado a partir de Docker Desktop v2.5. |

> ⚠️ **No necesitas instalar PHP ni MySQL** en tu máquina host; ambos se ejecutan en contenedores.

---

## 1 · Clonar el repositorio

```bash
git clone https://github.com/Frandg06/prueba-tecnica-sdi.git
cd prueba-tecnica-sdi
```

---

## 2 · Copiar y editar el archivo `.env`

Laravel utiliza un archivo de variables de entorno para la configuración. Desde ahi puedes configurar las claves de Spotify y otros parámetros de tu aplicación.

Las claves de la base de datos se encuentran en el archivo `.env.example` y deben en caso de ser modificadas se debe actualizar también el archivo `docker-compose.yml`.
y ejecutar `docker-compose up -d --build` para actualizar los contenedores.

Ejecute el siguiente comando para copiar el archivo `.env.example` y crear el archivo `.env`:

```bash
cp .env.example .env
```

### Variables mínimas a ajustar

> 🔑 **¿No tienes claves de Spotify?** Puedes utilizar las que se adjuntan en el archivo `claves.txt` en el correo enviado adjunto a la prueba.

| Clave                   | Valor de ejemplo       | ¿Dónde conseguirlo?                                                     |
| ----------------------- | ---------------------- | ----------------------------------------------------------------------- |
| `SPOTIFY_CLIENT_ID`     | `xxxxxxxxxxxxxxxxxxxx` | [Spotify Developer Dashboard](https://developer.spotify.com/dashboard/) |
| `SPOTIFY_CLIENT_SECRET` | `yyyyyyyyyyyyyyyyyyyy` | Mismo panel                                                             |

---

## 3 · Levantar los contenedores

```bash
# Descarga las imágenes y arranca todo en segundo plano
docker compose up -d --build
```

-   Contenedor **sdi_app** → Laravel
-   Contenedor **sdi_db** → MySQL 8

> **Primera ejecución**: cuando los contenedores se levantan por primera vez, la base de datos se encuentra vacía.
>
> Para generar la base de datos usando las migraciones definidas en el proyecto, ejecuta:
>
> ```bash
> docker compose exec sdi_app php artisan migrate:fresh
> ```

## 4 · Acceder a la aplicación

| Servicio                  | URL por defecto                                                                  |
| ------------------------- | -------------------------------------------------------------------------------- |
| **API / Backend Laravel** | [http://localhost:8888/api/v1](http://localhost:8888/api/v1)                     |
| **DOCUMENTACIÓN**         | [http://localhost:8888/docs](http://localhost:8888/docs)                         |
| **MySQL (CLI o IDE)**     | host `127.0.0.1`, puerto `3333`, usuario `sdi`, contraseña la indicada en `.env` |

Si no has tocado nada, el puerto de acceso deberia ser 8888 que se define en el `docker-compose.yml`.

### Verificar que los tests funcionan correctamente

Puedes ejecutar los tests definidos en el proyecto con el siguiente comando:

```bash
docker compose exec app php artisan test
```

Esto te permitirá verificar que las funcionalidades principales están correctamente implementadas y que el entorno está funcionando como se espera.

> 🧪 **Nota**: Me hubiera gustado crear una batería de tests más completa para los servicios que interactúan con la API de Spotify. Sin embargo, debido a compromisos laborales no tuve tiempo suficiente para implementarlos adecuadamente.

---
