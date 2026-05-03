<table border="1">
  <tr><th>Název</th><th>Cena</th></tr>
  <?php foreach ($data as $product): ?>
    <tr>
      <td><?= htmlspecialchars($product['nazev'], ENT_QUOTES, 'UTF-8') ?></td>
      <td><?= number_format((float) $product['cena'], 2, ',', ' ') ?> Kč</td>
    </tr>
  <?php endforeach; ?>
</table>
