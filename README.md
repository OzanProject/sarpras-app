# SIP-SARPRAS (Sistem Informasi Pengelolaan Sarana dan Prasarana)

Aplikasi berbasis web untuk manajemen inventaris, peminjaman, dan pelaporan sarana prasarana sekolah. Dibangun dengan framework **Laravel 12** dan template admin **Darkpan**.

## 🚀 Fitur Utama

### 1. Multi-Role User System
*   **Admin**: Hak akses penuh untuk manajemen data master, user, peminjaman, dan laporan.
*   **User (Peminjam)**: Dashboard personal, riwayat peminjaman, dan fitur scan mandiri.

### 2. Manajemen Inventaris
*   **Data Barang**: CRUD lengkap dengan foto, stok, kategori, dan lokasi ruangan.
*   **Generate QR Code**: Cetak label QR otomatis untuk setiap barang (mendukung ID & Kode Barang).
*   **Manajemen Ruangan**: Pelacakan lokasi aset.

### 3. Alur Peminjaman (Approval System)
*   **Booking Mandiri**: User dapat mengajukan pinjaman via katalog online.
*   **Sistem Persetujuan**: Admin harus menyetujui (Approve) atau menolak request pinjaman.
*   **Countdown & Notifikasi**: Status visual untuk barang yang dipinjam, terlambat, atau pending.

### 4. Fitur Canggih User (Self-Service)
*   **Kartu Anggota Digital**: Download kartu anggota dengan QR dinamis (berisi ringkasan barang yang sedang dipinjam).
*   **Scan-to-Return**: User dapat mengembalikan barang secara mandiri dengan men-scan QR Code barang menggunakan kamera HP/Laptop melalui dashboard mereka.
*   **Dashboard Personal**: Statistik peminjaman aktif dan riwayat lengkap.

### 5. Laporan & Statistik
*   **Export PDF/Excel**: Rekap peminjaman bulanan/tahunan.
*   **Grafik Interaktif**: Statistik peminjaman per bulan dan distribusi aset per kategori.

---

## 🛠️ Teknologi yang Digunakan

*   **Backend**: Laravel 12.x (PHP 8.3+)
*   **Frontend**: Blade Templating, Bootstrap 5
*   **Database**: MySQL
*   **Admin Template**: Darkpan
*   **QR System**: `api.qrserver.com` & `html5-qrcode` scanner
*   **Authentication**: Laravel Breeze (Customized)

---

## ⚙️ Instalasi Lokal

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/OzanProject/sarpras-app.git
    cd sarpas-app
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    *   Duplikasi file `.env.example` menjad `.env`.
    *   Sesuaikan konfigurasi database:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sarpas_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi & Seeding**
    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server**
    ```bash
    npm run dev  # (untuk compile asset)
    php artisan serve
    ```
    Akses aplikasi di: `http://127.0.0.1:8000`

---

## 👥 Akun Demo (Seeder)

Jika menggunakan seeder bawaan (`DatabaseSeeder`), akun default adalah:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@admin.com` | `password` |
| **User** | `user@user.com` | `password` |

---

## 📸 Struktur Folder Penting

*   `app/Http/Controllers/`: Logika bisnis (UserController, PeminjamanController, UserScanController, dll).
*   `resources/views/admin/`: View khusus halaman Admin.
*   `resources/views/user/`: View khusus Dashboard User & Scan.
*   `routes/web.php`: Definisi rute aplikasi (dikelompokkan berdasarkan Middleware Role).

---

## 📄 Lisensi
Sistem ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).

Copyright © 2025 **Ozan Project**.
