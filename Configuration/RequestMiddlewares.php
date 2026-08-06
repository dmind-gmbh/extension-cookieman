<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Dmind\Cookieman\Middleware\PopupRoute;

return [
    'frontend' => [
        'dmind/cookieman/popup-route' => [
            'target' => PopupRoute::class,
            // before the site middleware, which makes the route result from the URI
            'before' => [
                'typo3/cms-frontend/site',
            ],
        ],
    ],
];
