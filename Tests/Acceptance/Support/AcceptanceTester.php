<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Support;

use Dmind\Cookieman\Tests\Acceptance\Support\_generated\AcceptanceTesterActions;

/**
 * Default acceptance tester
 */
class AcceptanceTester extends \Codeception\Actor
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
}
