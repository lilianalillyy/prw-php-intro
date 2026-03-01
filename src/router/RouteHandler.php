<?php declare(strict_types=1);

interface RouteHandler
{
  public string $name { get; }

  public function handle(Route $route, Router $router): void;
  public function handleError(int $statusCode, string $message, ?Throwable $exception, Router $router): bool;
}
