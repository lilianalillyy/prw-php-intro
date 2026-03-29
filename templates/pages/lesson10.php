<?php declare(strict_types=1);

// Just like in lesson 9, we will start the session here for demonstration purposes,
// but it's not recommended to do such logic in templates.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Cv 10.7 – set cookie (only if not deleting)
if (isset($_POST["cv1010_delete"])) {
  setcookie("cv107_color", "", time() - 3600);
} elseif (isset($_POST["cv107_set"])) {
  setcookie("cv107_color", "modrá", time() + 3600);
}

// Cv 10.9 – short-lived cookie
if (isset($_POST["cv109_set"])) {
  setcookie("cv109_short", "dočasná", time() + 10);
}

// Cv 10.11 – httponly cookie
if (isset($_POST["cv1011_set"])) {
  setcookie("cv1011_secure", "hodnota", [
    'expires' => time() + 3600,
    'path' => '/',
    'httponly' => true,
  ]);
}

// Cv 10.12 – login
if (!empty($_POST["cv1012_name"])) {
  $_SESSION["cv1012_uzivatel"] = $_POST["cv1012_name"];
}

// Cv 10.14 – logout
if (isset($_POST["cv1014_logout"])) {
  unset($_SESSION["cv1012_uzivatel"]);
}

// Cv 10.15 – remember me
if (!empty($_POST["cv1015_name"])) {
  $_SESSION["cv1015_user"] = $_POST["cv1015_name"];
  if (isset($_POST["cv1015_remember"])) {
    setcookie("cv1015_name", $_POST["cv1015_name"], time() + 86400);
  }
}
?>

<h2 class="subtitle">Cvičení 10.1</h2>

<?php
echo "Session je aktivní. ID: " . session_id();
?>

<h2 class="subtitle">Cvičení 10.2</h2>

<?php
$_SESSION["cv102_name"] = "Kristýna";
echo "Jméno uloženo do \$_SESSION: " . htmlspecialchars($_SESSION["cv102_name"]);
?>

<h2 class="subtitle">Cvičení 10.3</h2>

<?php
if (isset($_SESSION["cv102_name"])) {
  echo "Jméno ze session: " . htmlspecialchars($_SESSION["cv102_name"]);
}
?>

<h2 class="subtitle">Cvičení 10.4</h2>

<?php
$_SESSION["cv104_name"] = "Mia";
echo "Původní: " . htmlspecialchars($_SESSION["cv104_name"]) . "<br>";
$_SESSION["cv104_name"] = "Kristýna";
echo "Nová hodnota: " . htmlspecialchars($_SESSION["cv104_name"]);
?>

<h2 class="subtitle">Cvičení 10.5</h2>

<?php
$_SESSION["cv105_test"] = "bude smazáno";
echo "Před unset: " . htmlspecialchars($_SESSION["cv105_test"]) . "<br>";
unset($_SESSION["cv105_test"]);
echo "Po unset: " . (isset($_SESSION["cv105_test"]) ? $_SESSION["cv105_test"] : "hodnota neexistuje");
?>

<h2 class="subtitle">Cvičení 10.6</h2>

<?php
// session_destroy() ukončí celou session — nevoláme, abychom nenarušili ostatní cvičení
echo "Funkce session_destroy() ukončí celou session.<br>";
echo "Aktuální session ID: " . session_id();
?>

<h2 class="subtitle">Cvičení 10.7</h2>

<form method="POST">
  <input type="hidden" name="cv107_set" value="1">
  <button type="submit">Nastavit cookie</button>
</form>

<?php
if (isset($_POST["cv107_set"])) {
  echo "Cookie 'cv107_color' nastavena na 'modrá' (1 hodina).<br>";
  echo "Obnovte stránku pro zobrazení hodnoty.";
} elseif (isset($_COOKIE["cv107_color"])) {
  echo "Cookie existuje: " . htmlspecialchars($_COOKIE["cv107_color"]);
} else {
  echo "Cookie zatím není nastavena. Klikněte na tlačítko.";
}
?>

<h2 class="subtitle">Cvičení 10.8</h2>

<?php
if (isset($_COOKIE["cv107_color"])) {
  echo "Barva z cookie: " . htmlspecialchars($_COOKIE["cv107_color"]);
} else {
  echo "Cookie 'cv107_color' zatím není dostupné. Nastavte ji ve cvičení 10.7.";
}
?>

<h2 class="subtitle">Cvičení 10.9</h2>

<form method="POST">
  <input type="hidden" name="cv109_set" value="1">
  <button type="submit">Nastavit cookie (10 sekund)</button>
</form>

<?php
if (isset($_POST["cv109_set"])) {
  echo "Cookie 'cv109_short' nastavena s expirací 10 sekund.<br>";
  echo "Obnovte stránku — po 10 sekundách cookie zmizí.";
} elseif (isset($_COOKIE["cv109_short"])) {
  echo "Hodnota: " . htmlspecialchars($_COOKIE["cv109_short"]) . " (brzy vyprší)";
} else {
  echo "Cookie vypršela nebo zatím není nastavena.";
}
?>

<h2 class="subtitle">Cvičení 10.10</h2>

<form method="POST">
  <input type="hidden" name="cv1010_delete" value="1">
  <button type="submit">Smazat cookie cv107_color</button>
</form>

<?php
if (isset($_POST["cv1010_delete"])) {
  echo "Cookie 'cv107_color' smazána.";
}
?>

<h2 class="subtitle">Cvičení 10.11</h2>

<form method="POST">
  <input type="hidden" name="cv1011_set" value="1">
  <button type="submit">Nastavit httponly cookie</button>
</form>

<?php
if (isset($_POST["cv1011_set"])) {
  echo "Cookie 'cv1011_secure' nastavena s httponly = true.<br>";
  echo "Tato cookie není přístupná z JavaScriptu.";
} elseif (isset($_COOKIE["cv1011_secure"])) {
  echo "Bezpečná cookie existuje (httponly — nelze přečíst z JS).";
} else {
  echo "Klikněte na tlačítko pro nastavení httponly cookie.";
}
?>

<h2 class="subtitle">Cvičení 10.12</h2>

<form method="POST">
  <input type="text" name="cv1012_name" placeholder="Vaše jméno">
  <button type="submit">Přihlásit</button>
</form>

<?php
if (isset($_SESSION["cv1012_uzivatel"])) {
  echo "Přihlášen jako: " . htmlspecialchars($_SESSION["cv1012_uzivatel"]);
}
?>

<h2 class="subtitle">Cvičení 10.13</h2>

<?php
if (isset($_SESSION["cv1012_uzivatel"])) {
  echo "Uživatel je přihlášen: " . htmlspecialchars($_SESSION["cv1012_uzivatel"]);
} else {
  echo "Uživatel není přihlášen.";
}
?>

<h2 class="subtitle">Cvičení 10.14</h2>

<?php if (isset($_SESSION["cv1012_uzivatel"])): ?>
  <form method="POST">
    <input type="hidden" name="cv1014_logout" value="1">
    <button type="submit">Odhlásit</button>
  </form>
<?php else: ?>
  <p>Nejste přihlášeni (přihlaste se ve cvičení 10.12).</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 10.15</h2>

<?php
$rememberedName = $_COOKIE["cv1015_name"] ?? "";
?>

<form method="POST">
  <input type="text" name="cv1015_name" placeholder="Vaše jméno"
    value="<?= htmlspecialchars($rememberedName) ?>">
  <label><input type="checkbox" name="cv1015_remember" value="1"> Pamatuj si mě</label>
  <button type="submit">Přihlásit</button>
</form>

<?php
if (isset($_SESSION["cv1015_user"])) {
  echo "Přihlášen: " . htmlspecialchars($_SESSION["cv1015_user"]);
  if (!empty($rememberedName)) {
    echo " (zapamatováno z cookie)";
  }
}
?>
