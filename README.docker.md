# Docker Setup — UMKM App

Panduan menjalankan proyek Laravel ini menggunakan Docker & Docker Compose.

## Stack

| Komponen | Detail                                    |
| -------- | ----------------------------------------- |
| App      | PHP 8.4.2 (CLI) + Laravel `artisan serve` |
| Database | PostgreSQL 15 (Alpine)                    |
| Web port | `8000`                                    |
| DB port  | `5432`                                    |

Ekstensi PHP yang sudah terpasang di image: `pdo`, `pdo_pgsql`, `pgsql`, `pdo_sqlite`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`.

> `pdo_sqlite` disertakan agar testing (`phpunit`) bisa memakai SQLite in-memory, terpisah dari database utama PostgreSQL.

## Prasyarat

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/) (v2, biasanya sudah menyatu dengan Docker Desktop / Docker Engine)

## Struktur Layanan

```
services:
  app  -> container umkm_app  (PHP + Laravel serve, port 8000)
  db   -> container umkm_db   (PostgreSQL 15, port 5432)
```

Kedua service berada dalam network bridge `umkm_network`, dan data PostgreSQL disimpan di volume bernama `db_data` supaya persisten walau container dihapus.

## 1. Konfigurasi Environment

Salin file environment Laravel:

```bash
cp .env.example .env
```

Sesuaikan bagian koneksi database di `.env` agar cocok dengan `docker-compose.yaml`:

```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

> `DB_HOST` **harus** `db` (nama service di Compose), bukan `127.0.0.1`, karena app dan db berjalan di container terpisah dan saling terhubung lewat nama service.
>
> Nilai `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` bisa dioverride lewat variabel environment saat menjalankan Compose — lihat bagian **Environment Variables** di bawah.

## 2. Build & Jalankan Container

```bash
docker compose up -d --build
```

Perintah ini akan:

1. Build image `app` dari `Dockerfile` (install dependensi sistem, ekstensi PHP, dan Composer).
2. Menarik image `postgres:15-alpine` untuk `db`.
3. Menjalankan kedua container di background (`-d`).

Cek status container:

```bash
docker compose ps
```

## 3. Install Dependensi & Setup Laravel

Jalankan perintah-perintah berikut di dalam container `app`:

```bash
# Install dependensi PHP
docker compose exec app composer install

# Generate application key
docker compose exec app php artisan key:generate

# Jalankan migrasi database
docker compose exec app php artisan migrate

# (Opsional) seed database
docker compose exec app php artisan db:seed
```

## 4. Akses Aplikasi

Buka browser ke:

```
http://localhost:8000
```

## Perintah Umum

| Tindakan                        | Perintah                                         |
| ------------------------------- | ------------------------------------------------ |
| Jalankan container (background) | `docker compose up -d`                           |
| Build ulang image               | `docker compose up -d --build`                   |
| Hentikan container              | `docker compose down`                            |
| Hentikan & hapus volume DB      | `docker compose down -v`                         |
| Lihat log                       | `docker compose logs -f app`                     |
| Masuk shell container app       | `docker compose exec app bash`                   |
| Masuk psql container db         | `docker compose exec db psql -U root -d laravel` |
| Jalankan artisan command        | `docker compose exec app php artisan <command>`  |
| Jalankan test                   | `docker compose exec app php artisan test`       |

## Environment Variables (Database)

Variabel berikut dapat diset di `.env` (root proyek, dibaca oleh `docker-compose.yaml`) untuk mengganti nilai default:

| Variabel      | Default   | Keterangan               |
| ------------- | --------- | ------------------------ |
| `DB_DATABASE` | `laravel` | Nama database PostgreSQL |
| `DB_USERNAME` | `root`    | User PostgreSQL          |
| `DB_PASSWORD` | `secret`  | Password PostgreSQL      |

⚠️ **Ganti nilai default** (`root` / `secret`) sebelum dipakai di lingkungan produksi.

## Persistensi Data

Data PostgreSQL disimpan di Docker volume `db_data`. Data akan tetap ada meskipun container dihentikan atau di-_rebuild_, dan hanya hilang jika volume dihapus secara eksplisit:

```bash
docker compose down -v
```

## Troubleshooting

**Port sudah dipakai (`8000` atau `5432`)**
Ubah mapping port di `docker-compose.yaml`, misalnya `"8001:8000"`.

**Error koneksi database ("could not connect")**
Pastikan container `db` sudah _healthy_ sebelum app mencoba migrate. Tunggu beberapa detik setelah `docker compose up`, atau jalankan ulang:

```bash
docker compose exec app php artisan migrate
```

**Permission error pada `storage/` atau `bootstrap/cache/`**

```bash
docker compose exec app chmod -R 775 storage bootstrap/cache
```

**Perubahan `Dockerfile` tidak terasa**
Jalankan build ulang tanpa cache:

```bash
docker compose build --no-cache app
```

## Catatan

- Volume `./:/var/www` melakukan _bind mount_ seluruh direktori proyek ke dalam container, sehingga perubahan kode langsung terlihat tanpa perlu rebuild image.
- Setup ini menggunakan `php artisan serve`, yang cocok untuk **development**. Untuk produksi, disarankan menambahkan Nginx/Apache + PHP-FPM sebagai layanan terpisah.
