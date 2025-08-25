# Panduan Pengguna (Non-Teknis) – app-track-ppros

Dokumen ini menjelaskan cara menggunakan aplikasi ini untuk pengguna awam (tanpa istilah teknis). Sertakan tangkapan layar (screenshot) agar langkah-langkah mudah diikuti.

Catatan:
- Simpan semua screenshot di folder: `docs/screenshots/`
- Ganti semua teks `[[gambar-...]]` dengan gambar Anda dan sesuaikan nama filenya.
- Contoh menambahkan gambar di Markdown:
  ```md
  ![Teks alternatif](screenshots/nama-file.png)
  ```

---

## 1. Masuk (Login)
- Buka alamat aplikasi di browser Anda. Contoh: `http://localhost:8000` atau alamat yang diberikan admin.
- Masukkan Email dan Kata Sandi.
- Klik tombol "Masuk".

Screenshot yang disarankan:
- Halaman Login
  ```md
  ![Halaman Login](screenshots/login.png)
  ```

Jika lupa kata sandi, gunakan tautan "Lupa kata sandi" (jika tersedia) atau hubungi admin.

---

## 2. Beranda (Dashboard)
Setelah berhasil login, Anda akan melihat Ringkasan/Statistik utama aplikasi.
- Bagian ini biasanya menampilkan angka ringkas, grafik, atau kartu informasi.
- Gunakan menu di sisi kiri (Sidebar) untuk berpindah halaman.

Screenshot yang disarankan:
- Tampilan Dashboard
  ```md
  ![Dashboard](screenshots/dashboard.png)
  ```

---

## 3. Navigasi dengan Sidebar
Di sisi kiri ada menu (Sidebar) untuk mengakses halaman-halaman utama.
- Klik nama menu untuk masuk ke halaman tersebut.
- Jika ada submenu, klik panah/ikon kecil untuk membukanya.

Screenshot yang disarankan:
- Sidebar terbuka dengan beberapa menu
  ```md
  ![Sidebar Navigasi](screenshots/sidebar.png)
  ```

---

## 4. Mencari dan Menyaring Data
Pada sebagian besar halaman data, tersedia kolom pencarian dan filter.
- Ketik kata kunci pada kotak Pencarian.
- Gunakan Filter (tanggal, status, kategori) untuk mempersempit hasil.
- Tekan Enter atau klik tombol "Cari".

Screenshot yang disarankan:
- Kolom pencarian dan contoh filter
  ```md
  ![Pencarian & Filter](screenshots/search-filter.png)
  ```

Tips:
- Perkecil pencarian dengan menambahkan filter.
- Kosongkan filter untuk menampilkan semua data lagi.

---

## 5. Menambah Data Baru
Jika Anda memiliki izin, akan ada tombol seperti "Tambah", "+ Baru", atau "Create".
- Klik tombol tersebut.
- Isi form yang muncul dengan data yang benar.
- Klik "Simpan".

Screenshot yang disarankan:
- Tombol tambah di halaman daftar
  ```md
  ![Tombol Tambah](screenshots/add-button.png)
  ```
- Form input data
  ```md
  ![Form Input Data](screenshots/form-create.png)
  ```

Catatan:
- Kolom dengan tanda bintang (*) biasanya wajib diisi.
- Jika muncul pesan kesalahan, periksa kolom yang belum benar.

---

## 6. Mengubah dan Menghapus Data
Pada baris data, biasanya terdapat tombol "Edit" (pensil) dan "Hapus" (tempat sampah).
- Edit: Klik tombol Edit, ubah data, lalu Simpan.
- Hapus: Klik tombol Hapus, konfirmasi jika diminta. Tindakan ini mungkin tidak bisa dibatalkan.

Screenshot yang disarankan:
- Tindakan pada baris data (Edit/Hapus)
  ```md
  ![Aksi Edit/Hapus](screenshots/actions-row.png)
  ```

---

## 7. Melihat Detail Data
Klik pada baris atau tombol "Detail" untuk melihat informasi lengkap.
- Halaman detail menampilkan data secara penuh.
- Anda dapat kembali ke daftar dengan tombol "Kembali".

Screenshot yang disarankan:
- Halaman detail
  ```md
  ![Detail Data](screenshots/detail.png)
  ```

---

## 8. Ekspor atau Unduh Laporan (Jika Ada)
Beberapa halaman menyediakan ekspor ke Excel/PDF.
- Cari tombol "Ekspor", "Unduh", atau ikon download.
- Pilih format yang diinginkan.

Screenshot yang disarankan:
- Tombol ekspor
  ```md
  ![Ekspor Data](screenshots/export.png)
  ```

---

## 9. Notifikasi dan Pesan Sistem
Jika aplikasi menampilkan notifikasi (berhasil/gagal), perhatikan pesan yang muncul di bagian atas/kanan layar.
- Notifikasi hijau: Berhasil.
- Notifikasi merah/oranye: Ada kesalahan atau peringatan.

Screenshot yang disarankan:
- Contoh notifikasi
  ```md
  ![Notifikasi](screenshots/notification.png)
  ```

---

## 10. Profil Pengguna dan Keluar (Logout)
- Profil: Klik nama/ikon pengguna untuk mengubah informasi (jika tersedia).
- Keluar: Klik tombol "Logout" untuk keluar dari aplikasi.

Screenshot yang disarankan:
- Menu profil pengguna
  ```md
  ![Profil Pengguna](screenshots/profile.png)
  ```
- Tombol Logout
  ```md
  ![Logout](screenshots/logout.png)
  ```

---

## 11. Tips Penggunaan
- Gunakan browser modern (Chrome/Edge/Firefox terbaru).
- Jika tampilan tidak berubah setelah menginput data, coba muat ulang (Refresh) halaman.
- Jika data tidak muncul, periksa filter dan pencarian.
- Catat pesan kesalahan jika ada, lalu sampaikan ke admin.

---

## 12. Bantuan dan Dukungan
Jika mengalami kendala:
- Foto/screenshot layar yang bermasalah.
- Catat waktu kejadian dan langkah yang dilakukan.
- Kirim ke admin/Tim IT melalui kanal yang disepakati (email/WhatsApp/Helpdesk).

---

## 13. Lampiran: Contoh Alur Singkat
1) Login →
2) Buka menu di Sidebar →
3) Cari data dengan kata kunci →
4) Tambah/ubah data →
5) Simpan →
6) Lihat notifikasi →
7) Logout saat selesai.

Screenshot yang disarankan:
- Alur langkah 1–7 (opsional)
  ```md
  ![Alur Singkat](screenshots/flow.png)
  ```

---

## 14. Konversi ke Dokumen Word (Opsional)
Jika Anda ingin dokumen ini menjadi file Word (.docx), Anda bisa gunakan Pandoc (jika tersedia di komputer Anda).

Perintah contoh (di folder proyek):
```bash
# Hasil: PANDUAN_PENGGUNA_ID.docx di folder docs
pandoc docs/PANDUAN_PENGGUNA_ID.md -o docs/PANDUAN_PENGGUNA_ID.docx
```
Jika Pandoc belum terpasang, minta bantuan Tim IT untuk menginstalnya.

---

## 15. Panduan Bergambar (Langkah 1–5)

Berikut rangkaian langkah yang merujuk ke gambar/screenshot:

### 1) Login Page
- Akses aplikasi:
  - Lokal (Docker): `http://localhost:8000`
  - Produksi (contoh): `https://trackingwophapros.com`
- Masukkan Email dan Password → klik "Login".

```md
![Login Page](screenshots/login.png)
```

### 2) Home Page (Dashboard)
- Lihat ringkasan: Total Work Order, Completed, On Going, Total Pengguna.
- Akses cepat ke modul:
  - Work Order Tracking
  - Stock Opname
  - Master Overmate
  - Settings & User Management

```md
![Home/Dashboard](screenshots/home.png)
```

### 3) Work Order Tracking – Penjelasan Tombol
- Dashboard Work Order menampilkan statistik per bulan dan kartu ringkas.
- Di bagian "Kelola Work Order":
  - Tombol "+ Tambah WO (satuan)": buat satu WO.
  - Tombol "+ Tambah WO (banyak)": buat beberapa WO sekaligus (borongan).
  - Tombol "Export Laporan": unduh laporan (mis. Excel). Beri atribut `data-loading` pada tombol untuk menampilkan animasi saat proses.
- Filter & pencarian:
  - Pencarian: No. WO / Nama Produk.
  - Status: Semua / On Progress / Completed / Overdue.
  - Jatuh Tempo: opsi waktu.
  - Bulan Due Date: pilih bulan.
  - Tombol "Filter" untuk menerapkan, "Reset" untuk mengosongkan.
- Tabel daftar WO: berisi No. WO, Nama Produk, Group, WO Diterima, Due Date, Status, dan Aksi (lihat/detail, edit, hapus jika tersedia).

```md
![Work Orders - Dashboard & List](screenshots/workorders.png)
```

### 4) Form Tambah Work Order (Satuan)
- Kolom umum:
  - Kode Produk: pilih produk.
  - Nama Produk (Output): terisi sesuai produk (bila otomatis) atau isi manual.
  - Nomor Urut WO: nomor urut yang ingin digunakan.
  - Due Date: tanggal jatuh tempo.
- Aksi:
  - "Simpan Work Order": menyimpan data.
  - "Batal": kembali ke daftar tanpa menyimpan.

```md
![Form WO Satuan](screenshots/workorder_form_single.png)
```

### 5) Form Tambah Work Order (Borongan)
- Gunakan untuk membuat beberapa WO sekaligus dengan produk dan due date yang sama.
- Kolom:
  - Kode Produk
  - Due Date
  - Mulai dari Nomor Urut: nomor urut awal.
  - Jumlah WO yang Dibuat: banyaknya WO yang akan digenerate.
- Aksi:
  - "Generate Work Orders": sistem akan membuat WO berurutan sesuai jumlah.
  - "Batal": kembali ke daftar.

```md
![Form WO Borongan](screenshots/workorder_form_bulk.png)
```

---

## 16) Verifikasi Tracking Order dari Tabel WO
- Dari menu `Work Orders`, temukan WO pada tabel daftar.
- Klik nomor WO atau ikon "lihat/detail" untuk membuka halaman Tracking.
- Pada halaman Tracking, setiap tahap memiliki tanggal dan tombol "Simpan" untuk memverifikasi penyelesaian tahap.
- Centang/isi tanggal sesuai progress, lalu klik "Simpan". Status tahap akan berubah menjadi selesai.
- Jika seluruh tahap final telah terpenuhi, status WO akan berpindah ke `Completed` atau `Completed (Late)` sesuai ketentuan.

```md
![Halaman Tracking WO](screenshots/tracking_detail.png)
```

Catatan penentuan status selesai:
- `Completed`: tanggal selesai ≤ Due Date.
- `Completed (Late)`: tanggal selesai > Due Date.

## 17) Export Laporan Bulanan WO
- Pada daftar Work Orders, klik tombol "Export Laporan".
- Di modal, pilih `Bulan` dan `Tahun` berdasarkan tanggal "WO Diterima".
- Klik "Download Laporan" untuk mengunduh file (Excel). Tunggu hingga overlay loading selesai.
- Jika Anda menyeleksi beberapa baris pada tabel sebelum membuka modal dan memilih opsi "Export yang Dipilih", hanya data terpilih yang diekspor.

```md
![Modal Export Bulanan](screenshots/export_modal.png)
```

## 18) Edit/Hapus/Export dari Data yang Dipilih + Menampilkan Completed & Completed (Late)
- Gunakan checkbox di kolom paling kiri untuk memilih beberapa WO.
- Aksi massal yang tersedia di toolbar atas daftar:
  - "Edit Due Date yang Dipilih": ubah due date beberapa WO sekaligus.
  - "Hapus yang Dipilih": hapus WO yang dipilih (ada konfirmasi).
  - "Export yang Dipilih": unduh laporan hanya untuk baris terpilih.
- Kolom `Status` menampilkan badge:
  - `Completed` (hijau): tanggal selesai ≤ due date.
  - `Completed (Late)` (merah): tanggal selesai > due date.
  - `On Progress`/`Overdue` ditampilkan sesuai kondisi.

```md
![Toolbar Aksi Massal & Status](screenshots/bulk_actions_and_status.png)
```

## 19) Tampilan Stock Opname
- Masuk menu `Stock Opname`.
- Unggah file Excel (.xlsx) lewat tombol "Upload File Baru".
- Setelah upload, klik "Import Data" untuk memproses dan meng-join data dengan master overmate.
- Lihat daftar file yang sudah diupload beserta statusnya (Sudah Diimport/Siap Diimport).
- Aksi yang tersedia: "Lihat Data" untuk pratinjau hasil, "Hapus File" untuk menghapus berkas.
- Panel bantuan menjelaskan alur kerja: Upload File → Import Data → Input Stok Fisik → Lihat Hasil (selisih & kategori).

```md
![Halaman Stock Opname](screenshots/stock_opname.png)
