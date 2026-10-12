<?php
require 'config.php';

$data = ['nim' => '', 'nama' => '', 'jurusan' => '', 'email' => '', 'no_hp' => ''];
$errors = [];

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    [$data, $errors] = validate($_POST);
    if (!$errors) {
        try {
            $st = $pdo->prepare('INSERT INTO mahasiswa (nim, nama, jurusan, email, no_hp) VALUES (?, ?, ?, ?, ?)');
            $st->execute([$data['nim'], $data['nama'], $data['jurusan'], $data['email'] ?: null, $data['no_hp'] ?: null]);
            flash('Data berhasil ditambahkan.');
            redirect('index.php');
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') $errors['nim'] = 'NIM sudah terdaftar.';
            else throw $ex;
        }
    }
}

$pageTitle = 'Tambah Mahasiswa';
$title = 'Tambah Mahasiswa';
require 'header.php';
require '_form.php';
require 'footer.php';
