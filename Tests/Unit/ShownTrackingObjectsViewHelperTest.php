<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Unit;

use Dmind\Cookieman\ViewHelpers\ShownTrackingObjectsViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use Prophecy\PhpUnit\ProphecyTrait;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;

class ShownTrackingObjectsViewHelperTest extends UnitTestCase
{
    use ProphecyTrait;

    /**
     * @var ShownTrackingObjectsViewHelper
     */
    protected $viewHelper;

    /**
     * fix type annotation
     * @var MockObject|StandardVariableProvider
     */
    protected $templateVariableContainer;

    /**
     * @dataProvider settingsProvider
     * @test
     * @param array $settings
     * @param array $expected
     */
    public function trackingObjectsByParameter(array $settings, array $expected): void
    {
        $result = ShownTrackingObjectsViewHelper::shownTrackingObjects(
            $settings['groups']['mandatory'],
            $settings
        );

        self::assertSame($expected, $result);
    }

    public function settingsProvider(): array
    {
        $_tests[] = [
            0 => [
                'groups' => [
                    'mandatory' => [
                        'preselected' => 1,
                        'trackingObjects' => [
                            'CookieConsent',
                            'fe_typo_user',
                        ],
                    ],
                ],
                'trackingObjects' => [
                    'CookieConsent' => [
                        'show' => [
                            'CookieConsent' => [
                                'duration' => '1',
                                'durationUnit' => 'year',
                                'type' => 'cookie_http+html',
                                'provider' => 'Website',
                            ],
                        ],
                    ],
                    'fe_typo_user' => [
                        'show' => [
                            'fe_typo_user' => [
                                'duration' => '',
                                'durationUnit' => 'session',
                                'type' => 'cookie_http',
                                'provider' => 'Website',
                            ],
                        ],
                    ],
                    'another' => [ // unused
                        'show' => [
                            'another' => [
                                'duration' => '',
                                'durationUnit' => 'session',
                                'type' => 'cookie_http',
                                'provider' => 'Website',
                            ],
                        ],
                    ],
                ],
            ],
            1 => [
                'CookieConsent' => [
                    'duration' => '1',
                    'durationUnit' => 'year',
                    'type' => 'cookie_http+html',
                    'provider' => 'Website',
                ],
                'fe_typo_user' => [
                    'duration' => '',
                    'durationUnit' => 'session',
                    'type' => 'cookie_http',
                    'provider' => 'Website',
                ],
            ],
        ];

        return $_tests;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->viewHelper = new ShownTrackingObjectsViewHelper();
    }
}
