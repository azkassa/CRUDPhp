<?php
require 'config.php';

// READ: daftar + pencarian + paginasi
$q = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$per = 10;
$where = '';
$params = [];
if ($q !== '') {
    $where = 'WHERE nim LIKE :q1 OR nama LIKE :q2 OR jurusan LIKE :q3 OR email LIKE :q4';
    $params = [':q1' => "%$q%", ':q2' => "%$q%", ':q3' => "%$q%", ':q4' => "%$q%"];
}
$st = $pdo->prepare("SELECT COUNT(*) FROM mahasiswa $where");
$st->execute($params);
$total = (int)$st->fetchColumn();
$pages = max(1, (int)ceil($total / $per));
$page = min($page, $pages);
$offset = ($page - 1) * $per;

$st = $pdo->prepare("SELECT * FROM mahasiswa $where ORDER BY id DESC LIMIT $per OFFSET $offset");
$st->execute($params);
$rows = $st->fetchAll();

$pageTitle = 'Data Mahasiswa';
require 'header.php';
?>
<div class="toolbar">
  <h1>Data Mahasiswa <small>(<?= $total ?>)</small></h1>
  <a href="create.php" class="btn primary">+ Tambah</a>
</div>

<form method="get" class="search">
  <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari NIM, nama, jurusan, atau email...">
  <button class="btn">Cari</button>
  <?php if ($q !== ''): ?><a href="index.php" class="btn">Reset</a><?php endif; ?>
</form>

<div class="table-wrap">
<table>
  <thead><tr><th>#</th><th>NIM</th><th>Nama</th><th>Jurusan</th><th>Email</th><th>No. HP</th><th></th></tr></thead>
  <tbody>
  <?php if (!$rows): ?>
    <tr><td colspan="7" class="empty">Belum ada data.</td></tr>
  <?php endif; ?>
  <?php foreach ($rows as $i => $r): ?>
    <tr>
      <td><?= $offset + $i + 1 ?></td>
      <td><?= e($r['nim']) ?></td>
      <td><?= e($r['nama']) ?></td>
      <td><?= e($r['jurusan']) ?></td>
      <td><?= e($r['email'] ?: '-') ?></td>
      <td><?= e($r['no_hp'] ?: '-') ?></td>
      <td class="row-actions">
        <a href="edit.php?id=<?= (int)$r['id'] ?>" class="btn small">Edit</a>
        <form method="post" action="delete.php" onsubmit="return confirm('Hapus data <?= e(addslashes($r['nama'])) ?>?')">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button class="btn small danger">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php if ($pages > 1): ?>
<nav class="pager">
  <?php for ($p = 1; $p <= $pages; $p++): ?>
    <a href="?<?= e(http_build_query(['q' => $q, 'page' => $p])) ?>" class="<?= $p === $page ? 'current' : '' ?>"><?= $p ?></a>
  <?php endfor; ?>
</nav>
<?php endif; ?>
<?php require 'footer.php'; ?>
