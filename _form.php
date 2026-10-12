<?php
// Dipakai create.php & edit.php. Butuh: $data, $errors, $title
$fields = [
    'nim'     => ['NIM', 'text', true],
    'nama'    => ['Nama lengkap', 'text', true],
    'jurusan' => ['Jurusan', 'text', true],
    'email'   => ['Email', 'email', false],
    'no_hp'   => ['No. HP', 'text', false],
];
?>
<h1><?= e($title) ?></h1>
<form method="post" class="card" novalidate>
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <?php foreach ($fields as $name => [$label, $type, $required]): ?>
    <label>
      <span><?= e($label) ?><?= $required ? ' <b class="req">*</b>' : '' ?></span>
      <input type="<?= $type ?>" name="<?= $name ?>" value="<?= e($data[$name] ?? '') ?>"
             class="<?= isset($errors[$name]) ? 'invalid' : '' ?>">
      <?php if (isset($errors[$name])): ?><small class="err"><?= e($errors[$name]) ?></small><?php endif; ?>
    </label>
  <?php endforeach; ?>
  <div class="actions">
    <button type="submit" class="btn primary">Simpan</button>
    <a href="index.php" class="btn">Batal</a>
  </div>
</form>
