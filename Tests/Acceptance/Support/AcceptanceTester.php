<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Support;

use Codeception\Actor;
use Dmind\Cookieman\Tests\Acceptance\Support\_generated\AcceptanceTesterActions;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Default acceptance tester
 */
class AcceptanceTester extends Actor
{
    use AcceptanceTesterActions;

    /*
     * Use JavaScript because Chrome/Webdriver's (?) setCookie() does not set to the correct domain.
     * $params are not supported yet.
     *
     * @see \Codeception\Module\WebDriver::setCookie()
     * @param $cookie
     * @param $value
     */
    public function setCookie($cookie, $value /*, $params = null, $showDebug = null */): void
    {
        $this->executeJS('Cookies.set("' . $cookie . '", "' . $value . '", { path: "/" })');
    }

    /**
     * Use JavaScript HTMLElement.scrollIntoView() because Geckodriver scrolls beyond normally possible bounds
     */
    public function scrollIntoView(string $cssSelector): void
    {
        $this->executeJS('document.querySelector("' . str_replace('"', '\\"', $cssSelector) . '").scrollIntoView()');
    }

    /**
     * The cookie with all its attributes. grabCookie() only gives the value.
     */
    public function grabCookieWithAttributes(string $name): Cookie
    {
        return $this->executeInSelenium(
            static fn(RemoteWebDriver $webDriver): Cookie => $webDriver->manage()->getCookieNamed($name),
        );
    }

    /**
     * The value that the consent cookie holds for the given groups, with the
     * consentConfigurationVersion that the test instance configures.
     *
     * @param string[] $groupKeys
     */
    public function cookieValueWithVersion(
        array $groupKeys,
        string $version = Constants::CONSENTCONFIGURATIONVERSION,
    ): string {
        return implode(Constants::COOKIE_separator, $groupKeys)
            . ($version === '' ? '' : Constants::COOKIE_versionSeparator . $version);
    }
}
