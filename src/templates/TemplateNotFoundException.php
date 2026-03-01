<?php declare(strict_types=1);

class TemplateNotFoundException extends TemplateException {
    public function __construct(string $template, public readonly ?string $path = null, ?Throwable $previous = null) {
        $message = "Template not found." . ($path ? " Expected a template at " . $path : "") . ".";
        parent::__construct($message, $template, $previous);
    }
}