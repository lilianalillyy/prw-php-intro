<?php declare(strict_types=1); ?>

<p>Při zpracování požadavku došlo k neočekávané chybě.</p>

<?php if (!empty($debug) && isset($message)): ?>
  <details>
    <summary><?= $esc($message) ?></summary>
    <?php if (isset($exception)): ?>
      <pre><code><?= $esc($exception->getTraceAsString()) ?></code></pre>
    <?php endif; ?>
  </details>
<?php endif; ?>

<a href="/" class="icon-link">
  <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18"></path>
  </svg>
  <span class="italic">Zpět na hlavní stránku</span>
</a>
