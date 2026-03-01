<?php declare(strict_types=1);

class Router {
    public function __construct(
        private readonly TemplateRenderer $templateRenderer,
        private readonly string $pageParam = 'page',
        private readonly string $defaultPage = 'home',
        private readonly array $availablePages = [],
        private readonly array $globalData = [],
    )
    {
    }

    function handleRequest(): void {
        $page = $this->getCurrentPageFromQuery();

        if (!$this->isValidPage($page)) {
            http_response_code(404);
            echo "Page not found.";
            return;
        }

        $pageConfig = $this->getPageConfig($page);
        $this->templateRenderer->view(
            template: $pageConfig['template'],
            data: $this->prepareData($pageConfig['data'] ?? []),
            layout: $pageConfig['layout'] ?? null
        );
    }

    function prepareData(?array $data): array {
        return array_merge($this->globalData, $data ?? [], ['router' => $this]);
    }

    function link(string $page, array $queryParams = []): string {
        if (!$this->isValidPage($page)) {
            throw new InvalidArgumentException("Invalid page '{$page}' provided to Router.");
        }

        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $urlParts = parse_url($currentUrl);
        $currentQueryParams = [];
        
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $currentQueryParams);
        }

        // Do not include the page parameter in the URL if it's the default page.
        $pageParams = $page === $this->defaultPage ? [] : [$this->pageParam => $page];
        
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

    function isValidPage(string $page): bool {
        return isset($this->availablePages[$page]);
    }

    function getPageConfig(string $page): array {
       return AVAILABLE_PAGES[$page];
    }

    function getCurrentPageFromQuery(): string {
        if (!isset($_GET[$this->pageParam]) || !$this->isValidPage($_GET[$this->pageParam])) {
            return $this->defaultPage;
        }

        return $_GET[$this->pageParam];
    }
}