<?php declare(strict_types=1);

const TEMPLATE_ROUTE_HANDLER = 'template';

class TemplateRouteHandler implements RouteHandler {
    public readonly string $name;

    public function __construct(
        private readonly TemplateRenderer $templateRenderer,
        private readonly ?string $defaultLayout = null,
        private readonly ?string $defaultPageNamespace = "pages",
        private readonly ?string $defaultLayoutNamespace = "layouts",
        private readonly array|object|null $globalData = [],
    )
    {
        $this->name = TEMPLATE_ROUTE_HANDLER;
    }


    function handle(Route $route, Router $router): void {
        $template = $this->resolveTemplatePath(
            $route->config['template'] ?? $route->name, 
            $this->defaultPageNamespace
        );
        $layout = $this->resolveTemplatePath(
            $route->config['layout'] ?? $this->defaultLayout, 
            $this->defaultLayoutNamespace
        );
        
        $data = array_merge(
            $this->templateRenderer->normalizeData($this->globalData), 
            $this->templateRenderer->normalizeData($route->config['data'] ?? null), 
            [
                'route' => $route,
                'router' => $router,
            ]
        );

        if (!$template) {
            http_response_code(500);
            echo "Template not specified for route '{$route->name}'.";
            return;
        }

        try {
            $this->templateRenderer->view(
                template: $template, 
                data: $data, 
                layout: $layout
            );
        } catch (TemplateException $e) {
            http_response_code(500);
            echo "An error occurred while handling route '{$route->name}': " . $e->getMessage();
        }
    }

    function resolveTemplatePath(string $template, ?string $namespace = null): string {
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