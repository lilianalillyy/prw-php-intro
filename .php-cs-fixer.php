<?php

$finder = (new PhpCsFixer\Finder())
  ->in([
    __DIR__ . '/src',
    __DIR__ . '/public',
  ])
  ->name('*.php');

return (new PhpCsFixer\Config())
  ->setRules([
    '@PSR12' => true,
    'indentation_type' => true,
    'array_indentation' => true,
    'blank_line_after_opening_tag' => false,
    'declare_strict_types' => false,
  ])
  ->setIndent('  ')
  ->setLineEnding("\n")
  ->setFinder($finder);
