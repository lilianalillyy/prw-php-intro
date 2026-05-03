<?php declare(strict_types=1);

require_once __DIR__ . '/../src/index.php';

const DATA_DIR = __DIR__ . '/../data';

const GLOBAL_DATA = [
  'globalTitle' => 'Základy PHP',
  'debug' => true,
  'dataDir' => DATA_DIR,
];

const DEFAULT_LAYOUT = "default";
const LESSON_LAYOUT = "lesson";

if (!is_dir(DATA_DIR)) {
  mkdir(DATA_DIR, 0755, true);
}

$templateRenderer = new TemplateRenderer(__DIR__ . '/../templates');
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
        'referenceFile' => '/lessons/lesson1_intro.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson2",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 2 - Proměnné a datové typy',
        'referenceFile' => '/lessons/lesson2_variables.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson3",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 3 - Operátory',
        'referenceFile' => '/lessons/lesson3_operators.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson4",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 4 - Funkce',
        'referenceFile' => '/lessons/lesson4_functions.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson5",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 5 - Podmínky',
        'referenceFile' => '/lessons/lesson5_conditions.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson6",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 6 - Cykly',
        'referenceFile' => '/lessons/lesson6_loops.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson7",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 7 - Pole',
        'referenceFile' => '/lessons/lesson7_arrays.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson8",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 8 - Formuláře',
        'referenceFile' => '/lessons/lesson8_forms.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson9",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 9 - Superglobální proměnné',
        'referenceFile' => '/lessons/lesson9_superglobals.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson10",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 10 - Session a Cookies',
        'referenceFile' => '/lessons/lesson10_sessions_and_cookies.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson11",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 11 - Práce se soubory',
        'referenceFile' => '/lessons/lesson11_files.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson12",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 12 - Práce s databází (MySQL)',
        'referenceFile' => '/lessons/lesson12_databases_mysql.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson13",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 13 - PDO a prepared statements',
        'referenceFile' => '/lessons/lesson13_pdo_prepared_statements.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson14",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 14 - CRUD aplikace',
        'referenceFile' => '/lessons/lesson14_crud_application.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson15",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 15 - Validace formulářů',
        'referenceFile' => '/lessons/lesson15_form_validation.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson16",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 16 - Include, Require a Templating',
        'referenceFile' => '/lessons/lesson16_include_require_templating.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson17",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 17 - Základy OOP v PHP',
        'referenceFile' => '/lessons/lesson17_oop.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson18",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 18 - Bezpečnost v PHP',
        'referenceFile' => '/lessons/lesson18_security.pdf',
      ]
    ),
    new TemplateRoute(
      name: "lesson19",
      layout: LESSON_LAYOUT,
      data: [
        'title' => 'Lekce 19 - JSON, API a práce s daty',
        'referenceFile' => '/lessons/lesson19_json_api.pdf',
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
