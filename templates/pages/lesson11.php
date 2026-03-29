<?php declare(strict_types=1);

// While the assignment says to upload files to `/uploads` within the project root, I want to separate the files within
// this lesson from any files that might be uploaded in future lessons, so I will use the `data/lesson11` as a root
// (this is where you'll find the uploads folder as well as log.txt).

// Please note that in a real application, you would typically want to handle file uploads and related logic in a controller or a service layer,
// rather than directly in the template. However, for the purposes of this lesson and to keep things simple, we are doing it directly in the template.
$lessonDir = $dataDir . '/lesson11';
$uploadsDir = $lessonDir . '/uploads';

if (!is_dir($lessonDir)) {
  mkdir($lessonDir, 0755, true);
}

if (!is_dir($uploadsDir)) {
  mkdir($uploadsDir, 0755, true);
}
?>

<h2 class="subtitle">Cvičení 11.1</h2>

<?php
file_put_contents($dataDir . '/test.txt', "Ahoj, toto je testovací soubor!");
echo "Soubor vytvořen: test.txt";
?>

<h2 class="subtitle">Cvičení 11.2</h2>

<?php
$content = file_get_contents($dataDir . '/test.txt');
echo "Obsah souboru: " . htmlspecialchars($content);
?>

<h2 class="subtitle">Cvičení 11.3</h2>

<?php
file_put_contents($dataDir . '/test.txt', "\nDalší řádek přidaný pomocí FILE_APPEND", FILE_APPEND);
$content = file_get_contents($dataDir . '/test.txt');
echo "Obsah po přidání:<br>" . nl2br(htmlspecialchars($content));
?>

<h2 class="subtitle">Cvičení 11.4</h2>

<?php
$file = fopen($dataDir . '/test.txt', 'r');
if ($file) {
  $lineNum = 1;
  while (!feof($file)) {
    $line = fgets($file);
    if ($line !== false) {
      echo "Řádek $lineNum: " . htmlspecialchars($line) . "<br>";
      $lineNum++;
    }
  }
  fclose($file);
}
?>

<h2 class="subtitle">Cvičení 11.5</h2>

<?php
if (is_dir($uploadsDir)) {
  echo "Složka 'uploads' existuje.";
} else {
  mkdir($uploadsDir, 0755, true);
  echo "Složka 'uploads' vytvořena.";
}
?>

<h2 class="subtitle">Cvičení 11.6</h2>

<?php
$files = array_diff(scandir($uploadsDir), ['.', '..']);
if (empty($files)) {
  echo "Složka 'uploads' je prázdná.";
} else {
  echo "Soubory ve složce 'uploads':<br>";
  foreach ($files as $f) {
    echo "- " . htmlspecialchars($f) . "<br>";
  }
}
?>

<h2 class="subtitle">Cvičení 11.7</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="file" name="cv117_file">
  <button type="submit">Nahrát</button>
</form>

<?php
$uploadResult = null;

if ($uploadedFile = $_FILES["cv117_file"] ?? null && $uploadedFile["error"] === UPLOAD_ERR_OK) {
  $uploadName = basename($uploadedFile["name"]);

  $uploadResult = [
    'name' => $uploadedFile["name"],
    'type' => $uploadedFile["type"],
    'size' => $uploadedFile["size"],
    'path' => $_FILES["cv117_file"]["tmp_name"],
  ];
}

if ($uploadResult !== null) {
  echo "Soubor nahrán: " . htmlspecialchars($uploadResult['name']);
}
?>

<h2 class="subtitle">Cvičení 11.8</h2>

<?php
if ($uploadResult !== null) {
  $destination = $uploadsDir . '/' . $uploadResult['name'];

  // Check if file already exists and rename if necessary to avoid overwriting
  if (file_exists($destination)) {
    unlink($uploadResult['path']);
    echo "Soubor s názvem '" . htmlspecialchars($uploadResult['name']) . "' již existuje.";
  } else {
    move_uploaded_file($uploadResult['path'], $destination);
    $uploadResult['path'] = $destination;

    echo "Soubor uložen do: uploads/" . htmlspecialchars(basename($uploadResult['path']));
  }
} else {
  echo "Nahrajte soubor ve cvičení 11.7.";
}
?>

<h2 class="subtitle">Cvičení 11.9</h2>

<?php
if ($uploadResult !== null) {
  $kb = round($uploadResult['size'] / 1024, 2);
  echo "Název: " . htmlspecialchars($uploadResult['name']) . "<br>";
  echo "Typ: " . htmlspecialchars($uploadResult['type']) . "<br>";
  echo "Velikost: {$kb} KB";
} else {
  echo "Nahrajte soubor ve cvičení 11.7.";
}
?>

<h2 class="subtitle">Cvičení 11.10</h2>

<?php
if ($uploadResult !== null) {
  $allowed = ["image/jpeg", "image/png"];
  if (in_array($uploadResult['type'], $allowed)) {
    echo "Soubor je povolený obrázek (JPG/PNG).";
  } else {
    echo "Soubor NENÍ JPG/PNG (typ: " . htmlspecialchars($uploadResult['type']) . ").";
  }
} else {
  echo "Nahrajte soubor ve cvičení 11.7 pro kontrolu typu.";
}
?>

<h2 class="subtitle">Cvičení 11.11</h2>

<?php
if ($uploadResult !== null) {
  $maxSize = 2 * 1024 * 1024; // 2 MB in bytes

  if ($uploadResult['size'] > $maxSize) {
    echo "Soubor je příliš velký! (" . round($uploadResult['size'] / 1024 / 1024, 2) . " MB, max 2 MB)";
  } else {
    echo "Velikost OK (" . round($uploadResult['size'] / 1024, 2) . " KB, max 2 MB).";
  }
} else {
  echo "Nahrajte soubor ve cvičení 11.7 pro kontrolu velikosti.";
}
?>

<h2 class="subtitle">Cvičení 11.12</h2>

<?php
$uploadedFiles = array_diff(scandir($uploadsDir), ['.', '..']);
if (!empty($uploadedFiles)):
  ?>
  <form method="POST">
    <select name="cv1112_file">
      <?php foreach ($uploadedFiles as $f): ?>
        <option value="<?= htmlspecialchars($f) ?>"><?= htmlspecialchars($f) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="hidden" name="cv1112_delete" value="1">
    <button type="submit">Smazat</button>
  </form>

<?php else: ?>
  <p>Žádné soubory k smazání. Nahrajte soubor ve cvičení 11.7.</p>
<?php endif; ?>

<?php
if (isset($_POST["cv1112_delete"]) && !empty($_POST["cv1112_file"])) {
  $deleteFile = $uploadsDir . '/' . basename($_POST["cv1112_file"]);
  if (file_exists($deleteFile)) {
    unlink($deleteFile);
    echo "Soubor '" . htmlspecialchars(basename($_POST["cv1112_file"])) . "' smazán.";
  }
}
?>

<h2 class="subtitle">Cvičení 11.13</h2>

<?php
function formatLastRecords(int $count): string
{
  $abs = abs($count);

  $lastWord = $abs >= 1 && $abs <= 3
      ? 'Poslední'
      : 'Posledních';

  if ($abs === 1) {
    $recordWord = 'záznam';
  } elseif ($abs >= 2 && $abs <= 4) {
    $recordWord = 'záznamy';
  } else {
    $recordWord = 'záznamů';
  }

  return sprintf('%s %d %s', $lastWord, $count, $recordWord);
}

$logFile = $dataDir . '/log.txt';
$logEntry = date("Y-m-d H:i:s") . " - Stránka načtena\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);
$logContent = file_get_contents($logFile);
$logLines = explode("\n", trim($logContent));
$lastLines = array_slice($logLines, -10);
echo formatLastRecords(count($lastLines)) . " z log.txt:<br>";
echo nl2br(htmlspecialchars(implode("\n", $lastLines)));
?>

<h2 class="subtitle">Cvičení 11.14</h2>

<?php
$counterFile = $dataDir . '/counter.txt';
$count = 0;
if (file_exists($counterFile)) {
  $count = (int) file_get_contents($counterFile);
}
$count++;
file_put_contents($counterFile, (string) $count);
echo "Počet návštěv: $count";
?>

<h2 class="subtitle">Cvičení 11.15</h2>

<?php
$images = [];
$allFiles = array_diff(scandir($uploadsDir), ['.', '..']);
foreach ($allFiles as $f) {
  $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
  if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
    $images[] = $f;
  }
}

if (!empty($images)) {
  echo "Galerie obrázků:<br>";
  foreach ($images as $img) {
    echo "- " . htmlspecialchars($img) . "<br>";
  }
} else {
  echo "Žádné obrázky v galerii. Nahrajte obrázky (JPG/PNG/GIF) ve cvičení 11.7.";
}
?>
