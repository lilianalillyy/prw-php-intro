<?php declare(strict_types=1);

require_once __DIR__ . '/../../src/index.php';

header('Content-Type: application/json; charset=utf-8');

function apiResponse(array $data, int $status = 200): never
{
  http_response_code($status);
  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  exit;
}

function apiInputJson(): ?array
{
  $raw = file_get_contents('php://input');
  if ($raw === false || trim($raw) === '') {
    return [];
  }

  $data = json_decode($raw, true);
  return json_last_error() === JSON_ERROR_NONE && is_array($data) ? $data : null;
}

function apiSampleProducts(): array
{
  return [
    ['id' => 1, 'nazev' => 'Sešit', 'cena' => 35],
    ['id' => 2, 'nazev' => 'Učebnice PHP', 'cena' => 420],
    ['id' => 3, 'nazev' => 'Propiska', 'cena' => 19],
  ];
}

function apiProducts(): array
{
  $pdo = lessonDbPdo();
  if (!$pdo) {
    return apiSampleProducts();
  }

  $pdo->exec("CREATE TABLE IF NOT EXISTS produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazev VARCHAR(100) NOT NULL,
    cena DECIMAL(10,2) NOT NULL
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci");
  lessonSeedTable($pdo, 'produkty', "INSERT INTO produkty (nazev, cena) VALUES (?, ?)", [
    ['Sešit', 35],
    ['Učebnice PHP', 420],
    ['Propiska', 19],
  ]);

  return $pdo->query("SELECT id, nazev, cena FROM produkty ORDER BY id")->fetchAll();
}

function apiBooksPath(): string
{
  $dir = lessonWritableDir(__DIR__ . '/../../data/lesson19', 'prw_lesson19');

  $path = $dir . '/books.json';
  if (!is_file($path)) {
    file_put_contents($path, json_encode([
      ['id' => 1, 'nazev' => 'R.U.R.', 'autor' => 'Karel Čapek'],
      ['id' => 2, 'nazev' => 'Babička', 'autor' => 'Božena Němcová'],
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
  }

  return $path;
}

function apiBooks(): array
{
  $content = file_get_contents(apiBooksPath());
  $books = json_decode($content ?: '[]', true);
  return is_array($books) ? $books : [];
}

function apiSaveBooks(array $books): void
{
  file_put_contents(apiBooksPath(), json_encode($books, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

$action = $_GET['action'] ?? 'names';

if ($action === 'names') {
  apiResponse(['names' => ['Eva', 'Karel', 'Jana']]);
}

if ($action === 'products') {
  $products = apiProducts();
  if (isset($_GET['minCena']) && is_numeric($_GET['minCena'])) {
    $minPrice = (float) $_GET['minCena'];
    $products = array_values(array_filter($products, fn (array $product): bool => (float) $product['cena'] >= $minPrice));
  }
  apiResponse(['products' => $products]);
}

if ($action === 'product') {
  $id = (int) ($_GET['id'] ?? 0);
  foreach (apiProducts() as $product) {
    if ((int) $product['id'] === $id) {
      apiResponse(['product' => $product]);
    }
  }
  apiResponse(['error' => 'Produkt nebyl nalezen.'], 404);
}

if ($action === 'echo') {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    apiResponse(['error' => 'Použijte metodu POST.'], 405);
  }

  $input = apiInputJson();
  if ($input === null) {
    apiResponse(['error' => 'Neplatný JSON.'], 400);
  }

  apiResponse(['received' => $input]);
}

if ($action === 'books') {
  $books = apiBooks();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = apiInputJson();
    if ($input === null) {
      apiResponse(['error' => 'Neplatný JSON.'], 400);
    }

    $title = trim((string) ($input['nazev'] ?? ''));
    $author = trim((string) ($input['autor'] ?? ''));
    if ($title === '' || $author === '') {
      apiResponse(['error' => 'Vyplňte nazev a autor.'], 422);
    }

    $ids = array_map(fn (array $book): int => (int) $book['id'], $books);
    $book = [
      'id' => empty($ids) ? 1 : max($ids) + 1,
      'nazev' => $title,
      'autor' => $author,
    ];
    $books[] = $book;
    apiSaveBooks($books);
    apiResponse(['book' => $book], 201);
  }

  apiResponse(['books' => $books]);
}

if ($action === 'book') {
  $id = (int) ($_GET['id'] ?? 0);
  foreach (apiBooks() as $book) {
    if ((int) $book['id'] === $id) {
      apiResponse(['book' => $book]);
    }
  }
  apiResponse(['error' => 'Kniha nebyla nalezena.'], 404);
}

apiResponse(['error' => 'Neznámá akce.'], 404);
