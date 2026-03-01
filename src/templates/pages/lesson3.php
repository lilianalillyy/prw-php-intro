<?php declare(strict_types = 1); ?>

<h2 class="subtitle">Cvičení 3.1</h2>

<?php
$a = 12;
$b = 4;
var_dump(compact('a', 'b')); // show values of a and b
echo "<br>";
echo "Součet: " . ($a + $b) . "<br>";
echo "Rozdíl: " . ($a - $b) . "<br>";
echo "Součin: " . ($a * $b) . "<br>";
echo "Podíl: " . ($a / $b) . "<br>";
?>

<h2 class="subtitle">Cvičení 3.2</h2>

<?php
echo "Zbytek po dělení 17 a 5: " . (17 % 5);
?>

<h2 class="subtitle">Cvičení 3.3</h2>

<?php
$x = 10;
$x += 5;
$x -= 2;
$x *= 3;
echo "Výsledek: $x";
?>

<h2 class="subtitle">Cvičení 3.4</h2>

<?php
var_dump(10 == "10");
echo "<br>";
var_dump(10 === "10");
?>

<h2 class="subtitle">Cvičení 3.5</h2>

<?php
var_dump(7 != 5);
?>

<h2 class="subtitle">Cvičení 3.6</h2>

<?php
$vek = 20;
if ($vek >= 15 && $vek <= 30) {
    echo "Věk je mezi 15 a 30.";
}
?>

<h2 class="subtitle">Cvičení 3.7</h2>

<?php
$a = true;
$b = false;
var_dump($a || $b);
?>

<h2 class="subtitle">Cvičení 3.8</h2>

<?php
var_dump(!false);
?>

<h2 class="subtitle">Cvičení 3.9</h2>

<?php
$jmeno = "Eva";
$prijmeni = "Nováková";
echo "Jmenuji se " . $jmeno . " " . $prijmeni . ".";
?>

<h2 class="subtitle">Cvičení 3.10</h2>

<?php
$result = "5" + 5;
echo $result;
echo "<br>";
echo "PHP převede řetězec '5' na číslo a sečte: výsledek je 10.";
?>

<h2 class="subtitle">Cvičení 3.11</h2>

<?php
var_dump(0 == "0");
echo "<br>";
var_dump(0 === "0");
?>

<h2 class="subtitle">Cvičení 3.12</h2>

<?php
var_dump((5 > 3) && (2 < 1 || 4 == 4));
?>

<h2 class="subtitle">Cvičení 3.13</h2>

<?php
$a = 6;
$b = 2;
echo "Součet je " . ($a + $b) . " a rozdíl je " . ($a - $b) . ".";
?>

<h2 class="subtitle">Cvičení 3.14</h2>

<?php
$pozdrav = "Ahoj";
$pozdrav .= " světe!";
echo $pozdrav;
?>

<h2 class="subtitle">Cvičení 3.15</h2>

<?php
$vek = 20;
if ($vek >= 18) {
    echo "Člověk je dospělý.";
} else {
    echo "Člověk je nezletilý.";
}
?>
