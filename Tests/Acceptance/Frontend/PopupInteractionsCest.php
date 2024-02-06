<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Frontend;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Codeception\Util\Locator;
use Dmind\Cookieman\Tests\Acceptance\Support\AcceptanceTester;
use Exception;

/**
 * Tests clicking through some frontend pages
 */
class PopupInteractionsCest
{
    public const PATH_root = '/';
    public const PATH_imprint = '/imprint';

    public const SELECTOR_modal = '#cookieman-modal';
    public const SELECTOR_btnSaveNotSaveAll = '[data-cookieman-save]:not([data-cookieman-accept-all]):not([data-cookieman-accept-none])';
    public const SELECTOR_btnSaveNone = '[data-cookieman-save][data-cookieman-accept-none]';
    public const SELECTOR_btnSaveAll = '[data-cookieman-save][data-cookieman-accept-all]';
    public const LOCATOR_settings = ['xpath' => '//*[self::button or self::a][contains(., "Settings")]'];

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
    public const GROUP_title2nd = 'Marketing';
    public const COOKIE_titleIn2ndGroup = '_gat';

    public const GROUP_keyTestgroup = 'testgroup';
    public const TRACKINGOBJECT_inTestgroupWith2Scripts = 'Crowdin';

    public const WAITFOR_timeout = 5;

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function save(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(self::SELECTOR_modal);
        $I->waitForElementClickable(self::SELECTOR_btnSaveNone);
        $I->clickWithLeftButton(['css' => self::SELECTOR_btnSaveNone]);
        $I->waitForElementNotVisible(self::SELECTOR_modal);
        $I->seeCookie(self::COOKIENAME);
        $I->assertEquals(
            self::GROUP_keyMandatory,
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_root])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function saveAll(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(self::SELECTOR_modal);
        $I->waitForElementClickable(self::LOCATOR_settings);
        $I->clickWithLeftButton(self::LOCATOR_settings);
        $I->scrollIntoView(self::SELECTOR_btnSaveAll);
        $I->waitForElementClickable(self::SELECTOR_btnSaveAll);
        $I->clickWithLeftButton(['css' => self::SELECTOR_btnSaveAll]);
        $I->waitForElementNotVisible(self::SELECTOR_modal);
        $I->seeCookie(self::COOKIENAME);
        $I->assertStringStartsWith(
            $this->cookieValueForGroups([self::GROUP_keyMandatory, self::GROUP_key2nd]),
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_root])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function notShownOnImprint(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_imprint);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->wait(self::WAITFOR_timeout);
        $I->dontSeeElement(self::SELECTOR_modal);
        $I->executeJS(self::JS_showCookieman);
        $I->waitForElementVisible(self::SELECTOR_modal, self::WAITFOR_timeout);
    }

    /**
     * @group desktop
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function selectGroupAndSaveMobile(AcceptanceTester $I)
    {
        $I->resizeWindow(480, 800);
        $I->amOnPage(self::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(self::SELECTOR_modal, self::WAITFOR_timeout);
        $I->waitForElementClickable(self::LOCATOR_settings);
        $I->clickWithLeftButton(self::LOCATOR_settings);
        $I->waitForElementVisible(Locator::contains('*', self::GROUP_title2nd), self::WAITFOR_timeout);
        $I->waitForElementClickable(Locator::contains('*', self::GROUP_title2nd));
        $I->clickWithLeftButton(Locator::contains('*', self::GROUP_title2nd));
        $I->waitForElementVisible(
            Locator::contains('*', self::COOKIE_titleIn2ndGroup),
            self::WAITFOR_timeout
        ); // a single row in the table
        $I->scrollIntoView('[name=' . self::GROUP_key2nd . ']');
        if (!$I->tryToCheckOption('[name=' . self::GROUP_key2nd . ']')) { // theme: *-modal
            $I->executeJS('$("[name=' . self::GROUP_key2nd . ']").click()'); // theme: bootstrap3-banner
        }
        $I->seeCheckboxIsChecked('[name=' . self::GROUP_key2nd . ']');
        $I->scrollIntoView(self::SELECTOR_btnSaveNotSaveAll);
        $I->waitForElementClickable(self::SELECTOR_btnSaveNotSaveAll);
        $I->clickWithLeftButton(['css' => self::SELECTOR_btnSaveNotSaveAll]);
        $I->waitForElementNotVisible(self::SELECTOR_modal);
        $I->seeCookie(self::COOKIENAME);
        $I->assertEquals(
            $this->cookieValueForGroups([self::GROUP_keyMandatory, self::GROUP_key2nd]),
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_root])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     * @throws Exception
     */
    public function onScriptLoadedEventHandler(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_root);
        $I->setCookie(
            self::COOKIENAME,
            $this->cookieValueForGroups(
                [self::GROUP_keyMandatory, self::GROUP_keyTestgroup]
            )
        );
        $I->reloadPage();

        // test onScriptLoaded() (once as a callback and once when already loaded)
        foreach ([0, 1] as $iScript) {
            $onScriptLoadedArgs = [self::TRACKINGOBJECT_inTestgroupWith2Scripts, $iScript];
            $I->executeJS(
                self::JS_onScriptLoaded,
                $onScriptLoadedArgs
            );
            $I->waitForText($onScriptLoadedArgs[0] . ':' . $onScriptLoadedArgs[1] . ' loaded');
        }
    }

    /**
     * @param array $groupKeys
     * @return string
     */
    protected function cookieValueForGroups(array $groupKeys)
    {
        return implode(self::COOKIE_separator, $groupKeys);
    }
}
