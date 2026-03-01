<?php declare(strict_types = 1); ?>

<h2 class="subtitle">Cvičení 5.1</h2>

<?php
$cislo = 15;
if ($cislo > 10) {
    echo "Číslo $cislo je větší než 10.";
}
?>

<h2 class="subtitle">Cvičení 5.2</h2>

<?php
$age = 20;
if ($age >= 18) {
    echo "Uživatel je dospělý.";
} else {
    echo "Uživatel není dospělý.";
}
?>

<h2 class="subtitle">Cvičení 5.3</h2>

<?php
$number = -3;
if ($number > 0) {
    echo "Číslo je kladné.";
} elseif ($number < 0) {
    echo "Číslo je záporné.";
} else {
    echo "Číslo je nula.";
}
?>

<h2 class="subtitle">Cvičení 5.4</h2>

<?php
$number = 42;
if ($number >= 1 && $number <= 100) {
    echo "Číslo $number je mezi 1 a 100.";
}
?>

<h2 class="subtitle">Cvičení 5.5</h2>

<?php
var_dump(5 === "5");
?>

<h2 class="subtitle">Cvičení 5.6</h2>

<?php
$number = 8;
if ($number % 2 === 0) {
    echo "Číslo $number je sudé.";
} else {
    echo "Číslo $number je liché.";
}
?>

<h2 class="subtitle">Cvičení 5.7</h2>

<?php
$age = 25;
if ($age >= 18 && $age <= 30) {
    echo "Člověk je mladý dospělý.";
}
?>

<h2 class="subtitle">Cvičení 5.8</h2>

<?php
$value = true;
echo "Původní: ";
var_dump($value);
echo "<br>Negace: ";
var_dump(!$value);
?>

<h2 class="subtitle">Cvičení 5.9</h2>

<?php
$x = 5;
// `if ($x = 5)` is incorrect as it assigns value instead of comparing
if ($x == 5) {
    echo "Proměnná \$x má hodnotu 5.";
}
?>

<h2 class="subtitle">Cvičení 5.10</h2>

<?php
$pohlavi = "muz";
if ($pohlavi === "muz") {
    echo "Vítej, pane.";
} elseif ($pohlavi === "zena") {
    echo "Vítej, paní.";
}
?>

<h2 class="subtitle">Cvičení 5.11</h2>

<?php
$temperature = 15;
if ($temperature < 0) {
    echo "Mrzne.";
} elseif ($temperature >= 0 && $temperature <= 20) {
    echo "Chladno.";
} else {
    echo "Teplo.";
}
?>

<h2 class="subtitle">Cvičení 5.12</h2>

<?php
$password = "abc123";
if (strlen($password) < 8) {
    echo "Heslo je slabé.";
} else {
    echo "Heslo je silné.";
}
?>

<h2 class="subtitle">Cvičení 5.13</h2>

<?php
$age = 16;
$parentalConsent = true;
if ($age >= 18 || $parentalConsent) {
    echo "Může se zúčastnit.";
} else {
    echo "Nemůže se zúčastnit.";
}
?>

<h2 class="subtitle">Cvičení 5.14</h2>

<?php
$cas = 14;
if ($cas < 12) {
    echo "Dopolední akce.";
} elseif ($cas >= 12 && $cas <= 18) {
    echo "Odpolední akce.";
} else {
    echo "Večerní akce.";
}
?>
