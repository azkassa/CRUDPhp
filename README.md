# CRUD Mahasiswa (PHP + MySQL)

## Cara pasang di Laragon
1. Salin folder `crud-php` ke `C:\laragon\www\`.
2. Klik **Start All** di Laragon (Apache + MySQL).
3. Impor database: buka `http://localhost/phpmyadmin` (user `root`, password kosong)
   → tab **Import** → pilih `database.sql`. (Atau lewat HeidiSQL: Menu Laragon → MySQL.)
4. Buka `http://crud-php.test` atau `http://localhost/crud-php`.

Kalau MySQL kamu memakai password, ubah `DB_PASS` di `config.php`.

## Fitur
- Create, Read, Update, Delete data mahasiswa
- Pencarian dan paginasi (10 data per halaman)
- Validasi form, NIM unik, pesan notifikasi
- Aman: prepared statement (anti SQL injection), escape output (anti XSS), token CSRF, hapus via POST
