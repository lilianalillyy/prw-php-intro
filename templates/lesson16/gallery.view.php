<ul>
  <?php foreach ($images as $image): ?>
    <li><?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?></li>
  <?php endforeach; ?>
</ul>
