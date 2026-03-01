<?php declare(strict_types = 1); ?>

<h2 class="subtitle">Cvičení 4.1</h2>

<?php
function helloWorld(): void {
    echo "Ahoj světe!";
}
helloWorld();
?>

<h2 class="subtitle">Cvičení 4.2</h2>

<?php
function pozdrav(string $jmeno): void {
    echo "Ahoj, $jmeno!";
}
pozdrav("Mia");
?>

<h2 class="subtitle">Cvičení 4.3</h2>

<?php
function nasob(int $a, int $b): int {
    return $a * $b;
}
echo "Součin: " . nasob(6, 7);
?>

<h2 class="subtitle">Cvičení 4.4</h2>

<?php
function personInfo(string $name = "Neznámý"): void {
    echo "Jméno: $name";
}
personInfo();
echo "<br>";
personInfo("Mia");
?>

<h2 class="subtitle">Cvičení 4.5</h2>

<?php
function odecist(int $a, int $b): int {
    return $a - $b;
}
echo "Rozdíl: " . odecist(10, 3);
?>

<h2 class="subtitle">Cvičení 4.6</h2>

<?php
function userInfo(string $name, int $age): string {
    return "Uživatel $name má $age let.";
}
echo userInfo("Mia", 20);
?>

<h2 class="subtitle">Cvičení 4.7</h2>

<?php
function sumAndDifference(int $a, int $b): void {
    echo "Součet je " . ($a + $b) . " a rozdíl je " . ($a - $b) . ".";
}
sumAndDifference(15, 7);
?>

<h2 class="subtitle">Cvičení 4.8</h2>

<?php
function printTwice(string $text): void {
    echo $text;
    echo "<br>";
    echo $text;
}
printTwice("Toto je opakovaný text.");
?>

<h2 class="subtitle">Cvičení 4.9</h2>

<?php
function isEven(int $number): bool {
    return $number % 2 === 0;
}
var_dump(isEven(4));
echo "<br>";
var_dump(isEven(7));
?>

<h2 class="subtitle">Cvičení 4.10</h2>

<?php
function greetHtml(string $name): string {
    return "Ahoj, $name!";
}
?>

<p><?= greetHtml("Eva") ?></p>

<h2 class="subtitle">Cvičení 4.11</h2>

<?php
function hasMinLength(string $name): bool {
    return strlen($name) >= 5;
}
var_dump(hasMinLength("Mia"));
echo "<br>";
var_dump(hasMinLength("Kristýna"));
?>

<h2 class="subtitle">Cvičení 4.12</h2>

<?php
function totalPrice(int $quantity, float $pricePerUnit): float {
    return $quantity * $pricePerUnit;
}
echo "Celková cena: " . totalPrice(5, 49.90) . " Kč";
?>

<h2 class="subtitle">Cvičení 4.13</h2>

<?php
function stars(int $count): void {
    for ($i = 0; $i < $count; $i++) {
        echo "*";
    }
}
stars(10);
?>

<h2 class="subtitle">Cvičení 4.14</h2>

<?php
function isAdult(int $age): bool {
    return $age >= 18;
}
var_dump(isAdult(20));
echo "<br>";
var_dump(isAdult(15));
?>

<h2 class="subtitle">Cvičení 4.15</h2>

<?php
function salutation(?string $gender): void {
    $masculine = "Vážený pane";
    $feminine = "Vážená paní";

    if ($gender === "masculine") {
        echo $masculine;
    } else if ("feminine") {
        echo $feminine;
    } else {
        echo "$feminine/$masculine";
    }
}
salutation(null); // gender neutral (both cases) if not specified
echo "<br>";
salutation("masculine");
echo "<br>";
salutation("feminine");

?>
