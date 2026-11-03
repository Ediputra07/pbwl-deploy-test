# PBWL Kelas C — Starter Praktikum

Project dasar Praktikum Pemrograman Berbasis Web Lanjut (Sistem Informasi, UTM) dengan studi kasus **KRS** (Program Studi, Mata Kuliah, Mahasiswa). Kondisi project sama dengan akhir **Modul 5**: CRUD Mata Kuliah, REST API v1 dengan Sanctum, autentikasi Breeze, dan RBAC Spatie.

## Kebutuhan

| Perangkat | Versi |
|---|---|
| PHP | 8.4.27 atau lebih baru (minimal 8.3.36 atau 8.5.12), ekstensi `zip` aktif |
| Composer | 2.x |
| Node.js | 20 atau lebih baru |
| MySQL | 8.x (Laragon) |
| Git | 2.x |

Disarankan Laragon (Windows). Jalankan perintah di Git Bash.

## Instalasi

```bash
git clone https://github.com/Ediputra07/pbwl-kelas-c.git
cd pbwl-kelas-c

composer install
cp .env.example .env
php artisan key:generate
```

Buat database kosong bernama `db_pbwl_kelas_c` (lewat SQLyog atau HeidiSQL), lalu:

```bash
php artisan migrate --seed
npm install
npm run build
```

Konfigurasi database ada di `.env` (default: MySQL, user `root`, tanpa password). Sesuaikan jika berbeda.

## Menjalankan

- **Laragon:** letakkan folder di `C:\laragon\www\`, restart Laragon, buka `http://pbwl-kelas-c.test`.
- **Tanpa Laragon:** `php artisan serve`, lalu buka `http://localhost:8000` dan ubah `APP_URL` di `.env`.

## Akun Uji

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gmail.com` | `password` |
| Dosen | `dosen@gmail.com` | `password` |
| Mahasiswa | `mahasiswa@gmail.com` | `password` |

Akun ini hanya untuk lingkungan lokal praktikum.

## Halaman Penting

| URL | Keterangan |
|---|---|
| `/login` | Halaman masuk |
| `/mata-kuliah` | CRUD Mata Kuliah (wajib login) |
| `/klien` | Klien API (fetch + token) |
| `/api/v1/mata-kuliah` | REST API |

## Riwayat per Modul

Setiap modul memiliki tag. Untuk melihat kondisi pada modul tertentu:

```bash
git checkout modul-3     # lihat kondisi akhir Modul 3
git checkout main        # kembali ke kondisi terbaru
```

Tag tersedia: `modul-2`, `modul-3`, `modul-4`, `modul-5`.

## Masalah Umum

| Gejala | Solusi |
|---|---|
| `could not find driver` / `zip` hilang | Aktifkan ekstensi di Laragon: Menu → PHP → Extensions |
| `Access denied for user 'root'` | Periksa `DB_USERNAME` dan `DB_PASSWORD` di `.env`, lalu `php artisan config:clear` |
| `Unknown database` | Buat database `db_pbwl_kelas_c` terlebih dahulu |
| Halaman tanpa gaya (Tailwind) | Jalankan `npm run build` |
| Perubahan `.env` tidak terbaca | `php artisan config:clear` |

## Catatan

- `APP_DEBUG=true` hanya untuk pengembangan lokal; jangan dipakai di server publik.
- File `.env` tidak masuk repository. Jangan meng-commit kredensial.
