<?php declare(strict_types=1);

function cv15h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$redirectErrors = [];
if (isset($_POST["cv1512_submit"])) {
  $description = trim($_POST["cv1512_description"] ?? '');
  if ($description === '') {
    $redirectErrors[] = "Popis nesmí být prázdný.";
  }

  if (empty($redirectErrors)) {
    header('Location: ' . ($router->link('lesson15', ['cv1512_success' => '1']) ?? '?route=lesson15&cv1512_success=1'));
    exit;
  }
}
?>

<h2 class="subtitle">Cvičení 15.1</h2>

<form method="POST">
  <input type="text" name="cv151_name" placeholder="Jméno">
  <button type="submit">Ověřit</button>
</form>

<?php if (isset($_POST["cv151_name"])): ?>
  <p><?= trim($_POST["cv151_name"]) === '' ? "Jméno je povinné." : "Jméno: " . cv15h(trim($_POST["cv151_name"])) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.2</h2>

<?php
$name = trim($_POST["cv152_name"] ?? '');
?>
<form method="POST">
  <input type="text" name="cv152_name" placeholder="Jméno alespoň 5 znaků" value="<?= cv15h($name) ?>">
  <button type="submit">Ověřit délku</button>
</form>
<?php if (isset($_POST["cv152_name"])): ?>
  <p><?= mb_strlen($name) >= 5 ? "Délka je v pořádku." : "Jméno musí mít alespoň 5 znaků." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.3</h2>

<form method="POST">
  <input type="email" name="cv153_email" placeholder="Email">
  <button type="submit">Validovat email</button>
</form>
<?php if (isset($_POST["cv153_email"])): ?>
  <p><?= filter_var($_POST["cv153_email"], FILTER_VALIDATE_EMAIL) ? "Email je platný." : "Email není ve správném formátu." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.4</h2>

<form method="POST">
  <input type="text" name="cv154_price" placeholder="Cena">
  <button type="submit">Zkontrolovat cenu</button>
</form>
<?php if (isset($_POST["cv154_price"])): ?>
  <p><?= is_numeric($_POST["cv154_price"]) && (float) $_POST["cv154_price"] > 0 ? "Cena je platná." : "Cena musí být číslo > 0." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.5</h2>

<?php
$errors = [];
if (isset($_POST["cv155_submit"])) {
  if (trim($_POST["cv155_name"] ?? '') === '') {
    $errors[] = "Jméno je povinné.";
  }
  if (!filter_var($_POST["cv155_email"] ?? '', FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email není platný.";
  }
}
?>
<form method="POST">
  <input type="hidden" name="cv155_submit" value="1">
  <input type="text" name="cv155_name" placeholder="Jméno">
  <input type="text" name="cv155_email" placeholder="Email">
  <button type="submit">Vypsat chyby</button>
</form>
<?php foreach ($errors as $error): ?>
  <p style="color:red"><?= cv15h($error) ?></p>
<?php endforeach; ?>

<h2 class="subtitle">Cvičení 15.6</h2>

<form method="POST">
  <input type="text" name="cv156_text" placeholder="Text s mezerami">
  <button type="submit">Trim</button>
</form>
<?php if (isset($_POST["cv156_text"])): ?>
  <p>Před: „<?= cv15h($_POST["cv156_text"]) ?>“</p>
  <p>Po trim: „<?= cv15h(trim($_POST["cv156_text"])) ?>“</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.7</h2>

<form method="POST">
  <input type="text" name="cv157_text" placeholder="Text k sanitizaci">
  <button type="submit">Sanitizovat</button>
</form>
<?php if (isset($_POST["cv157_text"])): ?>
  <p><?= cv15h(filter_var(trim($_POST["cv157_text"]), FILTER_SANITIZE_STRING)) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.8</h2>

<form method="POST">
  <input type="text" name="cv158_text" placeholder="<script>alert('xss')</script>">
  <button type="submit">Escapovat</button>
</form>
<?php if (isset($_POST["cv158_text"])): ?>
  <p>Bezpečný výstup: <?= cv15h($_POST["cv158_text"]) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.9</h2>

<?php
$twoInputErrors = [];
if (isset($_POST["cv159_submit"])) {
  if (trim($_POST["cv159_name"] ?? '') === '') {
    $twoInputErrors[] = "Jméno nesmí být prázdné.";
  }
  if (!ctype_digit($_POST["cv159_age"] ?? '') || (int) $_POST["cv159_age"] <= 0) {
    $twoInputErrors[] = "Věk musí být kladné celé číslo.";
  }
}
?>
<form method="POST">
  <input type="hidden" name="cv159_submit" value="1">
  <input type="text" name="cv159_name" placeholder="Jméno">
  <input type="number" name="cv159_age" placeholder="Věk">
  <button type="submit">Validovat</button>
</form>
<?php foreach ($twoInputErrors as $error): ?>
  <p style="color:red"><?= cv15h($error) ?></p>
<?php endforeach; ?>

<h2 class="subtitle">Cvičení 15.10</h2>

<form method="POST">
  <input type="password" name="cv1510_password" placeholder="Heslo">
  <input type="password" name="cv1510_password_confirm" placeholder="Heslo znovu">
  <button type="submit">Porovnat</button>
</form>
<?php if (isset($_POST["cv1510_password"])): ?>
  <p><?= ($_POST["cv1510_password"] !== '' && $_POST["cv1510_password"] === ($_POST["cv1510_password_confirm"] ?? '')) ? "Hesla se shodují." : "Hesla musí být dvě a stejná." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.11</h2>

<form method="POST">
  <input type="text" name="cv1511_field" placeholder="Povinné pole">
  <button type="submit">Ověřit</button>
</form>
<?php if (isset($_POST["cv1511_field"]) && trim($_POST["cv1511_field"]) === ''): ?>
  <p style="color:red">Pole nesmí být prázdné</p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.12</h2>

<?php if (isset($_GET["cv1512_success"])): ?>
  <p>Validace proběhla úspěšně a stránka byla přesměrována.</p>
<?php endif; ?>
<form method="POST">
  <input type="hidden" name="cv1512_submit" value="1">
  <input type="text" name="cv1512_description" placeholder="Popis">
  <button type="submit">Validovat a přesměrovat</button>
</form>
<?php foreach ($redirectErrors as $error): ?>
  <p style="color:red"><?= cv15h($error) ?></p>
<?php endforeach; ?>

<h2 class="subtitle">Cvičení 15.13</h2>

<form method="POST">
  <textarea name="cv1513_description" placeholder="Popis 10 až 200 znaků"></textarea>
  <button type="submit">Ověřit popis</button>
</form>
<?php if (isset($_POST["cv1513_description"])): ?>
  <?php $length = mb_strlen(trim($_POST["cv1513_description"])); ?>
  <p><?= $length >= 10 && $length <= 200 ? "Popis má správnou délku." : "Popis musí mít min. 10 a max. 200 znaků." ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.14</h2>

<form method="POST">
  <input type="text" name="cv1514_number" placeholder="Např. 123,45 Kč">
  <button type="submit">Filtrovat číslo</button>
</form>
<?php if (isset($_POST["cv1514_number"])): ?>
  <p><?= cv15h(filter_var($_POST["cv1514_number"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 15.15</h2>

<?php
$loginErrors = [];
if (isset($_POST["cv1515_submit"])) {
  if (!filter_var($_POST["cv1515_email"] ?? '', FILTER_VALIDATE_EMAIL)) {
    $loginErrors[] = "Email není platný.";
  }
  if (mb_strlen($_POST["cv1515_password"] ?? '') < 6) {
    $loginErrors[] = "Heslo musí mít alespoň 6 znaků.";
  }
}
?>
<form method="POST">
  <input type="hidden" name="cv1515_submit" value="1">
  <input type="email" name="cv1515_email" placeholder="Email">
  <input type="password" name="cv1515_password" placeholder="Heslo">
  <button type="submit">Přihlásit</button>
</form>
<?php foreach ($loginErrors as $error): ?>
  <p style="color:red"><?= cv15h($error) ?></p>
<?php endforeach; ?>
<?php if (isset($_POST["cv1515_submit"]) && empty($loginErrors)): ?>
  <p>Přihlášení má platné vstupy.</p>
<?php endif; ?>
