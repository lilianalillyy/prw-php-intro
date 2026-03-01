<?php declare(strict_types=1);

class TemplateHelpers
{
  public static function esc(mixed $value): mixed
  {
    if (!is_string($value)) {
      return $value;
    }

    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }

  public static function inc(TemplateRenderer $renderer, string $template, array|object|null $data = null): void
  {
    try {
      echo $renderer->render($template, $data);
    } catch (TemplateNotFoundException $e) {
      trigger_error("Template not found. Expected a template at " . $e->path . ".", E_USER_WARNING);
      echo "<!-- Error including template '{$template}' -->";
    }
  }
}

function createTemplateHelpers(TemplateRenderer $renderer): array
{
  return [
    /**
     * Escape a string for safe output in HTML. This prevents XSS vulnerabilities by converting special characters to their HTML entities.
     */
    "esc" => function ($value) {
      return TemplateHelpers::esc($value);
    },
    /**
     * Include another template within the current template.
     */
    "inc" => function (string $template, array|object|null $data = null) use ($renderer): void {
      TemplateHelpers::inc($renderer, $template, $data);
    },
  ];
}
