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
 * Tests that the popup gives the labels of the language of the page.
 *
 * The page only holds a stub and loads the popup from the language of the page,
 * @see \Dmind\Cookieman\Middleware\PopupRoute
 */
class TranslationCest
{
    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function englishPageShowsEnglishLabels(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);

        $I->see(Constants::LABEL_heading, Constants::SELECTOR_modal);
        $I->dontSee(Constants::LABEL_headingDe, Constants::SELECTOR_modal);
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function germanPageShowsGermanLabels(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_rootDe);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->waitForElementVisible(Constants::SELECTOR_modal, Constants::WAITFOR_timeout);

        $I->see(Constants::LABEL_headingDe, Constants::SELECTOR_modal);
        $I->dontSee(Constants::LABEL_heading, Constants::SELECTOR_modal);
    }

    /**
     * The stub asks for the popup of its own language.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function theStubPointsToThePopupOfItsLanguage(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_rootDe);

        $I->assertStringStartsWith(
            Constants::PATH_rootDe . '?' . Constants::POPUP_argument . '=',
            $I->grabAttributeFrom('[data-cookieman-stub]', 'data-cookieman-popup-url'),
        );
    }

    /**
     * The German popup itself, without the stub.
     *
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function theGermanEndpointServesGermanLabels(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_rootDe . '?' . Constants::POPUP_argument);

        $I->seeInSource(Constants::LABEL_headingDe);
        $I->dontSeeInSource(Constants::LABEL_heading);
    }
}
