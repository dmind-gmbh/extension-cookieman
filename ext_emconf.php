<?php

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'd-mind Cookieman',
    'description' => 'Provides cookie opt-in by loading JavaScript only when consented',
    'category' => 'frontend',
    'author' => 'Jonas Eberle',
    'author_email' => 'jonas.eberle@d-mind.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.1.5',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    ];
