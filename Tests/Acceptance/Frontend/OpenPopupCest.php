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
 * Tests opening the popup
 */
class OpenPopupCest
{
    public const PATH_imprint = '/imprint';
    public const SELECTOR_modal = '#cookieman-modal';
    public const SELECTOR_btnDataCookiemanShow = '[data-cookieman-show]';

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function openViaClickOnDataCookiemanShowElement(AcceptanceTester $I)
    {
        $I->amOnPage(self::PATH_imprint);
        $I->waitForJS('return typeof cookieman === "object"', 10);
        $I->clickWithLeftButton(['css' => self::SELECTOR_btnDataCookiemanShow]);
        $I->waitForElementVisible(self::SELECTOR_modal);
    }
}
