<?php declare(strict_types=1);

class TemplateRoute extends Route
{
  public function __construct(
    string $name,
    ?string $template = null,
    ?string $layout = null,
    array|object|null $data = null,
    array $config = []
  ) {
    $config = array_merge($config, [
      'template' => $template,
      'layout' => $layout,
      'data' => $data,
    ]);
    parent::__construct($name, TEMPLATE_ROUTE_HANDLER, $config);
  }
}
