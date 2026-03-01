<?php declare(strict_types=1);

function createTemplateHelpers(TemplateRenderer $renderer): array {
  return [
    /**
     * Escape a string for safe output in HTML. This prevents XSS vulnerabilities by converting special characters to their HTML entities.
     */
    "esc" => function (string $s): string {
      return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    },
    /**
     * Include another template within the current template.
     */
    "inc" => function (string $template, array|object|null $data = null) use ($renderer): void {
      try {
        echo $renderer->render($template, $data);
      } catch (TemplateNotFoundException $e) {
        trigger_error("Template not found. Expected a template at " . $e->path . ".", E_USER_WARNING);
        echo "<!-- Error including template '{$template}' -->";
      }
    }
  ];
}