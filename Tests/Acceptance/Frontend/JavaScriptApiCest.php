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
 * Tests clicking through some frontend pages
 */
class JavaScriptApiCest
{
    /**
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function onScriptLoadedEventHandler(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $this->cookieValueForGroups(
                [Constants::GROUP_keyMandatory, Constants::GROUP_keyTestgroup],
            ),
        );
        $I->reloadPage();

        // test onScriptLoaded() (once as a callback and once when already loaded)
        foreach ([0, 1] as $iScript) {
            $onScriptLoadedArgs = [Constants::TRACKINGOBJECT_inTestgroupWith2Scripts, $iScript];
            $I->executeJS(
                Constants::JS_onScriptLoaded,
                $onScriptLoadedArgs,
            );
            $I->waitForText($onScriptLoadedArgs[0] . ':' . $onScriptLoadedArgs[1] . ' loaded');
        }
    }

    /**
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function onConsentedEventHandler(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $this->cookieValueForGroups([Constants::GROUP_keyMandatory]),
        );
        $I->reloadPage();

        // group already consented -> callback fires immediately
        $I->executeJS(Constants::JS_onConsented, [Constants::GROUP_keyMandatory]);
        $I->waitForText(Constants::GROUP_keyMandatory . ' consented');

        // group not yet consented -> callback waits until consent is granted
        $I->executeJS(Constants::JS_onConsented, [Constants::GROUP_key2nd]);
        $I->dontSee(Constants::GROUP_key2nd . ' consented');

        $I->executeJS(Constants::JS_consent, [Constants::GROUP_key2nd]);
        $I->waitForText(Constants::GROUP_key2nd . ' consented');
    }

    /**
     * @param AcceptanceTester $I
     * @throws ModuleException
     * @throws \Exception
     */
    public function onConsentChangedEventHandler(AcceptanceTester $I): void
    {
        $I->amOnPage(Constants::PATH_root);
        $I->setCookie(
            Constants::COOKIENAME,
            $this->cookieValueForGroups([Constants::GROUP_keyMandatory]),
        );
        $I->reloadPage();

        $I->executeJS(Constants::JS_onConsentChanged);
        $I->executeJS(Constants::JS_consent, [Constants::GROUP_key2nd]);
        $I->waitForText(
            'consentChanged:' . $this->cookieValueForGroups([Constants::GROUP_keyMandatory, Constants::GROUP_key2nd]),
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
}
