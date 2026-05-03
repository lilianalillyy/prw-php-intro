<?php declare(strict_types=1);

$dbError = null;
$pdo = lessonDbPdo($dbError);

function cv13h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(100) NOT NULL,
    cena DECIMAL(10,2) NOT NULL
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci");

  lessonSeedTable($pdo, 'produkty', "INSERT INTO produkty (nazev, cena) VALUES (?, ?)", [
    ['Sešit', 35],
    ['Batoh', 799],
    ['Propiska', 19],
    ['Kalkulačka', 249],
    ['Učebnice PHP', 420],
  ]);

  if (!empty($_POST["cv134_nazev"]) && isset($_POST["cv134_cena"])) {
    $statement = $pdo->prepare("INSERT INTO produkty (nazev, cena) VALUES (?, ?)");
    $statement->execute([trim($_POST["cv134_nazev"]), (float) $_POST["cv134_cena"]]);
  }

  if (!empty($_POST["cv135_nazev"]) && isset($_POST["cv135_cena"])) {
    $statement = $pdo->prepare("INSERT INTO produkty (nazev, cena) VALUES (:nazev, :cena)");
    $statement->execute([':nazev' => trim($_POST["cv135_nazev"]), ':cena' => (float) $_POST["cv135_cena"]]);
  }

  if (!empty($_POST["cv137_id"]) && isset($_POST["cv137_cena"])) {
    $statement = $pdo->prepare("UPDATE produkty SET cena = ? WHERE id = ?");
    $statement->execute([(float) $_POST["cv137_cena"], (int) $_POST["cv137_id"]]);
  }

  if (!empty($_POST["cv138_id"])) {
    $statement = $pdo->prepare("DELETE FROM produkty WHERE id = ?");
    $statement->execute([(int) $_POST["cv138_id"]]);
  }
}
?>

<h2 class="subtitle">Cvičení 13.1</h2>

<p><?= $pdo ? "PDO připojení k databázi funguje." : lessonDbUnavailableHtml($dbError) ?></p>

<h2 class="subtitle">Cvičení 13.2</h2>

<p>Tabulka <strong>produkty</strong> obsahuje pole id, nazev a cena.</p>

<h2 class="subtitle">Cvičení 13.3</h2>

<?php if ($pdo): ?>
  <?php
  $statement = $pdo->prepare("SELECT * FROM produkty WHERE cena > ?");
  $statement->execute([100]);
  ?>
  <ul>
    <?php foreach ($statement->fetchAll() as $product): ?>
      <li><?= cv13h($product["nazev"]) ?>: <?= number_format((float) $product["cena"], 2, ',', ' ') ?> Kč</li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 13.4</h2>

<form method="POST">
  <input type="text" name="cv134_nazev" placeholder="Název produktu">
  <input type="number" step="0.01" name="cv134_cena" placeholder="Cena">
  <button type="submit">Vložit prepared INSERT</button>
</form>

<h2 class="subtitle">Cvičení 13.5</h2>

<form method="POST">
  <input type="text" name="cv135_nazev" placeholder="Název produktu">
  <input type="number" step="0.01" name="cv135_cena" placeholder="Cena">
  <button type="submit">Vložit přes :nazev a :cena</button>
</form>

<h2 class="subtitle">Cvičení 13.6</h2>

<?php if ($pdo): ?>
  <?php $products = $pdo->query("SELECT * FROM produkty ORDER BY id DESC LIMIT 20")->fetchAll(); ?>
  <table border="1">
    <tr><th>ID</th><th>Název</th><th>Cena</th></tr>
    <?php foreach ($products as $product): ?>
      <tr>
        <td><?= (int) $product["id"] ?></td>
        <td><?= cv13h($product["nazev"]) ?></td>
        <td><?= number_format((float) $product["cena"], 2, ',', ' ') ?> Kč</td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 13.7</h2>

<form method="POST">
  <input type="number" name="cv137_id" placeholder="ID">
  <input type="number" step="0.01" name="cv137_cena" placeholder="Nová cena">
  <button type="submit">Změnit cenu</button>
</form>

<h2 class="subtitle">Cvičení 13.8</h2>

<form method="POST">
  <input type="number" name="cv138_id" placeholder="ID">
  <button type="submit">Smazat produkt</button>
</form>

<h2 class="subtitle">Cvičení 13.9</h2>

<?php
$validationErrors = [];
if (isset($_POST["cv139_check"])) {
  if (trim($_POST["cv139_nazev"] ?? '') === '') {
    $validationErrors[] = "Název nesmí být prázdný.";
  }
  if (trim($_POST["cv139_cena"] ?? '') === '' || !is_numeric($_POST["cv139_cena"])) {
    $validationErrors[] = "Cena musí být vyplněné číslo.";
  }
}
?>

<form method="POST">
  <input type="hidden" name="cv139_check" value="1">
  <input type="text" name="cv139_nazev" placeholder="Název">
  <input type="text" name="cv139_cena" placeholder="Cena">
  <button type="submit">Zkontrolovat</button>
</form>

<?php foreach ($validationErrors as $error): ?>
  <p style="color:red"><?= cv13h($error) ?></p>
<?php endforeach; ?>
<?php if (isset($_POST["cv139_check"]) && empty($validationErrors)): ?>
  <p>Vstupy jsou v pořádku.</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 13.10</h2>

<?php
if ($pdo) {
  try {
    $pdo->query("SELECT * FROM neexistujici_tabulka");
  } catch (PDOException $e) {
    echo "Zachycená SQL chyba: " . cv13h($e->getMessage());
  }
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 13.11</h2>

<?php if ($pdo): ?>
  <?php $limited = $pdo->query("SELECT * FROM produkty ORDER BY id LIMIT 5 OFFSET 0")->fetchAll(); ?>
  <ol>
    <?php foreach ($limited as $product): ?>
      <li><?= cv13h($product["nazev"]) ?></li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>

<h2 class="subtitle">Cvičení 13.12</h2>

<form method="GET">
  <input type="hidden" name="route" value="lesson13">
  <input type="text" name="cv1312_search" placeholder="Hledat produkt" value="<?= cv13h($_GET["cv1312_search"] ?? '') ?>">
  <button type="submit">Hledat</button>
</form>

<?php
if ($pdo && isset($_GET["cv1312_search"])) {
  $statement = $pdo->prepare("SELECT * FROM produkty WHERE nazev LIKE ?");
  $statement->execute(['%' . trim($_GET["cv1312_search"]) . '%']);
  foreach ($statement->fetchAll() as $product) {
    echo cv13h($product["nazev"]) . " - " . number_format((float) $product["cena"], 2, ',', ' ') . " Kč<br>";
  }
}
?>

<h2 class="subtitle">Cvičení 13.13</h2>

<?php
if ($pdo) {
  $average = (float) $pdo->query("SELECT AVG(cena) FROM produkty")->fetchColumn();
  echo "Průměrná cena: " . number_format($average, 2, ',', ' ') . " Kč";
}
?>

<h2 class="subtitle">Cvičení 13.14</h2>

<?php if ($pdo): ?>
  <?php $sorted = $pdo->query("SELECT * FROM produkty ORDER BY cena ASC")->fetchAll(); ?>
  <?php foreach ($sorted as $product): ?>
    <?= cv13h($product["nazev"]) ?>: <?= number_format((float) $product["cena"], 2, ',', ' ') ?> Kč<br>
  <?php endforeach; ?>
<?php endif; ?>

<h2 class="subtitle">Cvičení 13.15</h2>

<p>Mini CRUD aplikace používá stejnou tabulku produkty: formuláře výše přidávají, upravují a mažou záznamy, tabulka ve cvičení 13.6 je vypisuje.</p>
