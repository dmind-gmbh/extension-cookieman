<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PER-CS' => true,
        'yoda_style' => false, // dude, I love yoda style
        'function_declaration' => [
            'closure_function_spacing' => 'none',
            'closure_fn_spacing' => 'none',
        ],
        'single_line_empty_body' => false,
        'cast_spaces' => ['space' => 'single'],
    ])
    // 💡 by default, Fixer looks for `*.php` files excluding `./vendor/` - here, you can groom this config
    ->setFinder(
        (new Finder())
            ->in(__DIR__)
            // 💡 additional files, eg bin entry file
            // ->append([__DIR__.'/bin-entry-file'])
            ->exclude(
                [
                    '.build/',
                    '.ddev/',
                    'Tests/Acceptance/Support/_generated/',
                    'var/cache/',
                ],
            )
            ->notName(['setttings.php'])
            // ->notPath([/* ... */])
            ->ignoreDotFiles(false), // true by default in v3, false in v4 or future mode
    );
