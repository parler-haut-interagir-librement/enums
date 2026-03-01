<?php

// @see https://github.com/symfony/symfony/blob/7.3/.php-cs-fixer.dist.php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

// https://cs.symfony.com/doc/config.html#the-simplest-config
$finder = Finder::create()
    ->in(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
            __DIR__ . '/migrations',
            __DIR__ . '/bundles',
        ]
    )
;

return (new PhpCsFixer\Config())
    ->setRules([
                   '@PhpCsFixer'                                 => true,
                   '@PHP83Migration'                             => true,
                   // taken from the Symfony config
                   // https://github.com/symfony/symfony/blob/7.2/.php-cs-fixer.dist.php
                   '@Symfony'                                    => true,
                   // https://cs.symfony.com/doc/ruleSets/Symfony.html
                   '@Symfony:risky'                              => true,
                   'array_indentation'                           => true,
                   'array_syntax'                                => ['syntax' => 'short'],
                   'cast_spaces'                                 => ['space' => 'single'],
                   'combine_consecutive_unsets'                  => true,
                   'concat_space'                                => ['spacing' => 'one'],
                   'declare_strict_types'                        => true,
                   // https://cs.symfony.com/doc/rules/strict/declare_strict_types.html
                   'global_namespace_import'                     => [
                       'import_classes'   => true,
                       'import_constants' => true,
                       'import_functions' => true,
                   ],
                   'linebreak_after_opening_tag'                 => true,
                   'mb_str_functions'                            => true,
                   'multiline_whitespace_before_semicolons'      => ['strategy' => 'new_line_for_chained_calls'],
                   'no_multiline_whitespace_around_double_arrow' => false,
                   'no_php4_constructor'                         => true,
                   'no_superfluous_phpdoc_tags'                  => true,
                   'no_unreachable_default_argument_value'       => true,
                   'no_useless_else'                             => true,
                   'no_useless_return'                           => true,
                   'nullable_type_declaration'                   => true,
                   // https://cs.symfony.com/doc/rules/language_construct/nullable_type_declaration.html
                   'ordered_imports'                             => [
                       'sort_algorithm' => 'alpha',
                       'imports_order' => ['const', 'class', 'function'],
                   ],
                   // # Needed to avoid messing with @var annotations for PHPStan
                   'phpdoc_to_comment'                           => false,
                   // https://cs.symfony.com/doc/rules/phpdoc/phpdoc_to_comment.html
                   'php_unit_strict'                             => true,
                   // Deprecated in phpUnit 11
                   'php_unit_test_class_requires_covers'         => false,
                   'phpdoc_order'                                => true,
                   'protected_to_private'                        => false,
                    // https://cs.symfony.com/doc/rules/class_notation/protected_to_private.html
                   'semicolon_after_instruction'                 => true,
                   'single_quote'                                => true,
                   'strict_comparison'                           => true,
                   'strict_param'                                => true,
                   'whitespace_after_comma_in_array'             => ['ensure_single_space' => true],
                   'yoda_style'                                  => true,
                   // https://cs.symfony.com/doc/rules/control_structure/yoda_style.html

               ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setCacheFile('.php-cs-fixer.cache')       // https://cs.symfony.com/doc/usage.html#caching
    ->setParallelConfig(ParallelConfigFactory::detect()) // https://cs.symfony.com/doc/usage.html#the-fix-command
;
