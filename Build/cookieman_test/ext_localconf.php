<?php

defined('TYPO3') || die();

(static function () {
    // @todo: Currently TypoScript _LOCAL_LANG does not work in non-plugin context. https://forge.typo3.org/issues/100759
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:cookieman/Resources/Private/Language/locallang.xlf'][]
        = 'EXT:cookieman_test/Resources/Private/Language/locallang_cookieman.xlf';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:cookieman/Resources/Private/Language/locallang.xlf'][]
        = 'EXT:cookieman_test/Resources/Private/Language/de.locallang_cookieman.xlf';
})();
