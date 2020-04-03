<?php declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3_MODE') || die();

// static TypoScript
(static function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'cookieman',
        'Configuration/TypoScript',
        'Cookieman'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'cookieman',
        'Configuration/TypoScript/Example',
        'Cookieman (Example configuration of groups and tracking objects)'
    );
})();
