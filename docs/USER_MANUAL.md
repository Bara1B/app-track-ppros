# User Manual – app-track-ppros

This app is a Laravel application that runs with Docker Compose and uses Vite for asset bundling. Below are the minimal, repeatable steps to set up, run, and maintain the app.

---

## 1) Prerequisites
- Docker Desktop (latest) installed and running
- Node.js LTS + npm (for Vite build/dev on host)
- Git (optional)

---

## 2) First-time setup
From the project root: `app-track-ppros/`

1. Copy Docker env (required during build):
   ```bash
   cp .env.docker .env
   ```
   Alternatively, you can pass the variables inline on each build:
   ```bash
   WWWUSER=501 WWWGROUP=20 docker compose up -d --build
   ```

2. Build and start containers:
   ```bash
   docker compose up -d --build
   ```

3. Install frontend dependencies (on host):
   ```bash
   npm install
   ```

4. Generate app key and run migrations (inside container):
   ```bash
   docker compose exec laravel php artisan key:generate
   docker compose exec laravel php artisan migrate
   ```

5. Seed data (optional but recommended):
   - Default seeder:
     ```bash
     docker compose exec laravel php artisan db:seed
     ```
   - Overmate data note: `OvermateSeeder` is NOT included in `DatabaseSeeder`. Run it manually if needed:
     ```bash
     docker compose exec laravel php artisan db:seed --class=OvermateSeeder
     ```

Database connection (inside code/.env):
- Host: `mysql`
- User: `sail`
- Password: `password`

---

## 3) Daily development workflow

- Start containers (fast):
  ```bash
  docker compose up -d
  ```

- Enter the Laravel container shell:
  ```bash
  docker compose exec laravel bash
  ```

- Run common Artisan commands:
  ```bash
  docker compose exec laravel php artisan migrate
  docker compose exec laravel php artisan optimize
  docker compose exec laravel php artisan tinker
  ```

- Run Vite dev server (on host):
  ```bash
  npm run dev
  ```
  This provides hot-reload for assets. Keep it running during development.

- Build production assets (on host):
  ```bash
  npm run build
  ```

---

## 4) Start/Stop

- Start (create if needed):
  ```bash
  docker compose up -d
  ```

- Rebuild + start:
  ```bash
  docker compose up -d --build
  ```

- Stop and remove containers + networks:
  ```bash
  docker compose down
  ```

- Stop without removing:
  ```bash
  docker compose stop
  ```

- Start previously created containers:
  ```bash
  docker compose start
  ```

---

## 5) Logs and health checks

- Docker engine check:
  ```bash
  docker info
  ```

- App logs:
  ```bash
  docker compose logs -f
  ```

- Laravel logs (inside container):
  ```bash
  docker compose exec laravel tail -f storage/logs/laravel.log
  ```

---

## 6) Database quick reference

- Service: MySQL
- Host: `mysql`
- User: `sail`
- Password: `password`

Connect from host (example using mysql-client, if available):
```bash
mysql -h 127.0.0.1 -P 3306 -u sail -ppassword
```
(Adjust port if your compose maps MySQL to a non-default port.)

---

## 7) Troubleshooting

- WWWUSER/WWWGROUP required during build
  - Symptom: build fails due to missing environment variables
  - Fix: either copy `.env.docker` to `.env` before `up --build`, or run:
    ```bash
    WWWUSER=501 WWWGROUP=20 docker compose up -d --build
    ```

- Vite dev not updating
  - Ensure `npm run dev` is running on the host
  - Clear Laravel caches:
    ```bash
    docker compose exec laravel php artisan cache:clear
    docker compose exec laravel php artisan view:clear
    docker compose exec laravel php artisan config:clear
    ```

- Permission or cache issues
  - Run optimize clear/regenerate:
    ```bash
    docker compose exec laravel php artisan optimize:clear
    docker compose exec laravel php artisan optimize
    ```

- Port in use / container won’t start
  - Check running containers/ports:
    ```bash
    docker ps
    docker compose logs
    ```
  - Stop conflicting services or change port mappings in `docker-compose.yml`.

- Seeder not running
  - If data from Overmate is missing, run:
    ```bash
    docker compose exec laravel php artisan db:seed --class=OvermateSeeder
    ```

---

## 8) Common commands (cheat sheet)

```bash
# Build + start
cp .env.docker .env && docker compose up -d --build

# Start already-built containers
docker compose up -d

# Laravel commands
docker compose exec laravel php artisan migrate

docker compose exec laravel php artisan db:seed

docker compose exec laravel php artisan db:seed --class=OvermateSeeder

# Vite
npm run dev
npm run build

# Stop
docker compose down
```

---

## 9) Support
If you run into issues, share:
- Output of `docker compose ps` and `docker compose logs`
- `storage/logs/laravel.log` tail output
- Your exact command(s) and recent code changes
