<?php
declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Acceptance\Driver;

class BrowserStackLocalWebDriver extends \Codeception\Module\WebDriver
{
    /**
     * @var \BrowserStack\Local
     */
    private $bs_local;

    /**
     * @throws \Exception
     */
    public function _initialize()
    {
        // kill if it was not properly shot down from an earlier run
        system('killall BrowserStackLocal 2> /dev/null');

        // set from env
        $this->config['capabilities']['browserstack.user'] = getenv('BROWSERSTACK_USERNAME');
        $this->config['capabilities']['browserstack.key'] = getenv('BROWSERSTACK_ACCESS_KEY');
        if (
            !$this->config['capabilities']['browserstack.user']
            || !$this->config['capabilities']['browserstack.key']
        ) {
            throw new \Exception(
                'Environment variables BROWSERSTACK_USERNAME or BROWSERSTACK_ACCESS_KEY not found'
            );
        }

        if (
            array_key_exists('browserstack.local', $this->config['capabilities'])
            && $this->config['capabilities']['browserstack.local']
        ) {
            $bs_local_args = ['key' => $this->config['capabilities']['browserstack.key']];
            $this->bs_local = new \BrowserStack\Local();
            $this->bs_local->start($bs_local_args);
        }

        parent::_initialize();
    }

    public function _afterSuite()
    {
        parent::_afterSuite();
        if ($this->bs_local) {
            $this->bs_local->stop();
        }
    }
}
