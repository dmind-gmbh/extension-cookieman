<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Frontend;

use Codeception\Exception\ModuleException;
use Dmind\Cookieman\Tests\Acceptance\Support\AcceptanceTester;
use Dmind\Cookieman\Tests\Acceptance\Support\Constants;

/**
 * Tests plugin.tx_cookieman.settings.consentConfigurationVersion
 *
 * The test instance configures Constants::CONSENTCONFIGURATIONVERSION, which is not the
 * default. Thus these tests also show that the constant arrives in the JavaScript.
 *
 * @see Build/cookieman_test/Configuration/TypoScript/constants.typoscript
 */
class ConsentConfigurationVersionCest
{
    /**
     * Without a cookie the popup shows. The silent upgrade does not write a cookie for a
     * user who never consented.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function noCookieShowsThePopup(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);
        $I->dontSeeCookie(Constants::COOKIENAME);
    }

    /**
     * A cookie without a version was saved before the integrator used
     * consentConfigurationVersion, or by cookieman < 5.0.0. The consent stays valid and
     * cookieman writes the current version into the cookie ("silent upgrade").
     *
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function cookieWithoutVersionIsUpgradedSilently(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $I->cookieValueWithVersion(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
                '',
            ),
        );
        $I->reloadPage();
        $I->waitForJS('return typeof cookieman === "object"', 10);
        // give showOnce() (setTimeout of cookieman-init) the chance to open the popup
        $I->wait(2);

        // all themes hide #cookieman-modal with the Bootstrap `modal` class
        $I->dontSeeElement(Constants::SELECTOR_modal);
        $I->assertEquals(
            $I->cookieValueWithVersion([Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup]),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root]),
        );
        $I->assertEquals(
            [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
            $I->executeJS(Constants::JS_consenteds),
        );
    }

    /**
     * The version in the cookie is the configured one: nothing happens.
     *
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function currentVersionShowsNoPopup(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $I->cookieValueWithVersion([Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup]),
        );
        $I->reloadPage();
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->wait(2);

        $I->dontSeeElement(Constants::SELECTOR_modal);
        $I->assertEquals(
            $I->cookieValueWithVersion([Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup]),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root]),
        );
        $I->assertEquals(
            [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
            $I->executeJS(Constants::JS_consenteds),
        );
    }

    /**
     * The integrator changed the version: the popup shows again, the selections of the
     * user stay in the checkboxes, and the old consent does not count until they save.
     *
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function outdatedVersionShowsThePopupAndSuspendsTheConsent(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $I->cookieValueWithVersion(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
                Constants::CONSENTCONFIGURATIONVERSION_outdated,
            ),
        );
        $I->reloadPage();
        $I->waitForJS('return typeof cookieman === "object"', 10);

        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);
        // the selections of the user stay
        $I->seeCheckboxIsChecked('[name=' . Constants::GROUP_keyTestgroup . ']');
        // the old consent does not count
        $I->assertEquals([], $I->executeJS(Constants::JS_consenteds));
        // cookieman does not touch an outdated cookie before the user saves
        $I->assertEquals(
            $I->cookieValueWithVersion(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
                Constants::CONSENTCONFIGURATIONVERSION_outdated,
            ),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root]),
        );
    }

    /**
     * After the user saves, the cookie holds the configured version and the consent
     * counts again.
     *
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function savingAfterAnOutdatedVersionWritesTheCurrentVersion(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $I->cookieValueWithVersion(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
                Constants::CONSENTCONFIGURATIONVERSION_outdated,
            ),
        );
        $I->reloadPage();
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);

        $I->waitForElementClickable(Constants::SELECTOR_btnSaveNone);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnSaveNone]);
        $I->waitForElementNotVisible(Constants::SELECTOR_modal);

        // "accept none" keeps the disabled (preselected) group only
        $I->assertEquals(
            $I->cookieValueWithVersion([Constants::GROUP_keyMandatory]),
            $I->grabCookie(Constants::COOKIENAME, ['path' => Constants::PATH_root]),
        );
        $I->assertEquals(
            [Constants::GROUP_keyMandatory],
            $I->executeJS(Constants::JS_consenteds),
        );
    }
}
