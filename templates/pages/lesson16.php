<?php declare(strict_types=1);

$lesson16Dir = dirname(__DIR__) . '/lesson16';

function cv16render(string $template, array $variables = []): string
{
  extract($variables, EXTR_SKIP);
  ob_start();
  include $template;
  return (string) ob_get_clean();
}
?>

<h2 class="subtitle">Cvičení 16.1</h2>

<?php
$title = "Header a footer";
include $lesson16Dir . '/header.php';
echo "<p>Obsah mezi vloženou hlavičkou a patičkou.</p>";
include $lesson16Dir . '/footer.php';
?>

<h2 class="subtitle">Cvičení 16.2</h2>

<?php
require $lesson16Dir . '/db.php';
echo "Require načetl soubor db.php s " . count($lesson16Products) . " produkty.";
?>

<h2 class="subtitle">Cvičení 16.3</h2>

<?php
include_once $lesson16Dir . '/menu.php';
include_once $lesson16Dir . '/menu.php';
echo "<p>Menu bylo vloženo přes include_once, druhé vložení se neprovedlo.</p>";
?>

<h2 class="subtitle">Cvičení 16.4</h2>

<pre>/templates
  header.php
  footer.php
  menu.php
/scripts
  db.php
index.php
detail.php</pre>

<h2 class="subtitle">Cvičení 16.5</h2>

<?= cv16render($lesson16Dir . '/page.view.php', [
  'title' => 'Jednoduchý templating',
  'content' => 'Stránka používá header, menu a footer.',
]) ?>

<h2 class="subtitle">Cvičení 16.6</h2>

<?php
$data = $lesson16Products;
include $lesson16Dir . '/products.view.php';
?>

<h2 class="subtitle">Cvičení 16.7</h2>

<?php include $lesson16Dir . '/menu.php'; ?>

<h2 class="subtitle">Cvičení 16.8</h2>

<?php
$images = ['obrazek-1.jpg', 'obrazek-2.png', 'obrazek-3.gif'];
include $lesson16Dir . '/gallery.view.php';
?>

<h2 class="subtitle">Cvičení 16.9</h2>

<?= cv16render($lesson16Dir . '/products.view.php', ['data' => $lesson16Products]) ?>

<h2 class="subtitle">Cvičení 16.10</h2>

<p>Funkce <code>cv16render()</code> přijme cestu k šabloně, zavolá <code>extract()</code> a vrátí vyrenderované HTML.</p>

<h2 class="subtitle">Cvičení 16.11</h2>

<?= cv16render($lesson16Dir . '/page.view.php', [
  'title' => 'Vnořená šablona',
  'content' => 'Soubor page.view.php uvnitř volá header.php, menu.php a footer.php.',
]) ?>

<h2 class="subtitle">Cvičení 16.12</h2>

<?php foreach (['Úvod', 'Produkty', 'Kontakt'] as $pageTitle): ?>
  <?= cv16render($lesson16Dir . '/page.view.php', [
    'title' => $pageTitle,
    'content' => "Toto je stránka {$pageTitle}.",
  ]) ?>
<?php endforeach; ?>

<h2 class="subtitle">Cvičení 16.13</h2>

<?php
$title = "Proměnná v HTML šabloně";
$content = "Tento text byl předán jako PHP proměnná.";
include $lesson16Dir . '/page.view.php';
?>

<h2 class="subtitle">Cvičení 16.14</h2>

<?php
$title = "Dynamický titul";
include $lesson16Dir . '/header.php';
echo "<p>Proměnná \$title se propsala do header.php.</p>";
include $lesson16Dir . '/footer.php';
?>

<h2 class="subtitle">Cvičení 16.15</h2>

<?php
echo cv16render($lesson16Dir . '/page.view.php', [
  'title' => 'Web s šablonami',
  'content' => 'Výpis produktů a detail produktu jsou samostatné view soubory.',
]);
echo cv16render($lesson16Dir . '/products.view.php', ['data' => $lesson16Products]);
echo cv16render($lesson16Dir . '/detail.view.php', ['product' => $lesson16Products[0]]);
?>
