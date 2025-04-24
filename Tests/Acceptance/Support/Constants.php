<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Support;

class Constants
{
    public const PATH_root = '/';
    public const PATH_imprint = '/imprint';

    public const SELECTOR_modal = '#cookieman-modal';
    public const SELECTOR_btnDataCookiemanShow = '[data-cookieman-show]';
    public const SELECTOR_btnSaveNotSaveAll = '[data-cookieman-save]:not([data-cookieman-accept-all]):not([data-cookieman-accept-none])';
    public const SELECTOR_btnSaveNone = '[data-cookieman-save][data-cookieman-accept-none]';
    public const SELECTOR_btnSaveAll = '[data-cookieman-save][data-cookieman-accept-all]';
    public const LOCATOR_settings = ['xpath' => '//*[self::button or self::a][contains(., "Settings")]'];
    public const LOCATOR_2ndGroup = ['xpath' => '//*[self::button or self::a][contains(., "Settings")]'];

    public const COOKIENAME = 'CookieConsent';
    public const COOKIE_separator = '|';

    public const JS_showCookieman = 'cookieman.show()';
    public const JS_onScriptLoaded = "
            cookieman.onScriptLoaded(
                arguments[0],
                arguments[1],
                function (trackingObjectKey, scriptId) {
                    document.body.append(arguments[0] + ':' + arguments[1] + ' loaded; ')
                }
            );
        ";

    public const GROUP_keyMandatory = 'mandatory';

    public const GROUP_key2nd = 'marketing';
    public const COOKIE_titleIn2ndGroup = '_gat';

    public const GROUP_keyTestgroup = 'testgroup';
    public const TRACKINGOBJECT_inTestgroupWith2Scripts = 'Crowdin';

    public const WAITFOR_timeout = 5;
}
