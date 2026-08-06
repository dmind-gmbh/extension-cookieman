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

/**
 * Tests the endpoint that serves the popup, @see \Dmind\Cookieman\Middleware\PopupRoute
 */
class PopupEndpointCest
{
    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function servesThePopup(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_popup);

        $I->seeInSource('id="cookieman-modal"');
        $I->seeInSource('data-cookieman-settings=');
        $I->seeInSource('data-cookieman-form');
    }

    /**
     * The response holds only the popup, not a whole page.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function servesNoPageAroundThePopup(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_popup);

        $I->dontSeeInSource('<title>');
        $I->dontSeeInSource('cookieman.min.js');
    }

    /**
     * The stub puts a hash of the configuration into the argument, to make the browser
     * load the popup again after a change. The middleware drops all query arguments, so
     * TYPO3 does not see an unknown one.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function ignoresTheValueOfTheArgument(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_popup . '=any-hash-here');

        $I->seeInSource('id="cookieman-modal"');
    }

    /**
     * Without the argument, the root page is a normal page.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function withoutTheArgumentTheRootPageIsNormal(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);

        $I->seeInSource('cookieman.js');
    }
}
