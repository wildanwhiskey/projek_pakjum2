# Project Film (OneMovies)

Aplikasi web daftar film berbasis **Laravel 13** dengan dua jenis pengguna: user biasa dan administrator. Dibuat sebagai tugas kelas XII, berdasarkan materi kelas.

## Fitur

**User biasa**
- Melihat daftar film di dashboard, mencari film, dan melihat detail film
- Memberi komentar dan rating bintang (1-5) pada film
- Melihat dan mengubah halaman profile sendiri

**Administrator**
- CRUD data film (termasuk upload poster), cast, genre, dan peran
- Melihat daftar data user (hanya lihat)
- Tidak bisa memberi komentar pada film

Pembatasan hak akses dilakukan di backend lewat middleware `role` (`app/Http/Middleware/RoleMiddleware.php`), bukan hanya dengan menyembunyikan tombol.

## Kebutuhan

- PHP 8.3 atau lebih baru (ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `ctype`, `tokenizer`, `xml`)
- Composer
- Git
- MySQL (misalnya lewat XAMPP atau Laragon)

Node.js **tidak** diperlukan.

## Cara menjalankan

Contoh perintah di bawah memakai PowerShell/CMD (Windows). Jalankan semuanya dari folder proyek.

**1. Clone repo**
```bash
git clone https://github.com/wildanwhiskey/projek_pakjum2.git
cd projek_pakjum2
```

**2. Buat file `.env`**
```bash
copy .env.example .env
```
(Di Linux/macOS: `cp .env.example .env`)

**3. Buat database kosong** di MySQL (lewat phpMyAdmin), misalnya bernama `projek_pakjum2`.

**4. Atur koneksi database di `.env`**

Default `.env.example` memakai SQLite, jadi ubah menjadi MySQL:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projek_pakjum2
DB_USERNAME=root
DB_PASSWORD=
```
Pada XAMPP/Laragon bawaan, user-nya `root` dan password kosong.

**5. Install dependency**
```bash
composer install
```

**6. Generate APP key**
```bash
php artisan key:generate
```

**7. Migration dan seeder**
```bash
php artisan migrate --seed
```
Perintah ini membuat semua tabel dan mengisi data contoh (genre, 50 cast, 128 film, peran, role, user, dan akun admin).

**8. Siapkan gambar poster**

Salin folder gambar ke storage, lalu buat symlink:
```bash
xcopy public\template\images storage\app\public\images /E /I /Y
php artisan storage:link
```
(Di Linux/macOS: `cp -r public/template/images storage/app/public/images`)

**9. Jalankan aplikasi**
```bash
php artisan serve
```
Buka http://127.0.0.1:8000

## Akun untuk demo

| Role | Email | Password |
|------|-------|----------|
| Administrator | `admin@example.com` | `12345678` |
| User biasa | daftar sendiri lewat tombol **Login** > Create an account | - |

## Catatan

- Jalankan `php artisan migrate --seed` **hanya sekali** pada database kosong. Untuk mengulang dari nol: `php artisan migrate:fresh --seed` (menghapus semua data).
- Peringatan `PHP Deprecated` pada PHP 8.4 tidak berbahaya dan bisa diabaikan.
- Error `could not find driver`: aktifkan `extension=pdo_mysql` di `php.ini` (XAMPP: `C:\xampp\php\php.ini`), lalu restart.
- Poster film tidak muncul: pastikan langkah 8 sudah dijalankan (folder `storage/app/public/images` terisi dan `public/storage` ada).
- Error `No application encryption key`: jalankan `php artisan key:generate`.

## Struktur kode yang ditambahkan

| Bagian | File |
|--------|------|
| Autentikasi | `app/Http/Controllers/AuthController.php`, `resources/views/templates/component/login.blade.php` |
| Role / hak akses | `app/Http/Middleware/RoleMiddleware.php`, `bootstrap/app.php`, `routes/web.php` |
| Komentar dan rating | `app/Http/Controllers/KritikController.php`, `app/Http/Requests/StoreKritikRequest.php`, `resources/views/components/movie-show.blade.php` |
| Profile | `app/Http/Controllers/ProfileController.php`, `app/Http/Requests/UpdateProfileRequest.php`, `resources/views/components/profile.blade.php` |
| Pencarian film | `app/Http/Controllers/FilmController.php` (`movies`), `resources/views/templates/component/header.blade.php` |
| Admin (user, genre, film, cast, peran) | `app/Http/Controllers/Admin/*`, `resources/views/admin/*` |
