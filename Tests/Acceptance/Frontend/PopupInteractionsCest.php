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

/**
 * Tests clicking through some frontend pages
 */
class PopupInteractionsCest
{
    const PATH_ROOT = '/';
    const PATH_2NDPAGE = '/customize';
    const PATH_3RDPAGE = '/?id=10';
    const PATH_4THPAGE = '/pages';

    const MODAL_TITLE_EN = 'About Cookies';
    const MODAL_TEXT_EN = 'This website uses cookies.';

    const SELECTOR_MODAL = '#cookieman-modal';
    const SELECTOR_BUTTON_SAVE_NOT_SAVEALL = '[data-cookieman-save]:not([data-cookieman-accept-all])';
    const SELECTOR_BUTTON_SAVEALL = '[data-cookieman-accept-all]';
    const SETTINGS_LINK_SELECTOR = '[aria-controls="cookieman-settings"]';

    const COOKIENAME = 'CookieConsent';
    const COOKIE_VALUE_SEPARATOR = '|';

    const BS_PACKAGE_MENUITEM_SELECTOR = '[href$="/pages"],[href$="?id=66"]';
    const BS_PACKAGE_SUBMENUITEM_TEXT = '2 Columns 50/50';
    // for introduction-package ^3.0
    const BS_PACKAGE_INTRO3_MENUITEM_SELECTOR = '[href$="?id=51"]';
    const BS_PACKAGE_INTRO3_SUBMENUITEM_TEXT = 'Form elements';

    const JS_SHOW_COOKIEMAN = 'cookieman.show()';
    const JS_SHOWONCE_COOKIEMAN = 'cookieman.showOnce()';
    const JS_HIDE_COOKIEMAN = 'cookieman.hide()';
    const JS_ONSCRIPTLOADED_COOKIEMAN = "
            cookieman.onScriptLoaded(
                arguments[0],
                arguments[1],
                function (trackingObjectKey, scriptId) {
                    document.body.append(arguments[0] + ':' + arguments[1] + ' loaded; ')
                }
            );
        ";

    const GROUP_KEY_MANDATORY = 'mandatory';

    const GROUP_KEY_2ND = 'marketing';
    const GROUP_TITLE_2ND = 'Marketing';
    const COOKIE_TITLE_IN_2ND_GROUP = '_gat';

    const GROUP_KEY_TESTGROUP = 'testgroup';
    const TRACKINGOBJECT_IN_TESTGROUP_WITH_2SCRIPTS = 'Crowdin';

    const WAITFOR_TIMEOUT = 5;

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function doesNotBreakBootstrapPackage(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_ROOT);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(self::SELECTOR_MODAL, self::WAITFOR_TIMEOUT);
        $I->executeJS(self::JS_HIDE_COOKIEMAN);
        $I->waitForElementNotVisible(self::SELECTOR_MODAL);
        if ($I->tryToMoveMouseOver(self::BS_PACKAGE_MENUITEM_SELECTOR)) { // hover over menu
            $I->seeElement(Locator::contains('*', self::BS_PACKAGE_SUBMENUITEM_TEXT));
        } else { // introduction-package ^3.0
            $I->moveMouseOver(self::BS_PACKAGE_INTRO3_MENUITEM_SELECTOR);
            $I->seeElement(Locator::contains('*', self::BS_PACKAGE_INTRO3_SUBMENUITEM_TEXT));
        }
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function save(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_ROOT);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Locator::contains('*', self::MODAL_TITLE_EN), self::WAITFOR_TIMEOUT);
        $I->wait(0.5); // animation
        $I->clickWithLeftButton(self::SELECTOR_BUTTON_SAVE_NOT_SAVEALL);
        $I->waitForElementNotVisible(self::SELECTOR_MODAL);
        $I->seeCookie(self::COOKIENAME);
        $I->assertEquals(
            self::GROUP_KEY_MANDATORY,
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_ROOT])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function saveAll(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_2NDPAGE);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Locator::contains('*', self::MODAL_TEXT_EN), self::WAITFOR_TIMEOUT);
        $I->wait(0.5); // animation
        $I->tryToClickWithLeftButton(self::SETTINGS_LINK_SELECTOR); // customtheme doesn't have an accordion
        $I->wait(0.5); // animation
        $I->clickWithLeftButton(self::SELECTOR_BUTTON_SAVEALL);
        $I->waitForElementNotVisible(self::SELECTOR_MODAL);
        $I->seeCookie(self::COOKIENAME);
        $I->assertStringStartsWith(
            $this->cookieValueForGroups([self::GROUP_KEY_MANDATORY, self::GROUP_KEY_2ND]),
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_ROOT])
        );
    }

    /**
     * @param AcceptanceTester $I
     */
    public function notShownOnImprint(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_3RDPAGE);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->dontSeeElement(self::SELECTOR_MODAL);
    }

    /**
     * @group desktop
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function selectGroupAndSaveMobile(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_4THPAGE);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->resizeWindow(480, 800);
        $I->waitForElementVisible(self::SELECTOR_MODAL, self::WAITFOR_TIMEOUT);
        $I->tryToClickWithLeftButton(self::SETTINGS_LINK_SELECTOR);
        $I->waitForElementVisible(Locator::contains('*', self::GROUP_TITLE_2ND), self::WAITFOR_TIMEOUT);
        $I->tryToClick(self::GROUP_TITLE_2ND);
        $I->waitForElementVisible(Locator::contains('*', self::COOKIE_TITLE_IN_2ND_GROUP), self::WAITFOR_TIMEOUT); // a single row in the table
        $I->scrollTo('[name=' . self::GROUP_KEY_2ND . ']');
        if (!$I->tryToCheckOption('[name=' . self::GROUP_KEY_2ND . ']')) { // theme: *-modal
            $I->executeJS('$("[name=' . self::GROUP_KEY_2ND . ']").click()'); // theme: bootstrap3-banner
        }
        $I->seeCheckboxIsChecked('[name=' . self::GROUP_KEY_2ND . ']');
        $I->clickWithLeftButton(self::SELECTOR_BUTTON_SAVE_NOT_SAVEALL);
        $I->waitForElementNotVisible(self::SELECTOR_MODAL);
        $I->seeCookie(self::COOKIENAME);
        $I->assertEquals(
            $this->cookieValueForGroups([self::GROUP_KEY_MANDATORY, self::GROUP_KEY_2ND]),
            $I->grabCookie(self::COOKIENAME, ['path' => self::PATH_ROOT])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     * @throws \Exception
     */
    public function onScriptLoadedEventHandler(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_ROOT);
        $I->setCookie(
            self::COOKIENAME,
            $this->cookieValueForGroups(
                [self::GROUP_KEY_MANDATORY, self::GROUP_KEY_TESTGROUP]
            )
        );
        $I->reloadPage();

        // test onScriptLoaded() (once as a callback and once when already loaded)
        foreach ([0, 1] as $iScript) {
            $onScriptLoadedArgs = [self::TRACKINGOBJECT_IN_TESTGROUP_WITH_2SCRIPTS, $iScript];
            $I->executeJS(
                self::JS_ONSCRIPTLOADED_COOKIEMAN,
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
        return implode(self::COOKIE_VALUE_SEPARATOR, $groupKeys);
    }
}
