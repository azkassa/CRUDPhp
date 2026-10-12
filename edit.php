<?php
require 'config.php';

$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = ?');
$st->execute([$id]);
$row = $st->fetch();
if (!$row) {
    flash('Data tidak ditemukan.', 'error');
    redirect('index.php');
}

$data = $row;
$errors = [];

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    [$data, $errors] = validate($_POST);
    if (!$errors) {
        try {
            $st = $pdo->prepare('UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, email = ?, no_hp = ? WHERE id = ?');
            $st->execute([$data['nim'], $data['nama'], $data['jurusan'], $data['email'] ?: null, $data['no_hp'] ?: null, $id]);
            flash('Data berhasil diperbarui.');
            redirect('index.php');
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') $errors['nim'] = 'NIM sudah dipakai mahasiswa lain.';
            else throw $ex;
        }
    }
}

$pageTitle = 'Edit Mahasiswa';
$title = 'Edit Mahasiswa';
require 'header.php';
require '_form.php';
require 'footer.php';
