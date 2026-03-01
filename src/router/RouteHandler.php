<?php declare(strict_types=1);

interface RouteHandler {
    public string $name { get; }

    function handle(Route $route, Router $router): void;
}