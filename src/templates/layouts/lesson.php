<?php declare(strict_types=1);

if (isset($referenceFile)) {
  $referenceFilePath = $referenceFile;
  $referenceFileExt = pathinfo($referenceFilePath, PATHINFO_EXTENSION);
  $referenceFileName = $title . "." . $referenceFileExt;

  $referenceFile = [
    'href' => $referenceFilePath,
    'downloadName' => $referenceFileName,
    'extension' => $referenceFileExt,
  ];
}

$lessonCode = null;
if (isset($pageCtx['templatePath'])) {
  $templatePath = $pageCtx['templatePath'];
  try {
    $lessonCode = file_get_contents($templatePath);

    if (!$lessonCode || strlen(trim($lessonCode)) <= 0) {
      $lessonCode = null; // No content
    }
  } catch (Throwable $e) {
    // Throw warning
    trigger_error("Could not read lesson template file at '$templatePath': " . $e->getMessage(), E_USER_WARNING);
  }
}
?>
<!doctype html>
<html lang="cs">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ? $esc($title) . " | " : "" ?><?= $esc($globalTitle ?? '') ?></title>
  <link rel="stylesheet" href="/style.css">
</head>

<body class="page-container">
  <main class="content container">
    <a href="<?= $router->link('home') ?>" class="icon-link">
      <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"></path>
      </svg>
      <i>Zpět na seznam lekcí</i>
    </a>
    <h1 class="title"><?= $esc($title ?? '') ?></h1>

    <?php if (isset($referenceFile)): ?>
      <div>
        <a
          href="<?= $esc($referenceFile['href']) ?>"
          target="_blank"
          download="<?= $esc($referenceFile['downloadName']) ?>"
          class="icon-link">
          <svg
            data-slot="icon"
            fill="none"
            stroke-width="1.5"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"></path>
          </svg>
          Studijní materiál (.<?= $esc($referenceFile['extension']) ?>)
        </a>
      </div>

      <hr />

      <?= $pageCtx['content'] ?>

      <?php if (isset($lessonCode)): ?>
        <hr />

        <h2 class="subtitle">Zdrojový kód lekce</h2>

        <div id="lesson-code">
          <div class="icon-link">
            <div class="spinner"></div>
            <p>Načítám...</p>
          </div>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </main>

  <footer>
    <small>&copy; <?= date('Y') ?> Mia Runštuková</small>
  </footer>

  <?php if (isset($lessonCode)): ?>
    <script type="module">
      import {
        codeToHtml
      } from 'https://esm.sh/shiki@3.0.0'

      const lessonCodeElement = document.getElementById('lesson-code')
      lessonCodeElement.innerHTML = await codeToHtml(<?= json_encode($lessonCode) ?>, {
        lang: 'php',
        theme: 'solarized-light'
      })
    </script>
  <?php endif; ?>
</body>

</html>