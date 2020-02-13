<?php
declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Support;

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
    * @param $name
    * @param $val
    * //@param array $params
    *
    * @return mixed
    * @see \Codeception\Module\WebDriver::setCookie()
    */
    public function setCookie($cookie, $value /*, $params = null, $showDebug = null */)
    {
        $this->executeJS('Cookies.set("' . $cookie . '", "' . $value . '", { path: "/" })');
    }
}
