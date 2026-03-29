<?php declare(strict_types=1);

// In practice, you would typically have a framework automatically (or lazily, when needed) initialize a session for you.
// For demonstration within this lesson, we will start the session here, but it's not recommended to do such logic in templates,
// which should ideally be focused on presentation rather than application logic (sessions, cookies, processing forms)... separation of concerns and all that.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<h2 class="subtitle">Cvičení 9.1</h2>

<?php
if (isset($_GET["cv91_name"])) {
  echo "Jméno z URL: " . htmlspecialchars($_GET["cv91_name"]);
} else {
  echo "Přidejte do URL parametr <code>?cv91_name=VašeJméno</code>";
}
?>

<h2 class="subtitle">Cvičení 9.2</h2>

<form method="POST">
  <input type="text" name="cv92_name" placeholder="Vaše jméno">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv92_name"])) {
  echo "Jméno z POST: " . htmlspecialchars($_POST["cv92_name"]);
}
?>

<h2 class="subtitle">Cvičení 9.3</h2>

<form method="POST">
  <input type="text" name="cv93_data" placeholder="Zadejte text">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv93_data"])) {
  echo "Formulář byl odeslán. Hodnota: " . htmlspecialchars($_POST["cv93_data"]);
} else {
  echo "Formulář nebyl odeslán.";
}
?>

<h2 class="subtitle">Cvičení 9.4</h2>

<?php
if (isset($_REQUEST["cv91_name"])) {
  echo "Hodnota z \$_REQUEST: " . htmlspecialchars($_REQUEST["cv91_name"]);
} else {
  echo "\$_REQUEST['cv91_name'] není nastaveno. Zkuste přidat ?cv91_name=... do URL.";
}
?>

<h2 class="subtitle">Cvičení 9.5</h2>

<?php
echo "Metoda požadavku: " . htmlspecialchars($_SERVER["REQUEST_METHOD"]);
?>

<h2 class="subtitle">Cvičení 9.6</h2>

<?php
echo "Vaše IP adresa: " . htmlspecialchars($_SERVER["REMOTE_ADDR"]);
?>

<h2 class="subtitle">Cvičení 9.7</h2>

<?php
$_SESSION["cv97_name"] = "Kristýna";
echo "Jméno uloženo do session: " . htmlspecialchars($_SESSION["cv97_name"]);
?>

<h2 class="subtitle">Cvičení 9.8</h2>

<?php
if (!isset($_SESSION["cv98_name"])) {
  $_SESSION["cv98_name"] = "Mia";
} else {
  // Toggle between the two names for demonstration
  $_SESSION["cv98_name"] = $_SESSION["cv98_name"] === "Mia" ? "Kristýna" : "Mia";
}

echo "Aktuální jméno v session: " . htmlspecialchars($_SESSION["cv98_name"]);
?>

<h2 class="subtitle">Cvičení 9.9</h2>

<?php
setcookie("cv99_color", "modrá", time() + 3600);

echo "Cookie 'cv99_color' nastavena na 'modrá' (1 hodina).<br>";
if (isset($_COOKIE["cv99_color"])) {
  echo "Aktuální hodnota: " . htmlspecialchars($_COOKIE["cv99_color"]);
} else {
  echo "Cookie bude dostupná po obnovení stránky.";
}
?>

<h2 class="subtitle">Cvičení 9.10</h2>

<?php
setcookie("cv910_short", "test", time() + 300);

echo "Cookie 'cv910_short' nastavena s expirací 5 minut.<br>";
if (isset($_COOKIE["cv910_short"])) {
  echo "Hodnota: " . htmlspecialchars($_COOKIE["cv910_short"]);
} else {
  echo "Cookie bude dostupné po obnovení stránky.";
}
?>

<h2 class="subtitle">Cvičení 9.11</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="file" name="cv911_file">
  <button type="submit">Nahrát</button>
</form>

<?php
if (isset($_FILES["cv911_file"]) && $_FILES["cv911_file"]["error"] === UPLOAD_ERR_OK) {
  echo "Název souboru: " . htmlspecialchars($_FILES["cv911_file"]["name"]);
}
?>

<h2 class="subtitle">Cvičení 9.12</h2>

<?php
if (isset($_FILES["cv911_file"]) && $_FILES["cv911_file"]["error"] === UPLOAD_ERR_OK) {
  // This is a very basic check based on the file's extension. In reality, someone could theoretically upload a malicious .jpg that is not actually a valid JPEG,
  // so for real applications you would want to do more thorough validation (e.g. checking MIME type, using getimagesize(), validating metadata, etc.).
  $ext = strtolower(pathinfo($_FILES["cv911_file"]["name"], PATHINFO_EXTENSION));
  if ($ext === "jpg" || $ext === "jpeg") {
    echo "Soubor je JPEG obrázek.";
  } else {
    echo "Soubor NENÍ JPEG (přípona: ." . htmlspecialchars($ext) . ").";
  }
} else {
  echo "Nahrajte soubor ve cvičení 9.11 pro kontrolu typu.";
}
?>

<h2 class="subtitle">Cvičení 9.13</h2>

<?php
echo "Aktuální skript: " . htmlspecialchars($_SERVER["PHP_SELF"]);
?>

<h2 class="subtitle">Cvičení 9.14</h2>

<form method="GET">
  <input type="text" name="cv914_get" placeholder="GET data">
  <button type="submit">Odeslat GET</button>
</form>

<form method="POST">
  <input type="text" name="cv914_post" placeholder="POST data">
  <button type="submit">Odeslat POST</button>
</form>

<?php
if (isset($_GET["cv914_get"])) {
  echo "Z GET: " . htmlspecialchars($_GET["cv914_get"]) . "<br>";
}
if (isset($_POST["cv914_post"])) {
  echo "Z POST: " . htmlspecialchars($_POST["cv914_post"]);
}
?>

<h2 class="subtitle">Cvičení 9.15</h2>

<form method="POST">
  <input type="text" name="cv915_name" placeholder="Vaše jméno">
  <button type="submit">Zobrazit info</button>
</form>

<?php
echo "<strong>Info panel:</strong><br>";
if (!empty($_POST["cv915_name"])) {
  echo "Jméno (POST): " . htmlspecialchars($_POST["cv915_name"]) . "<br>";
}
echo "GET parametry: ";
if (!empty($_GET)) {
  echo htmlspecialchars(http_build_query($_GET));
} else {
  echo "žádné";
}
echo "<br>";
echo "IP adresa: " . htmlspecialchars($_SERVER["REMOTE_ADDR"]) . "<br>";
echo "Aktuální čas: " . date("H:i:s d.m.Y");
?>
