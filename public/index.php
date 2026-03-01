<?php declare(strict_types=1);

require_once __DIR__ . '/../src/templates/index.php';

const GLOBAL_DATA = [
  'globalTitle' => 'Základy PHP'
];

const DEFAULT_LAYOUT = 'layouts/default';

const DEFAULT_PAGE = 'home';

const AVAILABLE_PAGES = [
  'home' => [
    'template' => 'pages/home',
    'data' => [
      'title' => 'Seznam lekcí',
    ]
  ],
  'lesson1' => [
    'template' => 'pages/lesson1',
    'data' => [
      'title' => 'Lekce 1 - Úvod do PHP',
      'reference_file' => '/lessons/lesson1_intro.pdf',
    ]
  ],
  'lesson2' => [
    'template' => 'pages/lesson2',
    'data' => [
      'title' => 'Lekce 2 - Proměnné a datové typy',
      'reference_file' => '/lessons/lesson2_variables.pdf',
    ]
  ],
  'lesson3' => [
    'template' => 'pages/lesson3',
    'data' => [
      'title' => 'Lekce 3 - Operátory',
      'reference_file' => '/lessons/lesson3_operators.pdf',
    ]
  ],
  'lesson4' => [
    'template' => 'pages/lesson4',
    'data' => [
      'title' => 'Lekce 4 - Funkce',
      'reference_file' => '/lessons/lesson4_functions.pdf',
    ]
  ],
  'lesson5' => [
    'template' => 'pages/lesson5',
    'data' => [
      'title' => 'Lekce 5 - Podmínky',
      'reference_file' => '/lessons/lesson5_conditions.pdf',
    ]
  ],
  'lesson6' => [
    'template' => 'pages/lesson6',
    'data' => [
      'title' => 'Lekce 6 - Cykly',
      'reference_file' => '/lessons/lesson6_loops.pdf',
    ]
  ],
  'lesson7' => [
    'template' => 'pages/lesson7',
    'data' => [
      'title' => 'Lekce 7 - Pole',
      'reference_file' => '/lessons/lesson7_arrays.pdf',
    ]
  ]
];

function getPageContext(string $page): array {
  return [$page, AVAILABLE_PAGES[$page]];
}

function getPageFromQuery(string $defaultPage): array {
  if (!isset($_GET['page']) || !$ctx = getPageContext($_GET['page'])) {
    return getPageContext($defaultPage);
  }

  return $ctx;
}

try {
  $templateRenderer = new TemplateRenderer(__DIR__ . '/../src/templates');

  [$page, $ctx] = getPageFromQuery(DEFAULT_PAGE); 
  $templateRenderer->view(
    template: $ctx['template'],
    data: array_merge(GLOBAL_DATA, $ctx['data'] ?? []),
    layout: $ctx['layout'] ?? DEFAULT_LAYOUT
  );
} catch (TemplateNotFoundException $e) {
  http_response_code(404);
  echo "Page not found.";
} catch (TemplateException $e) {
  http_response_code(500);
  echo "An error occurred while rendering the page.";
}