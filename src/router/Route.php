<?php declare(strict_types=1);

class Route {
    public function __construct(
        public readonly string $name,
        public readonly string $handler,
        public readonly array $config = [],
    )
    {
    }
}