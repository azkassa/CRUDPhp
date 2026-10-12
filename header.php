<?php $pageTitle = $pageTitle ?? 'Data Mahasiswa'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top"><div class="wrap"><a href="index.php" class="brand">📚 CRUD Mahasiswa</a></div></header>
<main class="wrap">
<?php if (!empty($_SESSION['flash'])): [$msg, $type] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
  <div class="alert <?= e($type) ?>"><?= e($msg) ?></div>
<?php endif; ?>
