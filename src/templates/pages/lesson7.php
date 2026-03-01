<?php declare(strict_types = 1); ?>

<h2 class="subtitle">Cvičení 7.1</h2>

<?php
$foods = ["pizza", "sushi", "řízek"];
echo "Oblíbené jídlo: " . $foods[0];
?>

<h2 class="subtitle">Cvičení 7.2</h2>

<?php
$cities = ["Praha", "Brno", "Ostrava"];
$cities[] = "Plzeň";
echo implode(", ", $cities);
?>

<h2 class="subtitle">Cvičení 7.3</h2>

<?php
$numbers = [10, 20, 30, 40];
array_pop($numbers);
echo implode(", ", $numbers);
?>

<h2 class="subtitle">Cvičení 7.4</h2>

<?php
$words = ["PHP", "je", "skvělé"];
echo implode(" ", $words);
?>

<h2 class="subtitle">Cvičení 7.5</h2>

<?php
$person = [
    "jmeno" => "Mia",
    "vek" => 20,
    "mesto" => "Praha",
];
echo "Jméno: " . $person["jmeno"];
?>

<h2 class="subtitle">Cvičení 7.6</h2>

<?php
$person = [
    "jmeno" => "Mia",
    "vek" => 20,
    "mesto" => "Praha",
];
echo "Město: " . $person["mesto"];
?>

<h2 class="subtitle">Cvičení 7.7</h2>

<?php
$person = [
    "jmeno" => "Mia",
    "vek" => 20,
];
$person["vek"] += 1;
echo "Nový věk: " . $person["vek"];
?>

<h2 class="subtitle">Cvičení 7.8</h2>

<?php
$class = [
    "A" => ["Petr", "David"],
    "B" => ["Lenka", "Ema"],
];
echo "Druhý student ze skupiny A: " . $class["A"][1];
?>

<h2 class="subtitle">Cvičení 7.9</h2>

<?php
$animals = ["pes", "kočka"];
if (in_array("kočka", $animals)) {
    echo "Kočka existuje v poli.";
}
?>

<h2 class="subtitle">Cvičení 7.10</h2>

<?php
$movies = ["Matrix", "Inception", "Interstellar", "Tenet"];
echo "Počet filmů: " . count($movies);
?>

<h2 class="subtitle">Cvičení 7.11</h2>

<?php
$numbers = [5, 2, 8, 1, 9, 3];
sort($numbers);
echo implode(", ", $numbers);
?>

<h2 class="subtitle">Cvičení 7.12</h2>

<?php
$animals = ["pes", "kočka", "králík", "papoušek"];
foreach ($animals as $animal) {
    echo $animal . "<br>";
}
?>

<h2 class="subtitle">Cvičení 7.13</h2>

<?php
$person = [
    "jmeno" => "Mia",
    "vek" => 20,
    "mesto" => "Praha",
];
$keys = array_keys($person);
echo implode(", ", $keys);
?>

<h2 class="subtitle">Cvičení 7.14</h2>

<?php
$person = [
    "jmeno" => "Mia",
    "vek" => 20,
    "mesto" => "Praha",
];
$values = array_values($person);
echo implode(", ", $values);
?>

<h2 class="subtitle">Cvičení 7.15</h2>

<?php
$contacts = [
    "Mia" => "123 456 789",
    "Eva" => "987 654 321",
    "Petr" => "555 111 222",
];
foreach ($contacts as $name => $phone) {
    echo "$name: $phone<br>";
}
?>
