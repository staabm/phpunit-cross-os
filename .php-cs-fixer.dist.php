<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'lib',
    ])
;

return (new PhpCsFixer\Config())
    ->setUsingCache(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'fopen_flags' => false,
        'ordered_imports' => true,
        'protected_to_private' => false,
        'list_syntax' => ['syntax' => 'long'], // 'short' requires php 7.1+
        'visibility_required' => ['elements' => ['property', 'method']], // don't require visibility on constants
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
