<?php declare(strict_types=1);

function lessonDbConfig(): array
{
  return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('DB_PORT') ?: 3306),
    'database' => getenv('DB_DATABASE') ?: 'prw_zaklady',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
  ];
}

function lessonDbUnavailableHtml(?string $error = null): string
{
  $message = "Databáze není dostupná. Spusťte projekt přes Docker nebo nastavte MySQL připojení.";

  if ($error !== null && $error !== '') {
    $message .= "<br><small>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</small>";
  }

  return $message;
}

function lessonDbPdo(?string &$error = null): ?PDO
{
  if (!extension_loaded('pdo_mysql')) {
    $error = "Rozšíření pdo_mysql není načtené.";
    return null;
  }

  $config = lessonDbConfig();
  $dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $config['host'],
    $config['port'],
    $config['database'],
    $config['charset']
  );

  try {
    return new PDO($dsn, $config['username'], $config['password'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  } catch (PDOException $e) {
    $error = $e->getMessage();
    return null;
  }
}

function lessonDbMysqli(?string &$error = null): ?mysqli
{
  if (!extension_loaded('mysqli')) {
    $error = "Rozšíření mysqli není načtené.";
    return null;
  }

  $config = lessonDbConfig();

  mysqli_report(MYSQLI_REPORT_OFF);
  $connection = mysqli_connect(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
  );

  if (!$connection) {
    $error = mysqli_connect_error();
    return null;
  }

  if (!mysqli_set_charset($connection, $config['charset'])) {
    $error = mysqli_error($connection);
    mysqli_close($connection);
    return null;
  }

  return $connection;
}

function lessonSeedTable(PDO $pdo, string $table, string $insertSql, array $rows): void
{
  $count = (int) $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();

  if ($count > 0) {
    return;
  }

  $statement = $pdo->prepare($insertSql);
  foreach ($rows as $row) {
    $statement->execute($row);
  }
}

function lessonWritableDir(string $preferredDir, string $fallbackName): string
{
  if (!is_dir($preferredDir)) {
    @mkdir($preferredDir, 0755, true);
  }

  if (is_dir($preferredDir) && is_writable($preferredDir)) {
    return $preferredDir;
  }

  $fallbackDir = sys_get_temp_dir() . '/' . trim($fallbackName, '/');
  if (!is_dir($fallbackDir)) {
    mkdir($fallbackDir, 0755, true);
  }

  return $fallbackDir;
}
