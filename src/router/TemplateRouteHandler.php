<?php declare(strict_types=1);

const TEMPLATE_ROUTE_HANDLER = 'template';

class TemplateRouteHandler implements RouteHandler {
    public readonly string $name;

    public function __construct(
        private readonly TemplateRenderer $templateRenderer,
        private readonly bool $handleErrors = true,
        private readonly ?string $defaultLayout = null,
        private readonly ?string $errorLayout = null,
        private readonly ?string $defaultPageNamespace = "pages",
        private readonly ?string $defaultLayoutNamespace = "layouts",
        private readonly ?string $defaultErrorNamespace = "errors",
        private readonly array|object|null $globalData = [],
    ) {
        $this->name = TEMPLATE_ROUTE_HANDLER;
    }

    function handle(Route $route, Router $router): void {
        $template = $this->getNamespacedTemplate(
            $route->config['template'] ?? $route->name,
            $this->defaultPageNamespace
        );

        $layout = $this->getNamespacedTemplate(
            $route->config['layout'] ?? $this->defaultLayout,
            $this->defaultLayoutNamespace
        );

        $data = $this->buildTemplateData($route->config['data'] ?? null, [
            'route' => $route,
            'router' => $router,
        ]);

        if (!$template) {
            $router->error(500, "Template not specified for route '{$route->name}'.");
            return;
        }

        try {
            $this->templateRenderer->view(
                template: $template,
                data: $data,
                layout: $layout
            );
        } catch (TemplateException $e) {
            $router->error(500, "An error occurred while handling route '{$route->name}': " . $e->getMessage());
        }
    }

    function handleError(int $statusCode, string $message, ?Throwable $exception, Router $router): bool {
        if (!$this->handleErrors) {
            return false;
        }

        $templatePath = $this->resolveErrorTemplatePath($statusCode);
        $layoutPath = $this->templateRenderer->getValidTemplatePath(
            $this->getNamespacedTemplate(
                $this->errorLayout ?? $this->defaultLayout,
                $this->defaultLayoutNamespace,
            ),
            false
        );

        $data = $this->buildTemplateData([
            'isError' => true,
            'statusCode' => $statusCode,
            'message' => $message,
            'exception' => $exception,
            'router' => $router,
        ]);

        $renderedError = null;

        if ($templatePath) {
            $renderedError = $this->templateRenderer->renderTemplateContent($templatePath, array_merge($data, [
                'templatePath' => $templatePath,
            ]));
        } else {
            $renderedError = "An internal error occurred while processing your request.";
        }

        // If no valid layout is found, render the error content without a layout.
        if (!$layoutPath) {
            echo $renderedError;
            return true;
        }

        try {
            echo $this->templateRenderer->renderIntoLayout(
                content: $renderedError,
                data: $data,
                layoutPath: $layoutPath,
            );
        } catch (Throwable) {
            echo $renderedError;
        }

        return true;
    }

    /**
     * Try to find an error template for the given status code, or fall back to a generic page.
     */
    private function resolveErrorTemplatePath(int $statusCode): ?string {
        $strStatusCode = (string) $statusCode;

        if (strlen($strStatusCode) !== 3 || !ctype_digit($strStatusCode)) {
            // Invalid status code format — don't even try to find a template.
            return null;
        }

        $firstDigit = $strStatusCode[0];

        $candidates = [
            $this->getNamespacedTemplate((string) $statusCode, $this->defaultErrorNamespace),
            // Inspired by PHP framework Nette, which looks for templates like "4xx" or "5xx" if a specific status code template is not found.
            $this->getNamespacedTemplate("{$firstDigit}xx", $this->defaultErrorNamespace),
            $this->getNamespacedTemplate('error', $this->defaultErrorNamespace),
        ];

        foreach ($candidates as $candidate) {
            if ($candidateTemplatePath = $this->templateRenderer->getValidTemplatePath($candidate)) {
                return $candidateTemplatePath;
            }
        }

        return null;
    }

    private function buildTemplateData(array|object|null $routeData, array $extra = []): array {
        return array_merge(
            $this->templateRenderer->normalizeData($this->globalData),
            $this->templateRenderer->normalizeData($routeData),
            $extra,
        );
    }

    function getNamespacedTemplate(?string $template, ?string $namespace = null): ?string {
        if ($template === null) {
            return null;
        }

        // Using '@' prefix to indicate that the template path is complete and should not be prefixed with the default namespace.
        if (str_starts_with($template, '@')) {
            return ltrim($template, '@');
        }

        if ($namespace) {
            return "{$namespace}/{$template}";
        }

        return $template;
    }
}
