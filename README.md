# PHP introduction

School project for the PRW subject - a collection of exercises from the introductory PHP lessons.

[GitHub](https://github.com/lilianalillyy/prw-php-intro) · [Website](https://prw-intro.liliana.digital)

## Requirements

- PHP 8.4+
- (optional) Docker for testing with Apache + mod_rewrite (XAMPP is bloatware)

## Running

There are multiple ways you can run this project:

### PHP built-in server

```bash
php -S localhost:8080 -t public
```

### Docker

The docker setup is intentionally using Apache2 to test the `.htaccess` rewrite.

```bash
docker compose up
```

The app will be available at [localhost:8080](http://localhost:8080).

## Project structure

```text
public/            Application entry point (document root)
  index.php        Route definitions and router bootstrap
  style.css        CSS styles
  lessons/         Reference materials (PDF)
src/
  router/          Routing
  templates/       Templating engine
templates/
  layouts/         Page layouts (default, lesson)
  pages/           Individual page templates
  errors/          Error templates (404, 500)
```

## Formatting

The project uses [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) for formatting. It adheres to PSR-12 rules with two personal exceptions:

- 2-space indentation
- `declare(strict_types = 1)` is on the same line as `<?php`

You can run the formatter using the following command:

```bash
php tools/php-cs-fixer.phar fix
```
