<?php declare(strict_types=1);

// I've been writing PHP since 2016. Normally I would make a minimal setup with a framework that has a templating engine,
// but that would be overkill here and we're not using Composer yet anyways. So here you go, the result of my procrastination
// ... a simple template renderer.
class TemplateRenderer
{
  public function __construct(private readonly string $viewsDir)
  {
  }

  /**
   * Render a template with the given data and an optional layout, and output it directly.
   *
   * @throws TemplateNotFoundException If the specified template or layout file does not exist.
   * @throws TemplateException If an error occurs during rendering.
   */
  public function view(
    string $template,
    array|object|null $data = null,
    ?string $layout = null,
  ): void {
    echo $this->render($template, $data, $layout);
  }

  /**
   * Render a template with the given data and an optional layout into a string.
   *
   * @throws TemplateNotFoundException If the specified template or layout file does not exist.
   * @throws TemplateException If an error occurs during rendering.
   */
  public function render(
    string $template,
    array|object|null $data = null,
    ?string $layout = null,
  ): string {
    $template = $this->getValidTemplatePath($template, true);
    $layout = $layout ? $this->getValidTemplatePath($layout) : null;
    $data = $this->normalizeData($data);

    $renderedTemplate = $this->renderTemplateContent($template, $data);

    if ($layout === null) {
      return $renderedTemplate;
    }

    $pageCtx = [
      'templatePath' => $template,
    ];

    return $this->renderIntoLayout($renderedTemplate, $layout, $data, $pageCtx);
  }

  /**
   * Render raw HTML content within a layout. Useful for rendering inline content.
   *
   * @throws TemplateNotFoundException If the layout file does not exist.
   * @throws TemplateException If an error occurs during rendering.
   */
  public function renderIntoLayout(
    string $content,
    string $layoutPath,
    array $data = [],
    array $pageCtx = [],
  ): string {
    $layoutData = array_merge($data, [
      'pageCtx' => array_merge([
        'content' => $content,
        'layoutPath' => $layoutPath,
      ], $pageCtx),
    ]);

    return $this->renderTemplateContent($layoutPath, $layoutData);
  }

  public function isValidTemplatePath(string $templatePath): bool
  {
    return is_file($templatePath);
  }

  public function getValidTemplatePath(string $template, bool $throw = false): ?string
  {
    $templatePath = $this->createTemplatePath($template);

    if (!$this->isValidTemplatePath($templatePath)) {
      if ($throw) {
        throw new TemplateNotFoundException($template, $templatePath);
      }

      return null;
    }

    return $templatePath;
  }

  /**
   * Get the full file path for a given template name.
   */
  protected function createTemplatePath(string $template): string
  {
    $template = str_replace('/', DIRECTORY_SEPARATOR, $template);
    return $this->viewsDir . DIRECTORY_SEPARATOR . $template . '.php';
  }

  /**
   * Normalize the data to an associative array.
   * - If the data is an object, its public properties will be extracted as key-value pairs in the resulting array.
   * - If the data is null, an empty array will be returned.
   */
  public function normalizeData(array|object|null $data): array
  {
    if ($data === null) {
      return [];
    }

    if (is_object($data)) {
      return get_object_vars($data);
    }

    return $data;
  }

  /**
   * Render a template file with the given data.
   */
  public function renderTemplateContent(string $templatePath, array $data): string
  {
    ob_start();

    // This isolation prevents template variables from leaking outside the template.
    (function () use ($templatePath, $data) {
      extract($data, EXTR_SKIP);
      extract(createTemplateHelpers($this), EXTR_SKIP);

      require $templatePath;
    })();

    return ob_get_clean();
  }
}
