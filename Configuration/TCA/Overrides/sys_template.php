<?php
if ( ! defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// inject our TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('cookieman', 'Configuration/TypoScript',
    'Cookieman'
);
