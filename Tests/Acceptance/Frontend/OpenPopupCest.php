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
use Exception;

/**
 * Tests opening the popup
 */
class OpenPopupCest
{
    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function openViaClickOnDataCookiemanShowElement(AcceptanceTester $I)
    {
        $I->amOnPage(Constants::PATH_imprint);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->clickWithLeftButton(['css' => Constants::SELECTOR_btnDataCookiemanShow]);
        $I->waitForElementVisible(Constants::SELECTOR_modal);
    }

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function notShownOnImprint(AcceptanceTester $I)
    {
        $I->amOnPage(Constants::PATH_imprint);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->wait(Constants::WAITFOR_timeout);
        $I->dontSeeElement(Constants::SELECTOR_modal);
        $I->executeJS(Constants::JS_showCookieman);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);
    }
}
