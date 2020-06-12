<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns rows of trackingObjects to be shown in the table
 */
class ShownTrackingObjectsViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument(
            'group',
            'array',
            'group configuration (settings.groups.‹group-key›)'
        );
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): array {
        $group = $arguments['group'] ?? $renderChildrenClosure();
        $settings = $renderingContext->getVariableProvider()->get('settings');

        $rows = [];
        foreach ($group['trackingObjects'] ?? [] as $trackingObjectId) {
            $rows += $settings['trackingObjects'][$trackingObjectId]['show'] ?? [];
        }

        return $rows;
    }
}
