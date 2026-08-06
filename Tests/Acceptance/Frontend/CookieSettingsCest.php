<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Frontend;

use Dmind\Cookieman\Tests\Acceptance\Support\AcceptanceTester;
use Dmind\Cookieman\Tests\Acceptance\Support\Constants;
use Facebook\WebDriver\Cookie;

/**
 * Tests plugin.tx_cookieman.settings.cookie: the attributes that cookieman gives to the
 * consent cookie.
 *
 * The test instance overrides the defaults of cookieLifetimeDays and sameSite, so these
 * tests also show that the constants arrive in the JavaScript.
 *
 * @see Build/cookieman_test/Configuration/TypoScript/constants.typoscript
 */
class CookieSettingsCest
{
    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function cookieLifetimeDaysIsUsed(AcceptanceTester $I): void
    {
        $expectedExpiry = time() + Constants::COOKIE_lifetimeDays * 86400;
        $cookie = $this->saveConsentAndGrabCookie($I);

        // one hour of tolerance for the time between the two lines above
        $I->assertEqualsWithDelta($expectedExpiry, $cookie->getExpiry(), 3600);
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function sameSiteIsUsed(AcceptanceTester $I): void
    {
        $cookie = $this->saveConsentAndGrabCookie($I);

        $I->assertEquals(Constants::COOKIE_sameSite, $cookie->getSameSite());
    }

    /**
     * `secure` is not configured. The test site is https, so cookieman switches it on.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function secureIsSetOnHttps(AcceptanceTester $I): void
    {
        $cookie = $this->saveConsentAndGrabCookie($I);

        $I->assertEquals(Constants::COOKIE_secure, $cookie->isSecure());
    }

    /**
     * `domain` is not configured, so the browser makes a host-only cookie.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function withoutDomainTheCookieIsHostOnly(AcceptanceTester $I): void
    {
        $cookie = $this->saveConsentAndGrabCookie($I);

        $I->assertStringStartsNotWith('.', (string) $cookie->getDomain());
    }

    /**
     * Saves the consent through the popup, so that cookieman writes the cookie.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    protected function saveConsentAndGrabCookie(AcceptanceTester $I): Cookie
    {
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);
        $I->waitForElementClickable(Constants::SELECTOR_btnSaveNone);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnSaveNone]);
        $I->waitForElementNotVisible(Constants::SELECTOR_modal);
        $I->seeCookie(Constants::COOKIENAME);

        return $I->grabCookieWithAttributes(Constants::COOKIENAME);
    }
}
