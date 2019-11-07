<?php

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'd-mind Cookieman Test (provides auto-configuration for testing and development)',
    'description' => '',
    'category' => 'frontend',
    'author' => 'Jonas Eberle',
    'author_email' => 'jonas.eberle@d-mind.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '10.x.x-dev',
    'constraints' => [
        'depends' => ['bootstrap-package' => '*'],
        'conflicts' => [],
        'suggests' => ['bootstrap-package' => '*'],
    ],
];
