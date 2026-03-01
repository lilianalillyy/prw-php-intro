<?php declare(strict_types=1);

require_once __DIR__ . '/../src/templates/index.php';
require_once __DIR__ . '/../src/router/index.php';

const GLOBAL_DATA = [
  'globalTitle' => 'Základy PHP'
];

const DEFAULT_LAYOUT = DEFAULT_LAYOUT;

const DEFAULT_PAGE = 'home';

const AVAILABLE_PAGES = [
  'home' => [
    'template' => 'pages/home',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Seznam lekcí',
    ]
  ],
  'lesson1' => [
    'template' => 'pages/lesson1',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 1 - Úvod do PHP',
      'reference_file' => '/lessons/lesson1_intro.pdf',
    ]
  ],
  'lesson2' => [
    'template' => 'pages/lesson2',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 2 - Proměnné a datové typy',
      'reference_file' => '/lessons/lesson2_variables.pdf',
    ]
  ],
  'lesson3' => [
    'template' => 'pages/lesson3',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 3 - Operátory',
      'reference_file' => '/lessons/lesson3_operators.pdf',
    ]
  ],
  'lesson4' => [
    'template' => 'pages/lesson4',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 4 - Funkce',
      'reference_file' => '/lessons/lesson4_functions.pdf',
    ]
  ],
  'lesson5' => [
    'template' => 'pages/lesson5',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 5 - Podmínky',
      'reference_file' => '/lessons/lesson5_conditions.pdf',
    ]
  ],
  'lesson6' => [
    'template' => 'pages/lesson6',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 6 - Cykly',
      'reference_file' => '/lessons/lesson6_loops.pdf',
    ]
  ],
  'lesson7' => [
    'template' => 'pages/lesson7',
    'layout' => DEFAULT_LAYOUT,
    'data' => [
      'title' => 'Lekce 7 - Pole',
      'reference_file' => '/lessons/lesson7_arrays.pdf',
    ]
  ]
];

try {
  $templateRenderer = new TemplateRenderer(__DIR__ . '/../src/templates');
  $router = new Router(
    templateRenderer: $templateRenderer, 
    defaultPage: DEFAULT_PAGE,
    availablePages: AVAILABLE_PAGES,
    globalData: GLOBAL_DATA
  );

  $router->handleRequest();
} catch (TemplateNotFoundException $e) {
  http_response_code(404);
  echo "Page not found.";
} catch (TemplateException $e) {
  http_response_code(500);
  echo "An error occurred while rendering the page.";
}