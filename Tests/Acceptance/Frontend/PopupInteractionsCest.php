<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Frontend;

use Codeception\Util\Locator;
use Dmind\Cookieman\Tests\Acceptance\Support\AcceptanceTester;
use Dmind\Cookieman\Tests\Acceptance\Support\Constants;
use Exception;

/**
 * Tests clicking through some frontend pages
 */
class PopupInteractionsCest
{
    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function save(AcceptanceTester $I)
    {
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal);
        $I->waitForElementClickable(Constants::SELECTOR_btnSaveNone);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnSaveNone]);
        $I->waitForElementNotVisible(Constants::SELECTOR_modal);
        $I->seeCookie(Constants::COOKIENAME);
        $I->assertEquals(
            Constants::GROUP_keyMandatory,
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function saveAll(AcceptanceTester $I)
    {
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal);
        $I->waitForElementClickable(Constants::LOCATOR_settings);
        $I->clickWithLeftButton(Constants::LOCATOR_settings);
        $I->scrollIntoView(Constants::SELECTOR_btnSaveAll);
        $I->waitForElementClickable(Constants::SELECTOR_btnSaveAll);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnSaveAll]);
        $I->waitForElementNotVisible(Constants::SELECTOR_modal);
        $I->seeCookie(Constants::COOKIENAME);
        $I->assertStringStartsWith(
            $this->cookieValueForGroups([Constants::GROUP_keyMandatory, Constants::GROUP_key2nd]),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root])
        );
    }

    /**
     * @param array $groupKeys
     * @return string
     */
    protected function cookieValueForGroups(array $groupKeys)
    {
        return implode(Constants::COOKIE_separator, $groupKeys);
    }

    /**
     * @group desktop
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function selectGroupAndSaveMobile(AcceptanceTester $I)
    {
        $I->resizeWindow(480, 800);
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);
        $I->waitForElementClickable(Constants::LOCATOR_settings);
        $I->clickWithLeftButton(Constants::LOCATOR_settings);
        $I->waitForElementVisible(Locator::contains('*', Constants::GROUP_title2nd), Constants::WAITFOR_timeout);
        $I->waitForElementClickable(Locator::contains('*', Constants::GROUP_title2nd));
        $I->clickWithLeftButton(Locator::contains('*', Constants::GROUP_title2nd));
        $I->waitForElementVisible(
            Locator::contains('*', Constants::COOKIE_titleIn2ndGroup),
            Constants::WAITFOR_timeout
        ); // a single row in the table
        $I->scrollIntoView('[name=' . Constants::GROUP_key2nd . ']');
        if (!$I->tryToCheckOption('[name=' . Constants::GROUP_key2nd . ']')) { // theme: *-modal
            $I->executeJS('$("[name=' . Constants::GROUP_key2nd . ']").click()'); // theme: bootstrap3-banner
        }
        $I->seeCheckboxIsChecked('[name=' . Constants::GROUP_key2nd . ']');
        $I->scrollIntoView(Constants::SELECTOR_btnSaveNotSaveAll);
        $I->waitForElementClickable(Constants::SELECTOR_btnSaveNotSaveAll);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnSaveNotSaveAll]);
        $I->waitForElementNotVisible(Constants::SELECTOR_modal);
        $I->seeCookie(Constants::COOKIENAME);
        $I->assertEquals(
            $this->cookieValueForGroups([Constants::GROUP_keyMandatory, Constants::GROUP_key2nd]),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root])
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     * @throws Exception
     */
    public function onScriptLoadedEventHandler(AcceptanceTester $I)
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $this->cookieValueForGroups(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup]
            )
        );
        $I->reloadPage();

        // test onScriptLoaded() (once as a callback and once when already loaded)
        foreach ([0, 1] as $iScript) {
            $onScriptLoadedArgs = [Constants::TRACKINGOBJECT_inTestgroupWith2Scripts, $iScript];
            $I->executeJS(
                Constants::JS_onScriptLoaded,
                $onScriptLoadedArgs
            );
            $I->waitForText($onScriptLoadedArgs[0] . ':' . $onScriptLoadedArgs[1] . ' loaded');
        }
    }
}
