<?php declare(strict_types=1); ?>

<h2 class="subtitle">Cvičení 6.1</h2>

<?php
for ($i = 1; $i <= 10; $i++) {
  echo $i . " ";
}
?>

<h2 class="subtitle">Cvičení 6.2</h2>

<?php
for ($i = 1; $i <= 20; $i++) {
  if ($i % 2 === 0) {
    echo $i . " ";
  }
}
?>

<h2 class="subtitle">Cvičení 6.3</h2>

<?php
for ($i = 10; $i >= 1; $i--) {
  echo $i . " ";
}
?>

<h2 class="subtitle">Cvičení 6.4</h2>

<?php
$i = 1;
while ($i <= 5) {
  echo $i . " ";
  $i++;
}
?>

<h2 class="subtitle">Cvičení 6.5</h2>

<?php
$i = 1;
do {
  echo "Tento cyklus se provede alespoň jednou. Iterace: $i";
  $i++;
} while ($i <= 1);
?>

<h2 class="subtitle">Cvičení 6.6</h2>

<?php
$animals = ["pes", "kočka", "králík"];
foreach ($animals as $animal) {
  echo $animal . " ";
}
?>

<h2 class="subtitle">Cvičení 6.7</h2>

<?php
$sentence = "Ahoj jak se máš";
$words = explode(" ", $sentence);
foreach ($words as $word) {
  echo $word . "<br>";
}
?>

<h2 class="subtitle">Cvičení 6.8</h2>

<?php
for ($i = 1; $i <= 10; $i++) {
  echo (7 * $i) . " ";
}
?>

<h2 class="subtitle">Cvičení 6.9</h2>

<?php
$sum = 0;
for ($i = 1; $i <= 100; $i++) {
  $sum += $i;
}
echo "Součet čísel 1–100: $sum";
?>

<h2 class="subtitle">Cvičení 6.10</h2>

<?php
for ($i = 1; $i <= 10; $i++) {
  if ($i === 5) {
    break;
  }
  echo $i . " ";
}
?>

<h2 class="subtitle">Cvičení 6.11</h2>

<?php
for ($i = 1; $i <= 10; $i++) {
  if ($i === 7) {
    continue;
  }
  echo $i . " ";
}
?>

<h2 class="subtitle">Cvičení 6.12</h2>

<?php
$prices = [99, 149, 349];
foreach ($prices as $price) {
  echo $price . " Kč<br>";
}
?>

<h2 class="subtitle">Cvičení 6.13</h2>

<?php
$names = ["Petr", "Eva", "Kristýna"];
foreach ($names as $name) {
  echo "Ahoj, $name!<br>";
}
?>

<h2 class="subtitle">Cvičení 6.14</h2>

<?php
$numbers = [3, 5, 7, 9, 12];
$searched = 7;
foreach ($numbers as $number) {
  if ($number === $searched) {
    echo "Nalezeno: $searched";
    break;
  }
}
?>
