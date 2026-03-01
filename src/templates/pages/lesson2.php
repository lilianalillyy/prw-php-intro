<?php declare(strict_types = 1); ?>

<h2 class="subtitle">Cvičení 2.1</h2>

<?php
$name = "Mia";
echo $name;
?>

<h2 class="subtitle">Cvičení 2.2</h2>

<?php
$price = 299;
echo "Cena produktu je $price Kč.";
?>

<h2 class="subtitle">Cvičení 2.3</h2>

<?php
$firstName = "Mia";
$lastName = "Runštuková";
echo "Jmenuji se $firstName $lastName.";
?>

<h2 class="subtitle">Cvičení 2.4</h2>

<?php
$number = 42;
// though for getting type of variable, gettype() should be used.
// var_dump() is informative and for debugging purposes, it shows both type and value of variable
var_dump($number);
?>

<h2 class="subtitle">Cvičení 2.5</h2>

<?php
$active = true;
echo "Boolean hodnota: $active";
var_dump($active);
?>

<h2 class="subtitle">Cvičení 2.6</h2>

<?php
$vek = 18;
$vek = 25;
$vek = 30;
echo "Věk: $vek";
?>

<h2 class="subtitle">Cvičení 2.7</h2>

<?php
$greetingName = "Mia";
$greeting = "Ahoj, " . $greetingName;
echo $greeting;
?>

<h2 class="subtitle">Cvičení 2.8</h2>

<?php
$word = "programování";
echo "Délka slova '$word' je: " . strlen($word);
?>

<h2 class="subtitle">Cvičení 2.9</h2>

<?php
$a = 10;
$b = 15;
$c = $a + $b;
echo "Součet $a a $b je: $c";
?>

<h2 class="subtitle">Cvičení 2.10</h2>

<?php
$x = 5;
var_dump($x);
$x = "pět";
var_dump($x);
?>

<h2 class="subtitle">Cvičení 2.11</h2>

<?php
$empty = null;
echo "Hodnota prázdné proměnné: $empty";
var_dump($empty);
?>

<h2 class="subtitle">Cvičení 2.12</h2>

<?php
$cislo = 123;
echo "Výsledek je: " . $cislo;
?>

<h2 class="subtitle">Cvičení 2.13</h2>

<?php
$jmeno = "Mia";
echo "Ahoj $jmeno";
echo '<br>';
echo 'Ahoj $jmeno';
?>

<h2 class="subtitle">Cvičení 2.14</h2>

<?php
$text = "ahoj světe";
echo strtoupper($text);
?>

<h2 class="subtitle">Cvičení 2.15</h2>

<?php
$jmeno = "Mia";
$vek = 19;
$mesto = "Praha";
echo "Jmenuji se $jmeno, je mi $vek let a pocházím z města $mesto.";
?>
