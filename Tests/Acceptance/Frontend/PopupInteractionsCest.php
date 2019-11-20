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

use Dmind\Cookieman\Tests\Acceptance\Support\AcceptanceTester;

/**
 * Tests clicking through some frontend pages
 */
class PopupInteractionsCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function doesNotBreakBootstrapPackage(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(0.5);
        $I->see('About Cookies');
        $I->executeJS('cookieman.hide()');
        $I->wait(0.5);
        $I->dontSee('About Cookies');
        $I->moveMouseOver('[href="/pages"]'); // hover over menu
        $I->see('2 Columns 50/50');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function save(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(0.5);
        $I->see('About Cookies');
        $I->click('[data-cookieman-save]:not([data-cookieman-accept-all])');
        $I->wait(0.5);
        $I->dontSee('About Cookies');
        $I->seeCookie('CookieConsent');
        $I->assertEquals(
            'mandatory',
            $I->grabCookie('CookieConsent', ['path' => '/'])
        );
    }

    /**
     * @param AcceptanceTester $I
     */
    public function saveAll(AcceptanceTester $I)
    {
        $I->amOnPage('/customize');
        $I->wait(0.5);
        $I->see('About Cookies');
        $I->tryToClick('Settings'); // customtheme doesn't have an accordion
        $I->click('[data-cookieman-accept-all]');
        $I->wait(0.5);
        $I->dontSee('About Cookies');
        $I->seeCookie('CookieConsent');
        $I->assertEquals(
            'mandatory|marketing',
            $I->grabCookie('CookieConsent', ['path' => '/'])
        );
    }

    /**
     * @param AcceptanceTester $I
     */
    public function notShownOnImprint(AcceptanceTester $I)
    {
        $I->amOnPage('/?id=10');
        $I->wait(0.5);
        $I->dontSee('About Cookies');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function selectGroupAndSaveMobile(AcceptanceTester $I)
    {
        $I->amOnPage('/pages');
        $I->resizeWindow(480, 800);
        $I->wait(0.5);
        $I->see('About Cookies');
        if ($I->tryToClick('Settings')) {
            $I->wait(0.5);
        }
        $I->see('Marketing');
        $I->tryToClick('Marketing');
        $I->wait(0.5);
        $I->see('_gat'); // a single row in the table
        if (!$I->tryToCheckOption('[name=marketing]')) { // theme: *-modal
            $I->executeJS('$("[name=marketing]").click()'); // theme: bootstrap3-banner
        }
        $I->seeCheckboxIsChecked('[name=marketing]');
        $I->click('Save');
        $I->wait(0.5);
        $I->dontSee('About Cookies');
        $I->seeCookie('CookieConsent');
        $I->assertEquals(
            'mandatory|marketing',
            $I->grabCookie('CookieConsent', ['path' => '/'])
        );
    }

    /**
     * @param AcceptanceTester $I
     */
    public function reopenAndRevoke(AcceptanceTester $I)
    {
        $I->amOnPage('/pages');
        $I->setCookie('CookieConsent', 'mandatory|marketing', ['path' => '/']);
        $I->amOnPage('/content-examples');
        $I->dontSee('About Cookies');
        $I->executeJS('cookieman.showOnce()');
        $I->dontSee('About Cookies');
        $I->executeJS('cookieman.show()');
        $I->see('About Cookies');
        $I->tryToClick('Settings');
        $I->see('Marketing');
        $I->tryToClick('Marketing');
        $I->seeCheckboxIsChecked('[name=marketing]');
        if (!$I->tryToUncheckOption('[name=marketing]')) { // theme: *-modal
            $I->executeJS('$("[name=marketing]").click()'); // theme: bootstrap3-banner
        }
        $I->dontSeeCheckboxIsChecked('[name=marketing]');
        $I->click('Save');
        $I->dontSee('About Cookies');
        $I->seeCookie('CookieConsent');
        $I->assertEquals(
            'mandatory',
            $I->grabCookie('CookieConsent', ['path' => '/'])
        );
    }
}
