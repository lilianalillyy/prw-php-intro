<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ? $esc($title) . " | " : "" ?> <?= $esc($globalTitle ?? '') ?></title>
  <link rel="stylesheet" href="/style.css">
</head>
<body class="page-container">
  <main class="content container">
    <h1 class="title"><?= $esc($title ?? '') ?></h1>
    
    <hr/>

    <?= $pageCtx['content'] ?>
  </main>

  <footer>
    <small>&copy; <?= date('Y') ?> Mia Runštuková</small>
  </footer>
</body>
</html>