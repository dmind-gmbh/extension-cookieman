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
    /** the second language of the test site, @see .ddev/config.yaml */
    public const PATH_rootDe = '/de/';

    /** `heading` of Resources/Private/Language/locallang.xlf and of its German language pack */
    public const LABEL_heading = 'About Cookies';
    public const LABEL_headingDe = 'Hinweis zu Cookies';
    /** @see \Dmind\Cookieman\Middleware\PopupRoute::ARGUMENT */
    public const POPUP_argument = 'consent';
    /** the root page with the query argument */
    public const PATH_popup = '/?' . self::POPUP_argument;

    public const SELECTOR_modal = '#cookieman-modal';
    public const SELECTOR_btnDataCookiemanShow = '[data-cookieman-show]';
    public const SELECTOR_btnSaveNotSaveAll = '[data-cookieman-save]:not([data-cookieman-accept-all]):not([data-cookieman-accept-none])';
    public const SELECTOR_btnSaveNone = '[data-cookieman-save][data-cookieman-accept-none]';
    public const SELECTOR_btnSaveAll = '[data-cookieman-save][data-cookieman-accept-all]';
    public const LOCATOR_settings = ['xpath' => '//*[self::button or self::a][contains(., "Settings")]'];
    public const LOCATOR_2ndGroup = ['xpath' => '//*[self::button or self::a][contains(., "Settings")]'];

    public const COOKIENAME = 'CookieConsent';
    public const COOKIE_separator = '|';
    public const COOKIE_versionSeparator = '#';

    /**
     * The test instance overrides the default 1. A test that expects this value fails if
     * the constant does not arrive in the JS, because the JS falls back to the default.
     *
     * @see Build/cookieman_test/Configuration/TypoScript/constants.typoscript
     */
    public const CONSENTCONFIGURATIONVERSION = '2';
    /** any other non-empty version. Not '0', which reads like "switched off". */
    public const CONSENTCONFIGURATIONVERSION_outdated = '0.9';

    /**
     * The test instance overrides the defaults of cookieLifetimeDays and sameSite, and
     * uses the default of secure.
     *
     * @see Build/cookieman_test/Configuration/TypoScript/constants.typoscript
     */
    public const COOKIE_lifetimeDays = 30;
    public const COOKIE_sameSite = 'Lax';
    /** the test site is https, so the default switches `secure` on */
    public const COOKIE_secure = true;

    public const JS_consenteds = 'return cookieman.consenteds()';

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
    public const JS_onConsented = "
            cookieman.onConsented(
                arguments[0],
                function (groupKey) {
                    document.body.append(groupKey + ' consented; ')
                }
            );
        ";
    public const JS_onConsentChanged = "
            cookieman.onConsentChanged(
                function (consenteds) {
                    document.body.append('consentChanged:' + consenteds.join('|') + '; ')
                }
            );
        ";
    public const JS_consent = 'cookieman.consent(arguments[0])';

    public const GROUP_keyMandatory = 'mandatory';

    public const GROUP_key2nd = 'marketing';
    public const COOKIE_titleIn2ndGroup = '_gat';

    public const GROUP_keyTestgroup = 'testgroup';
    public const TRACKINGOBJECT_inTestgroupWith2Scripts = 'TestTrackingObject';

    public const WAITFOR_timeout = 5;
}
