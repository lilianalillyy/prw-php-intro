<?php declare(strict_types=1);

class Router {
    private readonly array $routes;
    private readonly array $routeHandlers;

    public function __construct(
        array $routes = [],
        array $routeHandlers = [],
        private readonly string $routeParam = 'page',
        private readonly string $defaultRouteName = 'home',
        private readonly ?string $errorHandler = null,
    )
    {
        $this->routes = self::createIndexedArray($routes, 'name');
        $this->routeHandlers = self::createIndexedArray($routeHandlers, 'name');
    }

    function handleRequest(): void {
        $page = $this->getCurrentRouteName();

        // If the page parameter is not set, use the default route.
        if (!$page) {
            $page = $this->defaultRouteName;
        }

        $route = $this->getRoute($page);

        if (!$route) {
            $this->error(404, "Page not found.");
            return;
        }

        $handler = $this->getRouteHandler($route->handler);

        if (!$handler) {
            $this->error(500, "Unexpected handler '{$route->handler}' for route '{$route->name}'.");
            return;
        }

        try {
            $handler->handle($route, $this);
        } catch (Throwable $e) {
            $this->error(500, "An unexpected error occurred while handling the request.", $e);
        }
    }

    function link(string $route, array $queryParams = []): string {
        if (!$this->getRoute($route)) {
            throw new InvalidArgumentException("Invalid route '{$route}' provided to Router.");
        }

        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $urlParts = parse_url($currentUrl);
        $currentQueryParams = [];
        
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $currentQueryParams);
        }

        unset($currentQueryParams[$this->routeParam]);

        // Do not include the routing parameter in the URL if it's the default route.
        $pageParams = $route === $this->defaultRouteName ? [] : [$this->routeParam => $route];
        
        $query = http_build_query(array_merge($currentQueryParams, $queryParams, $pageParams));
        $url = $urlParts['path'] ?? '/';
        
        if ($query) {
            $url .= '?' . $query;
        }
        
        if (isset($urlParts['fragment'])) {
            $url .= '#' . $urlParts['fragment'];
        }
        
        return $url;
    }

    public function getRoutes(): array {
        return $this->routes;
    }

    public function getRoute(string $route): ?Route {
        return $this->routes[$route] ?? null;
    }

    public function getRouteHandler(string $handler): ?RouteHandler {
        return $this->routeHandlers[$handler] ?? null;
    }

    /**
     * Trigger an error response. Can be called by route handlers to delegate error rendering
     * back to the router's configured error handler.
     */
    public function error(int $statusCode, string $message, ?Throwable $exception = null): void {
        $this->handleError($statusCode, $message, $exception);
    }

    private function getCurrentRouteName(): ?string {
        if (!isset($_GET[$this->routeParam])) {
            return null;
        }

        return $_GET[$this->routeParam];
    }

    private static function createIndexedArray(array $array, string $key): array {
        $result = [];
        foreach ($array as $item) {
            $result[$item->$key] = $item;
        }
        return $result;
    }

    private function handleError(int $statusCode, string $message, ?Throwable $exception = null): void {
        http_response_code($statusCode);

        // Try to delegate error rendering to a route handler.
        $handlerName = $this->errorHandler ?? array_key_first($this->routeHandlers);
        $handler = $handlerName ? $this->getRouteHandler($handlerName) : null;

        if ($handler && $handler->handleError($statusCode, $message, $exception, $this)) {
            return;
        }

        echo TemplateHelpers::esc($message);
    }
}