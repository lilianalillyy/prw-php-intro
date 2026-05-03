<?php declare(strict_types=1);

$dbError = null;
$connection = lessonDbMysqli($dbError);

if ($connection) {
  mysqli_query($connection, "CREATE TABLE IF NOT EXISTS studenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jmeno VARCHAR(50) NOT NULL,
    rocnik INT NOT NULL
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci");
}

function cv12h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function cv12query(mysqli $connection, string $sql): bool
{
  return mysqli_query($connection, $sql) !== false;
}
?>

<h2 class="subtitle">Cvičení 12.1</h2>

<?php if ($connection): ?>
  <p>Připojení k databázi proběhlo úspěšně.</p>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 12.2</h2>

<?php if ($connection): ?>
  <p>Tabulka <strong>studenti</strong> je vytvořená s poli id, jmeno a rocnik.</p>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 12.3</h2>

<?php
if ($connection) {
  $result = mysqli_query($connection, "SHOW TABLES LIKE 'studenti'");
  echo mysqli_num_rows($result) > 0 ? "Tabulka studenti existuje." : "Tabulka studenti neexistuje.";
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 12.4</h2>

<form method="POST">
  <input type="text" name="cv124_jmeno" placeholder="Jméno studenta">
  <input type="number" name="cv124_rocnik" placeholder="Ročník">
  <button type="submit">Vložit studenta</button>
</form>

<?php
if ($connection && !empty($_POST["cv124_jmeno"]) && !empty($_POST["cv124_rocnik"])) {
  $name = mysqli_real_escape_string($connection, trim($_POST["cv124_jmeno"]));
  $year = (int) $_POST["cv124_rocnik"];
  cv12query($connection, "INSERT INTO studenti (jmeno, rocnik) VALUES ('{$name}', {$year})");
  echo "Student vložen: " . cv12h($name) . ", ročník {$year}";
}
?>

<h2 class="subtitle">Cvičení 12.5</h2>

<form method="POST">
  <input type="hidden" name="cv125_seed" value="1">
  <button type="submit">Vložit dva ukázkové studenty</button>
</form>

<?php
if ($connection && isset($_POST["cv125_seed"])) {
  cv12query($connection, "INSERT INTO studenti (jmeno, rocnik) VALUES ('Eva', 2), ('Karel', 3)");
  echo "Byli vloženi studenti Eva a Karel.";
}
?>

<h2 class="subtitle">Cvičení 12.6</h2>

<?php if ($connection): ?>
  <?php $students = mysqli_query($connection, "SELECT * FROM studenti ORDER BY id DESC LIMIT 20"); ?>
  <ul>
    <?php while ($student = mysqli_fetch_assoc($students)): ?>
      <li>#<?= (int) $student["id"] ?>: <?= cv12h($student["jmeno"]) ?>, ročník <?= (int) $student["rocnik"] ?></li>
    <?php endwhile; ?>
  </ul>
<?php else: ?>
  <p><?= lessonDbUnavailableHtml($dbError) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 12.7</h2>

<?php
if ($connection) {
  $names = mysqli_query($connection, "SELECT jmeno FROM studenti ORDER BY jmeno");
  while ($row = mysqli_fetch_assoc($names)) {
    echo cv12h($row["jmeno"]) . "<br>";
  }
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 12.8</h2>

<form method="GET">
  <input type="hidden" name="route" value="lesson12">
  <input type="number" name="cv128_rocnik" placeholder="Ročník" value="<?= cv12h($_GET["cv128_rocnik"] ?? '') ?>">
  <button type="submit">Filtrovat</button>
</form>

<?php
if ($connection && isset($_GET["cv128_rocnik"]) && $_GET["cv128_rocnik"] !== '') {
  $year = (int) $_GET["cv128_rocnik"];
  $filtered = mysqli_query($connection, "SELECT * FROM studenti WHERE rocnik = {$year}");
  echo "Studenti v ročníku {$year}:<br>";
  while ($row = mysqli_fetch_assoc($filtered)) {
    echo cv12h($row["jmeno"]) . "<br>";
  }
}
?>

<h2 class="subtitle">Cvičení 12.9</h2>

<form method="POST">
  <input type="number" name="cv129_id" placeholder="ID">
  <input type="number" name="cv129_rocnik" placeholder="Nový ročník">
  <button type="submit">Změnit ročník</button>
</form>

<?php
if ($connection && !empty($_POST["cv129_id"]) && !empty($_POST["cv129_rocnik"])) {
  $id = (int) $_POST["cv129_id"];
  $year = (int) $_POST["cv129_rocnik"];
  cv12query($connection, "UPDATE studenti SET rocnik = {$year} WHERE id = {$id}");
  echo "Student s ID {$id} má nový ročník {$year}.";
}
?>

<h2 class="subtitle">Cvičení 12.10</h2>

<form method="POST">
  <input type="number" name="cv1210_id" placeholder="ID ke smazání">
  <button type="submit">Smazat</button>
</form>

<?php
if ($connection && !empty($_POST["cv1210_id"])) {
  $id = (int) $_POST["cv1210_id"];
  cv12query($connection, "DELETE FROM studenti WHERE id = {$id}");
  echo "Student s ID {$id} byl smazán.";
}
?>

<h2 class="subtitle">Cvičení 12.11</h2>

<?php
if ($connection) {
  $count = mysqli_fetch_row(mysqli_query($connection, "SELECT COUNT(*) FROM studenti"))[0] ?? 0;
  echo "Počet studentů v databázi: " . (int) $count;
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 12.12</h2>

<?php
if ($connection) {
  echo "Kódování připojení: " . cv12h(mysqli_character_set_name($connection)) . ". Tabulka používá utf8mb4.";
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 12.13</h2>

<?php
if (extension_loaded('mysqli')) {
  $config = lessonDbConfig();
  $badConnection = @mysqli_connect($config['host'], 'spatny_uzivatel', 'spatne_heslo', 'neexistuje', $config['port']);
  echo $badConnection
      ? "Chyba se nepodařila simulovat."
      : "Simulovaná chyba připojení: " . cv12h(mysqli_connect_error());
} else {
  echo "Rozšíření mysqli není načtené.";
}
?>

<h2 class="subtitle">Cvičení 12.14</h2>

<ul>
  <li>SELECT čte data z tabulky.</li>
  <li>INSERT vkládá nový záznam.</li>
  <li>UPDATE upravuje existující záznam.</li>
  <li>DELETE odstraňuje záznam.</li>
</ul>

<h2 class="subtitle">Cvičení 12.15</h2>

<p>PHP se připojí k MySQL, odešle SQL dotaz a zpracuje výsledek. V této lekci byly použity dotazy SELECT, INSERT, UPDATE a DELETE.</p>
