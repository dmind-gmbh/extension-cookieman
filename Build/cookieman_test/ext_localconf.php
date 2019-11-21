<?php

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

(function () {
    $bspConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bootstrap_package'], []);
    // the Web Font Loader injects inline JS which does not work with CSP
    $bspConf['disableFontLoader'] = 1;
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['bootstrap_package'] = serialize($bspConf);
})();
