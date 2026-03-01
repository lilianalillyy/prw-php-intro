<?php declare(strict_types=1);

$lessons = array_filter($router->getRoutes(), function ($route) {
  return str_starts_with($route->name, 'lesson');
});

$lessons = array_map(function ($routeName, $route) {
  return [
    'route' => $routeName,
    'title' => $route->config['data']['title'] ?? $route,
  ];
}, array_keys($lessons), $lessons);

?>

<ul class="lessons-list">
  <?php foreach ($lessons as $lesson): ?>
    <li>
      <a href="<?= $router->link($lesson['route']) ?>" class="text-blue-500 hover:underline">
        <?= $esc($lesson['title']) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>