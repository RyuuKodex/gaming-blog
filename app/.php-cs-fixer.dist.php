<?php

declare(strict_types=1);

$finder = new PhpCsFixer\Finder();
$finder
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor');

$config = new PhpCsFixer\Config();
$config
    ->setRules([
        '@PhpCsFixer' => true,
        'declare_strict_types' => true,
        'ordered_class_elements' => false,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
    ])
    ->setFinder($finder);

return $config;
