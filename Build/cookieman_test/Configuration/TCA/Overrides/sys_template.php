<?php
defined('TYPO3_MODE') || die();

// static TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'cookieman_test',
    'Configuration/TypoScript',
    'Cookieman Test'
);
