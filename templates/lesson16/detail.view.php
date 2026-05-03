<p>
  Detail produktu:
  <strong><?= htmlspecialchars($product['nazev'], ENT_QUOTES, 'UTF-8') ?></strong>,
  <?= number_format((float) $product['cena'], 2, ',', ' ') ?> Kč
</p>
