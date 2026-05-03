<?php declare(strict_types=1);

$lesson19Dir = $dataDir . '/lesson19';
$lesson19Dir = lessonWritableDir($lesson19Dir, 'prw_lesson19');

function cv19h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$products = [
  ['id' => 1, 'nazev' => 'Sešit', 'cena' => 35],
  ['id' => 2, 'nazev' => 'Učebnice PHP', 'cena' => 420],
  ['id' => 3, 'nazev' => 'Propiska', 'cena' => 19],
];
?>

<h2 class="subtitle">Cvičení 19.1</h2>

<?php
$person = ['jmeno' => 'Karel', 'vek' => 22];
echo "<pre>" . cv19h(json_encode($person, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) . "</pre>";
?>

<h2 class="subtitle">Cvičení 19.2</h2>

<?php
$json = '{"jmeno":"Eva","vek":20}';
$decoded = json_decode($json, true);
echo "Jméno: " . cv19h($decoded["jmeno"]) . ", věk: " . (int) $decoded["vek"];
?>

<h2 class="subtitle">Cvičení 19.3</h2>

<p><a href="/api/lesson19.php?action=names" target="_blank">Otevřít simple API se seznamem jmen</a></p>

<h2 class="subtitle">Cvičení 19.4</h2>

<p><a href="/api/lesson19.php?action=products" target="_blank">API vracející produkty z tabulky produkty</a></p>

<h2 class="subtitle">Cvičení 19.5</h2>

<form method="GET" action="/api/lesson19.php" target="_blank">
  <input type="hidden" name="action" value="product">
  <input type="number" name="id" placeholder="ID produktu" value="1">
  <button type="submit">Zobrazit detail produktu</button>
</form>

<h2 class="subtitle">Cvičení 19.6</h2>

<pre>curl -X POST http://localhost:8080/api/lesson19.php?action=echo \
  -H "Content-Type: application/json" \
  -d '{"zprava":"Ahoj API"}'</pre>

<h2 class="subtitle">Cvičení 19.7</h2>

<form method="POST">
  <textarea name="cv197_json" placeholder='{"zprava":"Ahoj"}'></textarea>
  <button type="submit">Ověřit JSON</button>
</form>
<?php if (isset($_POST["cv197_json"])): ?>
  <?php json_decode($_POST["cv197_json"], true); ?>
  <p><?= json_last_error() === JSON_ERROR_NONE ? "JSON je platný." : "Neplatný JSON: " . cv19h(json_last_error_msg()) ?></p>
<?php endif; ?>

<h2 class="subtitle">Cvičení 19.8</h2>

<?php
$externalApi = @file_get_contents('https://api.github.com/zen', false, stream_context_create([
  'http' => [
    'header' => "User-Agent: prw-zaklady-php\r\n",
    'timeout' => 2,
  ],
]));
echo $externalApi ? "Odpověď externího API: " . cv19h(trim($externalApi)) : "Externí API není právě dostupné.";
?>

<h2 class="subtitle">Cvičení 19.9</h2>

<ul>
  <?php foreach (array_filter($products, fn (array $product): bool => $product['cena'] > 100) as $product): ?>
    <li><?= cv19h($product['nazev']) ?> - <?= number_format((float) $product['cena'], 2, ',', ' ') ?> Kč</li>
  <?php endforeach; ?>
</ul>

<h2 class="subtitle">Cvičení 19.10</h2>

<?php
$productsFile = $lesson19Dir . '/products.json';
file_put_contents($productsFile, json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Soubor products.json byl vytvořen.";
?>

<h2 class="subtitle">Cvičení 19.11</h2>

<?php
$loadedProducts = json_decode((string) file_get_contents($productsFile), true);
foreach ($loadedProducts as $product) {
  echo cv19h($product['nazev']) . "<br>";
}
?>

<h2 class="subtitle">Cvičení 19.12</h2>

<p><a href="/api/lesson19.php?action=product&id=999" target="_blank">Vyzkoušet API chybu při neplatném ID</a></p>

<h2 class="subtitle">Cvičení 19.13</h2>

<form method="GET" action="/api/lesson19.php" target="_blank">
  <input type="hidden" name="action" value="products">
  <input type="number" name="minCena" placeholder="Minimální cena" value="50">
  <button type="submit">Filtrovat produkty přes URL parametr</button>
</form>

<h2 class="subtitle">Cvičení 19.14</h2>

<ul>
  <li><code>/api/lesson19.php?action=names</code> vrací seznam jmen.</li>
  <li><code>/api/lesson19.php?action=products</code> vrací seznam produktů.</li>
  <li><code>/api/lesson19.php?action=product&amp;id=1</code> vrací jeden produkt.</li>
  <li><code>/api/lesson19.php?action=books</code> vrací knihy a přijímá POST JSON.</li>
</ul>

<h2 class="subtitle">Cvičení 19.15</h2>

<p><a href="/api/lesson19.php?action=books" target="_blank">Výpis knih</a></p>
<p><a href="/api/lesson19.php?action=book&id=1" target="_blank">Detail jedné knihy</a></p>
<pre>curl -X POST http://localhost:8080/api/lesson19.php?action=books \
  -H "Content-Type: application/json" \
  -d '{"nazev":"Nová kniha","autor":"Autor"}'</pre>
