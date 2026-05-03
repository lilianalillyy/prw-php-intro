<?php declare(strict_types=1);

$dbError = null;
$pdo = lessonDbPdo($dbError);

function cv14h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$bookErrors = [];

if ($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS knihy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    cena DECIMAL(10,2) NOT NULL,
    zanr VARCHAR(50) NOT NULL DEFAULT 'Nezařazeno'
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci");

  lessonSeedTable($pdo, 'knihy', "INSERT INTO knihy (nazev, autor, cena, zanr) VALUES (?, ?, ?, ?)", [
    ['R.U.R.', 'Karel Čapek', 199, 'Drama'],
    ['Babička', 'Božena Němcová', 149, 'Klasika'],
    ['PHP pro začátečníky', 'Jan Novák', 399, 'Programování'],
    ['Saturnin', 'Zdeněk Jirotka', 259, 'Humor'],
    ['Kytice', 'Karel Jaromír Erben', 129, 'Poezie'],
    ['1984', 'George Orwell', 289, 'Román'],
  ]);

  if (isset($_POST["cv144_add"])) {
    $title = trim($_POST["cv144_nazev"] ?? '');
    $author = trim($_POST["cv144_autor"] ?? '');
    $price = trim($_POST["cv144_cena"] ?? '');
    $genre = trim($_POST["cv144_zanr"] ?? 'Nezařazeno');

    if ($title === '' || $author === '') {
      $bookErrors[] = "Chybí název nebo autor.";
    }
    if ($price === '' || !is_numeric($price)) {
      $bookErrors[] = "Cena musí být číslo.";
    }

    if (empty($bookErrors)) {
      $statement = $pdo->prepare("INSERT INTO knihy (nazev, autor, cena, zanr) VALUES (?, ?, ?, ?)");
      $statement->execute([$title, $author, (float) $price, $genre === '' ? 'Nezařazeno' : $genre]);
    }
  }

  if (isset($_POST["cv145_update"])) {
    $statement = $pdo->prepare("UPDATE knihy SET nazev = ?, autor = ?, cena = ?, zanr = ? WHERE id = ?");
    $statement->execute([
      trim($_POST["cv145_nazev"] ?? ''),
      trim($_POST["cv145_autor"] ?? ''),
      (float) ($_POST["cv145_cena"] ?? 0),
      trim($_POST["cv145_zanr"] ?? 'Nezařazeno'),
      (int) ($_POST["cv145_id"] ?? 0),
    ]);
  }

  if (isset($_POST["cv147_confirm"]) && !empty($_POST["cv146_id"])) {
    $statement = $pdo->prepare("DELETE FROM knihy WHERE id = ?");
    $statement->execute([(int) $_POST["cv146_id"]]);
  }
}

$search = trim($_GET["cv148_search"] ?? '');
$sort = ($_GET["cv149_sort"] ?? '') === 'price' ? 'cena ASC' : 'id DESC';
$page = max(1, (int) ($_GET["cv1413_page"] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;
?>

<h2 class="subtitle">Cvičení 14.1</h2>

<p><?= $pdo ? "Tabulka knihy je připravená: id, nazev, autor, cena, zanr." : lessonDbUnavailableHtml($dbError) ?></p>

<h2 class="subtitle">Cvičení 14.2</h2>

<?php if ($pdo): ?>
  <?php
  $statement = $pdo->prepare("SELECT * FROM knihy WHERE nazev LIKE ? ORDER BY {$sort} LIMIT {$limit} OFFSET {$offset}");
  $statement->execute(['%' . $search . '%']);
  $books = $statement->fetchAll();
  ?>
  <table border="1">
    <tr><th>ID</th><th>Název</th><th>Autor</th><th>Cena</th><th>Žánr</th></tr>
    <?php foreach ($books as $book): ?>
      <tr>
        <td><?= (int) $book["id"] ?></td>
        <td><?= cv14h($book["nazev"]) ?></td>
        <td><?= cv14h($book["autor"]) ?></td>
        <td><?= number_format((float) $book["cena"], 2, ',', ' ') ?> Kč</td>
        <td><?= cv14h($book["zanr"]) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 14.3</h2>

<form method="POST">
  <input type="hidden" name="cv144_add" value="1">
  <input type="text" name="cv144_nazev" placeholder="Název knihy">
  <input type="text" name="cv144_autor" placeholder="Autor">
  <input type="number" step="0.01" name="cv144_cena" placeholder="Cena">
  <input type="text" name="cv144_zanr" placeholder="Žánr">
  <button type="submit">Přidat knihu</button>
</form>

<h2 class="subtitle">Cvičení 14.4</h2>

<p>Formulář výše ukládá novou knihu pomocí PDO prepared statement.</p>

<h2 class="subtitle">Cvičení 14.5</h2>

<form method="POST">
  <input type="hidden" name="cv145_update" value="1">
  <input type="number" name="cv145_id" placeholder="ID">
  <input type="text" name="cv145_nazev" placeholder="Nový název">
  <input type="text" name="cv145_autor" placeholder="Nový autor">
  <input type="number" step="0.01" name="cv145_cena" placeholder="Nová cena">
  <input type="text" name="cv145_zanr" placeholder="Žánr">
  <button type="submit">Upravit knihu</button>
</form>

<h2 class="subtitle">Cvičení 14.6</h2>

<form method="POST">
  <input type="number" name="cv146_id" placeholder="ID ke smazání">
  <button type="submit">Připravit smazání</button>
</form>

<h2 class="subtitle">Cvičení 14.7</h2>

<?php if (!empty($_POST["cv146_id"]) && !isset($_POST["cv147_confirm"])): ?>
  <form method="POST">
    <input type="hidden" name="cv146_id" value="<?= (int) $_POST["cv146_id"] ?>">
    <input type="hidden" name="cv147_confirm" value="1">
    <button type="submit">Opravdu smazat knihu #<?= (int) $_POST["cv146_id"] ?>?</button>
  </form>
<?php else: ?>
  <p>Mazání vyžaduje potvrzení z předchozího cvičení.</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 14.8</h2>

<form method="GET">
  <input type="hidden" name="route" value="lesson14">
  <input type="text" name="cv148_search" placeholder="Hledat podle názvu" value="<?= cv14h($search) ?>">
  <button type="submit">Hledat</button>
</form>

<h2 class="subtitle">Cvičení 14.9</h2>

<p><a href="?route=lesson14&cv149_sort=price">Seřadit podle ceny</a></p>

<h2 class="subtitle">Cvičení 14.10</h2>

<p>Ceny se v tabulce zobrazují pomocí <code>number_format()</code>, například <?= number_format(1234.5, 2, ',', ' ') ?> Kč.</p>

<h2 class="subtitle">Cvičení 14.11</h2>

<?php foreach ($bookErrors as $error): ?>
  <p style="color:red"><?= cv14h($error) ?></p>
<?php endforeach; ?>
<?php if (empty($bookErrors)): ?>
  <p>Chybové hlášky se zobrazí při odeslání neúplného formuláře pro přidání knihy.</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 14.12</h2>

<p>Cena v přidávacím formuláři musí být číslo, jinak se zobrazí chyba „Cena musí být číslo.“</p>

<h2 class="subtitle">Cvičení 14.13</h2>

<p>
  <a href="?route=lesson14&cv1413_page=<?= max(1, $page - 1) ?>">Předchozí stránka</a>
  |
  <a href="?route=lesson14&cv1413_page=<?= $page + 1 ?>">Další stránka</a>
</p>

<h2 class="subtitle">Cvičení 14.14</h2>

<p>Sloupec <strong>zanr</strong> je součástí tabulky knihy a zobrazuje se v přehledu.</p>

<h2 class="subtitle">Cvičení 14.15</h2>

<p>Knihovna umožňuje zobrazit, přidat, upravit, smazat a vyhledávat knihy pomocí formulářů v této lekci.</p>
