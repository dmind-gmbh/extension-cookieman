<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/*
 * Adds a German language to the site that `install:setup` made, so that the acceptance
 * tests can see whether cookieman gives the labels of the language of the page.
 *
 * The post-start hook of ddev calls this, @see .ddev/config.yaml
 *
 * It only adds. Thus it does not go stale when TYPO3 changes what `install:setup` writes.
 */

use Symfony\Component\Yaml\Yaml;

require __DIR__ . '/../../.build/vendor/autoload.php';

const LANGUAGE_ID = 1;

$file = __DIR__ . '/../../config/sites/main/config.yaml';
$config = Yaml::parseFile($file);

foreach ($config['languages'] ?? [] as $language) {
    if (($language['languageId'] ?? null) === LANGUAGE_ID) {
        echo "The German language is already in {$file}.\n";
        exit(0);
    }
}

$config['languages'][] = [
    'title' => 'German',
    'enabled' => true,
    'languageId' => LANGUAGE_ID,
    'base' => '/de/',
    'locale' => 'de_DE.UTF-8',
    'navigationTitle' => 'Deutsch',
    'flag' => 'de',
    'fallbackType' => 'fallback',
    'fallbacks' => '0',
];

file_put_contents($file, Yaml::dump($config, 99, 2));
echo "Added the German language to {$file}.\n";
