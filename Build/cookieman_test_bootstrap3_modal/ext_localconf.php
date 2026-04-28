<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

(static function() {
    ExtensionManagementUtility::addTypoScriptConstants(
        <<<TYPOSCRIPT
        @import 'EXT:cookieman_test_bootstrap3_modal/Configuration/TypoScript/constants.typoscript'
        TYPOSCRIPT,
    );

    ExtensionManagementUtility::addTypoScriptSetup(
        <<<TYPOSCRIPT
        @import 'EXT:cookieman_test_bootstrap3_modal/Configuration/TypoScript/setup.typoscript'
        TYPOSCRIPT,
    );
})();
