# HTTPS Setup untuk Laravel WO Tracker

## 📋 Deskripsi
Setup ini mengkonfigurasi aplikasi Laravel WO Tracker untuk berjalan dengan HTTPS menggunakan Docker dan NGINX sebagai reverse proxy.

## 🔧 Komponen Setup

### 1. SSL Certificates
- **Lokasi**: `docker/nginx/ssl/`
- **Files**: 
  - `localhost+2.pem` (Certificate)
  - `localhost+2-key.pem` (Private Key)
- **Generated menggunakan**: `mkcert` untuk trusted local development

### 2. Docker Services
- **Laravel**: PHP-FPM container untuk menjalankan aplikasi
- **NGINX**: Web server dengan SSL termination
- **MySQL**: Database server (tetap sama)
- **phpMyAdmin**: Database management tool

### 3. NGINX Configuration
- **File**: `docker/nginx/default.conf`
- **Features**:
  - HTTP to HTTPS redirect
  - SSL/TLS configuration
  - Security headers
  - Static file handling
  - PHP-FPM integration

## 🚀 Cara Penggunaan

### Mode HTTPS (Full Docker)
```bash
# Start dengan HTTPS
./start-https.sh

# URLs:
# - Laravel: https://localhost
# - phpMyAdmin: http://localhost:8081
# - Vite Dev: https://localhost:5173
```

### Mode HTTP (Standalone Laravel)
```bash
# Start dengan HTTP (minimal Docker)
./start-http.sh

# Kemudian jalankan Laravel dan Vite secara terpisah:
php artisan serve  # http://127.0.0.1:8000
npm run dev        # http://127.0.0.1:5173
```

## 📁 File Konfigurasi

### Environment Files
- `.env.backup` - Original HTTP configuration
- `.env.https` - HTTPS configuration untuk standalone
- `.env.docker` - HTTPS configuration untuk Docker

### Scripts
- `start-https.sh` - Setup dan start HTTPS mode
- `start-http.sh` - Setup dan start HTTP mode

## 🔒 Security Features

### SSL/TLS
- TLS 1.2 dan 1.3 support
- Strong cipher suites
- Session caching
- Perfect Forward Secrecy

### HTTP Security Headers
- X-Frame-Options: SAMEORIGIN
- X-XSS-Protection: 1; mode=block
- X-Content-Type-Options: nosniff
- Referrer-Policy: no-referrer-when-downgrade
- Content-Security-Policy: default-src 'self'

## 🛠️ Development Workflow

### 1. HTTPS Development
```bash
./start-https.sh  # Start semua services
npm run dev       # Start Vite dengan HTTPS
```

### 2. HTTP Development (Existing)
```bash
./start-http.sh   # Start hanya MySQL
php artisan serve # Start Laravel
npm run dev       # Start Vite dengan HTTP
```

## 📝 Notes

- SSL certificates valid sampai November 2027
- HTTPS mode menggunakan port 443 dan 80 (redirect)
- HTTP mode menggunakan port 8000 untuk Laravel
- Database selalu accessible di port 3307
- phpMyAdmin selalu accessible di port 8081

## 🔧 Troubleshooting

### Certificate Issues
```bash
# Regenerate certificates
cd docker/nginx/ssl
mkcert localhost 127.0.0.1 ::1

# Copy to system location
sudo cp localhost+2* /etc/nginx/ssl/
```

### Docker Issues
```bash
# Rebuild containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Permission Issues
```bash
# Fix Laravel permissions
docker-compose exec laravel chown -R www-data:www-data /var/www/storage
docker-compose exec laravel chown -R www-data:www-data /var/www/bootstrap/cache
```

