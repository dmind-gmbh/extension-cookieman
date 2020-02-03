<?php

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Cookieman',
    'description' => 'A GDPR tracking consent popup. It asks for approval to include tracking objects (cookies, images or any HTML) and includes the objects when consented. Notice: Supports TYPO3v8/v9/v10, but each unique version only supports one!',
    'category' => 'fe',
    'author' => 'Jonas Eberle',
    'author_email' => 'jonas.eberle@d-mind.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.4.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    ];
