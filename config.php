<?php
// Konfigurasi database (default Laragon: user root, tanpa password)
const DB_HOST = 'localhost';
const DB_NAME = 'crud_db';
const DB_USER = 'root';
const DB_PASS = '';

session_start();

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $ex) {
    die('Koneksi database gagal: ' . htmlspecialchars($ex->getMessage()) .
        '<br>Pastikan MySQL di Laragon sudah jalan dan database.sql sudah diimpor.');
}

// Escape output supaya aman dari XSS
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        die('Token tidak valid. Muat ulang halaman dan coba lagi.');
    }
}

function flash(string $msg, string $type = 'success'): void { $_SESSION['flash'] = [$msg, $type]; }
function redirect(string $url): void { header("Location: $url"); exit; }

// Validasi input form; return [data_bersih, daftar_error]
function validate(array $in): array {
    $d = [];
    foreach (['nim', 'nama', 'jurusan', 'email', 'no_hp'] as $k) $d[$k] = trim($in[$k] ?? '');
    $err = [];
    if ($d['nim'] === '') $err['nim'] = 'NIM wajib diisi.';
    elseif (!preg_match('/^[A-Za-z0-9\-]{3,20}$/', $d['nim'])) $err['nim'] = 'NIM 3-20 karakter (huruf, angka, atau -).';
    if ($d['nama'] === '') $err['nama'] = 'Nama wajib diisi.';
    elseif (mb_strlen($d['nama']) > 100) $err['nama'] = 'Maksimal 100 karakter.';
    if ($d['jurusan'] === '') $err['jurusan'] = 'Jurusan wajib diisi.';
    elseif (mb_strlen($d['jurusan']) > 100) $err['jurusan'] = 'Maksimal 100 karakter.';
    if ($d['email'] !== '' && !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $err['email'] = 'Format email tidak valid.';
    if ($d['no_hp'] !== '' && !preg_match('/^[0-9+\-\s]{6,20}$/', $d['no_hp'])) $err['no_hp'] = 'No. HP tidak valid.';
    return [$d, $err];
}
