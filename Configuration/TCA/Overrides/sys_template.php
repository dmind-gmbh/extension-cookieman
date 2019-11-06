<?php
defined('TYPO3_MODE') || die();

// static TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'cookieman',
    'Configuration/TypoScript',
    'Cookieman'
);
