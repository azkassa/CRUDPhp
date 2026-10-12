<?php
require 'config.php';

// DELETE (hanya lewat POST + token CSRF)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
csrf_check();

$id = (int)($_POST['id'] ?? 0);
$st = $pdo->prepare('DELETE FROM mahasiswa WHERE id = ?');
$st->execute([$id]);

flash($st->rowCount() ? 'Data berhasil dihapus.' : 'Data tidak ditemukan.', $st->rowCount() ? 'success' : 'error');
redirect('index.php');
