# Fitur Pengaturan Prefix Work Order

## 📋 Deskripsi
Fitur ini memungkinkan admin untuk mengubah prefix nomor awal Work Order dari "86" menjadi prefix lainnya (misalnya "96") melalui interface pengaturan admin, **tanpa mengubah format bagian belakang** yang sudah ada.

## 🔧 Cara Kerja

### 1. Format Nomor WO (Legacy Format)
- **Format**: `PREFIX + 00 + 20 + SEQUENCE + T`
- **Contoh**: 
  - Prefix 86: `86 + 00 + 20 + 01 + T = 86002001T`
  - Prefix 96: `96 + 00 + 20 + 01 + T = 96002001T`

### 2. Komponen Nomor WO
- **PREFIX**: 2 digit (86, 96, dll) - **BISA DIUBAH** via admin settings
- **00**: Kode tetap dari database (tidak bisa diubah)
- **20**: Kode tetap dari database (tidak bisa diubah)
- **SEQUENCE**: 3 digit urutan dari Excel (001, 002, dll) - **tidak bisa diubah**
- **T**: Suffix tetap dari database (tidak bisa diubah)

### 3. Penjelasan Komponen Tetap
- **00**: Kode tetap yang sudah ada di database
- **20**: Kode tetap yang sudah ada di database  
- **SEQUENCE**: Nomor urut dari Excel yang sudah di-seed
- **T**: Suffix yang sudah ada di database

## 🎯 Fitur yang Tersedia

### Admin Settings
- **Lokasi**: `/settings/wo` (hanya untuk admin)
- **Fitur**:
  - Input field untuk mengubah prefix WO (hanya 2 digit pertama)
  - Toggle untuk fitur tracking
  - Toggle untuk fitur stock opname
  - Toggle untuk fitur overmate

### Service Class
- **File**: `app/Services/WONumberService.php`
- **Method**:
  - `generateNextNumber()`: Generate nomor WO dengan format legacy
  - `generateNextNumberWithFormat('T')`: Generate nomor WO dengan format legacy + T
  - `generateLegacyFormat()`: Generate nomor WO dengan format legacy (86002001T)
  - `validateFormat()`: Validasi format nomor WO
  - `parseWONumber()`: Parse komponen nomor WO

### Model Setting
- **File**: `app/Models/Setting.php`
- **Method**:
  - `getWOPrefix()`: Ambil prefix WO saat ini
  - `setWOPrefix()`: Set prefix WO baru
  - `getValue()`: Ambil nilai setting
  - `setValue()`: Set nilai setting

## 🚀 Cara Penggunaan

### 1. Mengubah Prefix via Admin Panel
1. Login sebagai admin
2. Buka `/settings/wo`
3. Ubah nilai "Prefix Nomor Work Order" dari 86 ke 96
4. Klik "Simpan Pengaturan"
5. Prefix akan berubah dan semua WO baru akan menggunakan format 96

### 2. Mengubah Prefix via Code
```php
use App\Models\Setting;

// Set prefix baru
Setting::setWOPrefix('96');

// Ambil prefix saat ini
$prefix = Setting::getWOPrefix(); // Returns: 96
```

### 3. Generate Nomor WO Baru
```php
use App\Services\WONumberService;

// Generate nomor WO dengan format legacy
$woNumber = WONumberService::generateLegacyFormat();
// Jika prefix = 96, hasil: 96002001T
```

### 4. Command Line Testing
```bash
# Generate nomor WO dengan prefix default (86)
php artisan wo:generate-number

# Generate nomor WO dengan prefix custom (96)
php artisan wo:generate-number --prefix=96
```

## 📊 Database Structure

### Tabel Settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) UNIQUE NOT NULL,
    value TEXT NOT NULL,
    type VARCHAR(255) DEFAULT 'string',
    `group` VARCHAR(255) DEFAULT 'general',
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Data Default
- `wo_prefix`: 86 (prefix default)
- `wo_tracking_enabled`: 1 (tracking aktif)
- `stock_opname_enabled`: 1 (stock opname aktif)
- `overmate_enabled`: 1 (overmate aktif)

## 🔄 Workflow

### 1. Admin Mengubah Prefix
```
Admin Panel → Settings → WO Prefix → Update → Database → Cache Clear
```

### 2. Generate WO Baru
```
Form Input → Controller → Legacy Format → Save WO
```

### 3. Validasi Format
```
Input WO Number → WONumberService::validateFormat() → True/False
```

## 🛡️ Security & Validation

### Admin Access
- Hanya user dengan role `admin` yang bisa mengakses settings
- Middleware `AdminMiddleware` melindungi route settings

### Input Validation
- Prefix: Required, string, max 10 karakter
- Boolean settings: Validated as boolean

### Cache Management
- Settings di-cache selama 1 jam untuk performa
- Cache otomatis di-clear saat setting di-update

## 🧪 Testing

### Unit Test
```bash
# Test WONumberService
php artisan test --filter=WONumberService

# Test Setting model
php artisan test --filter=Setting
```

### Manual Test
```bash
# Test generate number
php artisan wo:generate-number

# Test custom prefix
php artisan wo:generate-number --prefix=96
```

## 📝 Contoh Penggunaan

### Scenario 1: Ubah Prefix dari 86 ke 96
1. Admin login ke sistem
2. Buka halaman settings: `/settings/wo`
3. Ubah prefix dari 86 ke 96
4. Simpan pengaturan
5. Buat WO baru → nomor akan menjadi `96002001T`
6. WO berikutnya: `96002002T`, `96002003T`, dst

### Scenario 2: Reset ke Default
1. Admin buka halaman settings
2. Klik tombol "Reset ke Default"
3. Prefix kembali ke 86
4. WO baru akan menggunakan format `86002001T`

## 🔧 Troubleshooting

### Prefix Tidak Berubah
1. Cek apakah user memiliki role admin
2. Clear cache: `php artisan cache:clear`
3. Cek log Laravel untuk error

### Format Nomor Tidak Sesuai
1. Pastikan prefix sudah tersimpan di database
2. Cek apakah WONumberService menggunakan prefix yang benar
3. Test dengan command: `php artisan wo:generate-number`

### Cache Issues
1. Clear cache: `php artisan cache:clear`
2. Clear config: `php artisan config:clear`
3. Restart queue worker jika menggunakan queue

## 📚 Referensi

- **Laravel Documentation**: https://laravel.com/docs
- **Eloquent Models**: https://laravel.com/docs/eloquent
- **Service Classes**: https://laravel.com/docs/services
- **Cache Management**: https://laravel.com/docs/cache
