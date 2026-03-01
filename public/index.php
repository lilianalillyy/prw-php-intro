<?php declare(strict_types=1);

require_once __DIR__ . '/../src/templates/index.php';
require_once __DIR__ . '/../src/router/index.php';

const GLOBAL_DATA = [
  'globalTitle' => 'Základy PHP'
];

const DEFAULT_LAYOUT = "default";
const LESSON_LAYOUT = "lesson";

$templateRenderer = new TemplateRenderer(__DIR__ . '/../src/templates');
$router = new Router(
  routes: [
    new TemplateRoute(
      name: "home",
      data: [
        'title' => 'Seznam lekcí',
      ]
    ),
    new TemplateRoute(
      name: "lesson1",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 1 - Úvod do PHP',
        'reference_file' => '/lessons/lesson1_intro.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson2",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 2 - Proměnné a datové typy',
        'reference_file' => '/lessons/lesson2_variables.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson3",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 3 - Operátory',
        'reference_file' => '/lessons/lesson3_operators.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson4",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 4 - Funkce',
        'reference_file' => '/lessons/lesson4_functions.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson5",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 5 - Podmínky',
        'reference_file' => '/lessons/lesson5_conditions.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson6",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 6 - Cykly',
        'reference_file' => '/lessons/lesson6_loops.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson7",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 7 - Pole',
        'reference_file' => '/lessons/lesson7_arrays.pdf',
      ]
    ),
  ],
  routeHandlers: [
    new TemplateRouteHandler(
      templateRenderer: $templateRenderer,
      defaultLayout: 'default',
      globalData: GLOBAL_DATA,
    )
  ],
);

$router->handleRequest();
