<?php declare(strict_types=1); ?>

<h2 class="subtitle">Cvičení 8.1</h2>

<form method="POST">
  <input type="text" name="cv81_name" placeholder="Vaše jméno">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv81_name"])) {
  echo "Vaše jméno je: " . htmlspecialchars($_POST["cv81_name"]);
}
?>

<h2 class="subtitle">Cvičení 8.2</h2>

<form method="GET">
  <input type="text" name="cv82_city" placeholder="Město">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_GET["cv82_city"])) {
  echo "Město: " . htmlspecialchars($_GET["cv82_city"]);
}
?>

<h2 class="subtitle">Cvičení 8.3</h2>
<small>Přihlašovací údaje jsou: admin / educapardubice</small>

<form method="POST">
  <input type="text" name="cv83_username" placeholder="Uživatelské jméno">
  <input type="password" name="cv83_password" placeholder="Heslo">
  <button type="submit">Přihlásit</button>
</form>

<?php
// This is NOT safe. This is not a real auth system. Do NOT do this. Do NOT be like my colleagues.
// Users are to be stored in a database and password hashed with a strong irreversible algorithm like bcrypt or argon2.
// I cannot stress this enough: DO NOT DO THIS IN A REAL PRODUCTION APP. This is just a simple example for learning purposes.
$users = [
  "admin" => [
    "displayName" => "Administrátor",
    "password" => "educapardubice",
  ],
];

if (isset($_POST["cv83_username"], $_POST["cv83_password"])) {
  $username = $_POST["cv83_username"];
  $password = $_POST["cv83_password"];

  if (!($user = $users[$username] ?? null) || $user["password"] !== $password) {
    echo "Neplatné přihlašovací údaje.";
    return;
  }

  $safeDisplayName = htmlspecialchars($user["displayName"]);
  $safeUsername = htmlspecialchars($username);
  echo "Přihlášení úspěšné! Vítejte, $safeDisplayName ($safeUsername).";
}
?>

<h2 class="subtitle">Cvičení 8.4</h2>

<form method="POST">
  <input type="text" name="cv84_field" placeholder="Zadejte cokoliv">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv84_field"])) {
  if (empty($_POST["cv84_field"])) {
    echo "Pole není vyplněno!";
  } else {
    echo "Zadáno: " . htmlspecialchars($_POST["cv84_field"]);
  }
}
?>

<h2 class="subtitle">Cvičení 8.5</h2>

<form method="POST">
  <input type="text" name="cv85_text" placeholder="  text s mezerami  ">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv85_text"])) {
  $raw = $_POST["cv85_text"];
  $trimmed = trim($raw);
  $safe = htmlspecialchars($trimmed);
  echo "Původní délka: " . strlen($raw) . "<br>";
  echo "Po trim(): " . strlen($trimmed) . "<br>";
  echo "Ošetřený text: " . $safe;
}
?>

<h2 class="subtitle">Cvičení 8.6</h2>

<form method="POST">
  <input type="number" name="cv86_age" placeholder="Váš věk">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv86_age"])) {
  $age = intval($_POST["cv86_age"]);
  echo "Věk jako číslo: " . $age;
}
?>

<h2 class="subtitle">Cvičení 8.7</h2>

<form method="POST">
  <input type="text" name="cv87_name" placeholder="Jméno">
  <input type="text" name="cv87_surname" placeholder="Příjmení">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv87_name"]) && !empty($_POST["cv87_surname"])) {
  $name = htmlspecialchars($_POST["cv87_name"]);
  $surname = htmlspecialchars($_POST["cv87_surname"]);
  echo "Jmenuji se $name $surname.";
}
?>

<h2 class="subtitle">Cvičení 8.8</h2>

<form method="POST">
  <select name="cv88_color">
    <option value="">-- Vyberte barvu --</option>
    <option value="červená">Červená</option>
    <option value="modrá">Modrá</option>
    <option value="zelená">Zelená</option>
    <option value="žlutá">Žlutá</option>
  </select>
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv88_color"])) {
  echo "Vybraná barva: " . htmlspecialchars($_POST["cv88_color"]);
}
?>

<h2 class="subtitle">Cvičení 8.9</h2>

<form method="POST">
  <label><input type="radio" name="cv89_sex" value="male"> Muž</label>
  <label><input type="radio" name="cv89_sex" value="female"> Žena</label>
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv89_sex"])) {
  $sex = $_POST["cv89_sex"];
  if ($sex === "male") {
    echo "Vítej, pane.";
  } elseif ($sex === "female") {
    echo "Vítej, paní.";
  }
}
?>

<h2 class="subtitle">Cvičení 8.10</h2>

<form method="POST">
  <label><input type="checkbox" name="cv810_hobbies[]" value="sport"> Sport</label>
  <label><input type="checkbox" name="cv810_hobbies[]" value="čtení"> Čtení</label>
  <label><input type="checkbox" name="cv810_hobbies[]" value="hudba"> Hudba</label>
  <label><input type="checkbox" name="cv810_hobbies[]" value="programování"> Programování</label>
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv810_hobbies"]) && is_array($_POST["cv810_hobbies"])) {
  $safe = array_map('htmlspecialchars', $_POST["cv810_hobbies"]);
  echo "Vybrané koníčky: " . implode(", ", $safe);
}
?>

<h2 class="subtitle">Cvičení 8.11</h2>

<form method="POST">
  <input type="email" name="cv811_email" placeholder="vas@email.cz">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv811_email"])) {
  // Validate email
  $isValidEmail = filter_var($_POST["cv811_email"], FILTER_VALIDATE_EMAIL);

  if ($isValidEmail) {
    echo "Váš e-mail: " . htmlspecialchars($_POST["cv811_email"]);
  } else {
    echo "Neplatný e-mail.";
  }
}
?>

<h2 class="subtitle">Cvičení 8.12</h2>

<form method="POST">
  <input type="password" name="cv812_password" placeholder="Heslo">
  <button type="submit">Odeslat</button>
</form>

<?php
if (isset($_POST["cv812_password"])) {
  if (strlen($_POST["cv812_password"]) < 8) {
    echo "Slabé heslo! (méně než 8 znaků)";
  } else {
    echo "Heslo je dostatečně silné.";
  }
}
?>

<h2 class="subtitle">Cvičení 8.13</h2>

<form method="POST">
  <input type="number" name="cv813_a" placeholder="Číslo 1">
  <input type="number" name="cv813_b" placeholder="Číslo 2">
  <button type="submit">Sečíst</button>
</form>

<?php
if (isset($_POST["cv813_a"], $_POST["cv813_b"])) {
  $a = intval($_POST["cv813_a"]);
  $b = intval($_POST["cv813_b"]);
  echo "Součet: $a + $b = " . ($a + $b);
}
?>

<h2 class="subtitle">Cvičení 8.14</h2>

<form method="POST">
  <input type="text" name="cv814_name" placeholder="Jméno">
  <input type="number" name="cv814_age" placeholder="Věk">
  <input type="text" name="cv814_city" placeholder="Město">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv814_name"]) && !empty($_POST["cv814_age"]) && !empty($_POST["cv814_city"])) {
  $name = htmlspecialchars($_POST["cv814_name"]);
  $age = intval($_POST["cv814_age"]);
  $city = htmlspecialchars($_POST["cv814_city"]);
  echo "Jmenuji se $name, je mi $age let a bydlím v městě $city.";
}
?>

<h2 class="subtitle">Cvičení 8.15</h2>

<form method="POST">
  <input type="text" name="cv815_name" placeholder="Jméno">
  <input type="number" name="cv815_age" placeholder="Věk">
  <input type="text" name="cv815_city" placeholder="Město">
  <input type="text" name="cv815_color" placeholder="Oblíbená barva">
  <button type="submit">Odeslat</button>
</form>

<?php
if (!empty($_POST["cv815_name"]) && !empty($_POST["cv815_age"]) && !empty($_POST["cv815_city"]) && !empty($_POST["cv815_color"])) {
  $name = htmlspecialchars($_POST["cv815_name"]);
  $age = intval($_POST["cv815_age"]);
  $city = htmlspecialchars($_POST["cv815_city"]);
  $color = htmlspecialchars($_POST["cv815_color"]);
  echo "<strong>Vizitka</strong><br>";
  echo "Jméno: $name<br>";
  echo "Věk: $age<br>";
  echo "Město: $city<br>";
  echo "Oblíbená barva: $color";
}
?>
