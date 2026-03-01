<?php declare(strict_types=1);

class Router {
    private readonly array $routes;
    private readonly array $routeHandlers;

    public function __construct(
        array $routes = [],
        array $routeHandlers = [],
        private readonly string $routeParam = 'page',
        private readonly string $defaultRouteName = 'home',
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
            http_response_code(404);
            // TODO: Better handling of 404
            echo "Page '{$page}' not found.";
            return;
        }

        $handler = $this->getRouteHandler($route->handler);

        if (!$handler) {
            http_response_code(500);
            echo "Cannot handle route '{$route->name}'.";
            return;
        }

        $handler->handle($route, $this);
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
}