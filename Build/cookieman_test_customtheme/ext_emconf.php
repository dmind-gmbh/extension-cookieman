<?php

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'd-mind Cookieman test environment (Custom theme integration)',
    'description' => '',
    'category' => 'frontend',
    'author' => 'Jonas Eberle',
    'author_email' => 'jonas.eberle@d-mind.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => 'x.x.x-dev',
    'constraints' => [
        'depends' => ['bootstrap_package' => '*'],
        'conflicts' => [
            'cookieman_test_bootstrap3_banner' => '*',
            'cookieman_test_bootstrap3_modal' => '*'
        ],
        'suggests' => ['bootstrap_package' => '*'],
    ],
];
