<?php declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$lesson18Dir = $dataDir . '/lesson18';
$lesson18Dir = lessonWritableDir($lesson18Dir, 'prw_lesson18');
$lesson18UploadsDir = lessonWritableDir($lesson18Dir . '/uploads', 'prw_lesson18/uploads');
if (!is_dir($lesson18UploadsDir)) {
  mkdir($lesson18UploadsDir, 0755, true);
}

if (empty($_SESSION["cv186_token"])) {
  $_SESSION["cv186_token"] = bin2hex(random_bytes(32));
}

if (isset($_POST["cv1814_logout"])) {
  unset($_SESSION["cv1815_user"]);
  session_regenerate_id(true);
}

function cv18h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$dbError = null;
$pdo = lessonDbPdo($dbError);
if ($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS uzivatele_security (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(120) NOT NULL UNIQUE,
    heslo_hash VARCHAR(255) NOT NULL,
    jmeno VARCHAR(100) NOT NULL
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci");

  $statement = $pdo->prepare("INSERT IGNORE INTO uzivatele_security (email, heslo_hash, jmeno) VALUES (?, ?, ?)");
  $statement->execute(['student@example.com', password_hash('tajne123', PASSWORD_DEFAULT), 'Student']);
}
?>

<h2 class="subtitle">Cvičení 18.1</h2>

<form method="POST">
  <input type="text" name="cv181_text" placeholder="<script>alert('xss')</script>">
  <button type="submit">Ošetřit</button>
</form>
<?php if (isset($_POST["cv181_text"])): ?>
  <p>Bezpečný výstup: <?= cv18h($_POST["cv181_text"]) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 18.2</h2>

<form method="POST">
  <input type="email" name="cv182_email" placeholder="student@example.com">
  <button type="submit">Prepared SELECT</button>
</form>
<?php
if ($pdo && isset($_POST["cv182_email"])) {
  $statement = $pdo->prepare("SELECT * FROM uzivatele_security WHERE email = ?");
  $statement->execute([trim($_POST["cv182_email"])]);
  $user = $statement->fetch();
  echo $user ? "Nalezen uživatel: " . cv18h($user["jmeno"]) : "Uživatel nenalezen.";
} elseif (!$pdo) {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 18.3</h2>

<?php
$hash = password_hash('tajne123', PASSWORD_DEFAULT);
echo "Hash hesla: " . cv18h($hash);
?>

<h2 class="subtitle">Cvičení 18.4</h2>

<p><?= password_verify('tajne123', $hash) ? "Heslo odpovídá hashi." : "Heslo neodpovídá." ?></p>

<h2 class="subtitle">Cvičení 18.5</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="file" name="cv185_file">
  <button type="submit">Nahrát obrázek</button>
</form>

<?php
$uploadMessage = null;
if (isset($_FILES["cv185_file"]) && $_FILES["cv185_file"]["error"] !== UPLOAD_ERR_NO_FILE) {
  $file = $_FILES["cv185_file"];
  $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  $allowedExtensions = ['jpg', 'jpeg', 'png'];
  $allowedTypes = ['image/jpeg', 'image/png'];
  $type = is_file($file["tmp_name"]) ? (mime_content_type($file["tmp_name"]) ?: $file["type"]) : $file["type"];

  if ($file["error"] !== UPLOAD_ERR_OK) {
    $uploadMessage = "Upload se nezdařil.";
  } elseif (!in_array($extension, $allowedExtensions, true) || !in_array($type, $allowedTypes, true)) {
    $uploadMessage = "Nepovolený typ souboru.";
  } elseif ($file["size"] > 2 * 1024 * 1024) {
    $uploadMessage = "Soubor je větší než 2 MB.";
  } else {
    $safeName = bin2hex(random_bytes(8)) . '.' . $extension;
    move_uploaded_file($file["tmp_name"], $lesson18UploadsDir . '/' . $safeName);
    $uploadMessage = "Soubor uložen jako " . cv18h($safeName);
  }
}
if ($uploadMessage !== null) {
  echo "<p>{$uploadMessage}</p>";
}
?>

<h2 class="subtitle">Cvičení 18.6</h2>

<form method="POST">
  <input type="hidden" name="cv186_token" value="<?= cv18h($_SESSION["cv186_token"]) ?>">
  <input type="text" name="cv186_message" placeholder="Zpráva chráněná tokenem">
  <button type="submit">Odeslat s CSRF tokenem</button>
</form>
<?php if (isset($_POST["cv186_message"])): ?>
  <p><?= hash_equals($_SESSION["cv186_token"], $_POST["cv186_token"] ?? '') ? "Token je platný." : "Neplatný token!" ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 18.7</h2>

<?php
$databaseTitle = '<script>alert("xss")</script> Název z databáze';
echo "Escapovaný výpis z databáze: " . cv18h($databaseTitle);
?>

<h2 class="subtitle">Cvičení 18.8</h2>

<p>Upload ve cvičení 18.5 kontroluje limit velikosti 2 MB před uložením souboru.</p>

<h2 class="subtitle">Cvičení 18.9</h2>

<p>Při nahrání souboru s příponou například .exe formulář zobrazí hlášku „Nepovolený typ souboru.“</p>

<h2 class="subtitle">Cvičení 18.10</h2>

<form method="POST">
  <input type="email" name="cv1810_email" placeholder="student@example.com">
  <input type="password" name="cv1810_password" placeholder="tajne123">
  <button type="submit">Bezpečně přihlásit</button>
</form>
<?php
if ($pdo && isset($_POST["cv1810_email"], $_POST["cv1810_password"])) {
  $statement = $pdo->prepare("SELECT * FROM uzivatele_security WHERE email = ?");
  $statement->execute([trim($_POST["cv1810_email"])]);
  $user = $statement->fetch();
  echo $user && password_verify($_POST["cv1810_password"], $user["heslo_hash"])
      ? "Přihlášen uživatel " . cv18h($user["jmeno"])
      : "Neplatné přihlašovací údaje.";
}
?>

<h2 class="subtitle">Cvičení 18.11</h2>

<form method="POST">
  <input type="text" name="cv1811_field" placeholder="Povinné pole">
  <button type="submit">Validovat</button>
</form>
<?php if (isset($_POST["cv1811_field"])): ?>
  <p><?= trim($_POST["cv1811_field"]) === '' ? "Pole nesmí být prázdné." : "Pole je vyplněné." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 18.12</h2>

<form method="POST">
  <input type="text" name="cv1812_text" placeholder="Text">
  <button type="submit">Sanitizovat</button>
</form>
<?php if (isset($_POST["cv1812_text"])): ?>
  <p><?= cv18h(filter_var($_POST["cv1812_text"], FILTER_SANITIZE_STRING)) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 18.13</h2>

<?php
if ($pdo) {
  try {
    $pdo->query("SELECT * FROM sql_tabulka_ktera_neexistuje");
  } catch (PDOException $e) {
    echo "SQL chyba zachycena: " . cv18h($e->getMessage());
  }
} else {
  echo lessonDbUnavailableHtml($dbError);
}
?>

<h2 class="subtitle">Cvičení 18.14</h2>

<form method="POST">
  <input type="hidden" name="cv1814_logout" value="1">
  <button type="submit">Bezpečně odhlásit</button>
</form>

<h2 class="subtitle">Cvičení 18.15</h2>

<form method="POST">
  <input type="hidden" name="cv1815_token" value="<?= cv18h($_SESSION["cv186_token"]) ?>">
  <input type="email" name="cv1815_email" placeholder="student@example.com">
  <input type="password" name="cv1815_password" placeholder="tajne123">
  <button type="submit">Bezpečný login</button>
</form>
<?php
if ($pdo && isset($_POST["cv1815_email"], $_POST["cv1815_password"])) {
  if (!hash_equals($_SESSION["cv186_token"], $_POST["cv1815_token"] ?? '')) {
    echo "Neplatný CSRF token.";
  } elseif (trim($_POST["cv1815_email"]) === '' || trim($_POST["cv1815_password"]) === '') {
    echo "Email a heslo nesmí být prázdné.";
  } else {
    $statement = $pdo->prepare("SELECT * FROM uzivatele_security WHERE email = ?");
    $statement->execute([trim($_POST["cv1815_email"])]);
    $user = $statement->fetch();

    if ($user && password_verify($_POST["cv1815_password"], $user["heslo_hash"])) {
      $_SESSION["cv1815_user"] = $user["email"];
      echo "Bezpečně přihlášen: " . cv18h($user["email"]);
    } else {
      echo "Neplatné přihlašovací údaje.";
    }
  }
}
?>
