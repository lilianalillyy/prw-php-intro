<?php declare(strict_types=1);

class TemplateException extends Exception {
    public function __construct(string $message = "", private readonly ?string $template = null, Throwable|null $previous = null)
    {
        $message = "An error has occurred while rendering " . ($template ?? "unknown template") . ": " . $message;
        parent::__construct($message, 0, $previous);
    }
}