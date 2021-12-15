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
use TYPO3\TestingFramework\Fluid\Unit\ViewHelpers\ViewHelperBaseTestcase;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;

class ShownTrackingObjectsViewHelperTest extends ViewHelperBaseTestcase
{
    /**
     * @var ShownTrackingObjectsViewHelper
     */
    protected $viewHelper;

    /**
     * fix type annotation
     * @var MockObject|StandardVariableProvider
     */
    protected $templateVariableContainer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->viewHelper = new ShownTrackingObjectsViewHelper();
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
    }

    /**
     * @dataProvider settingsProvider
     * @test
     * @param array $settings
     * @param array $expected
     */
    public function trackingObjectsByParameter(array $settings, array $expected): void
    {
        $this->templateVariableContainer->expects(self::once())
            ->method('get')->with('settings')
            ->willReturn(
                $settings
            );
        $this->renderingContext->injectViewHelperVariableContainer($this->viewHelperVariableContainer->reveal());

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                'group' => $settings['groups']['mandatory'],
            ]
        );
        $actual = $this->viewHelper->initializeArgumentsAndRender();

        self::assertEquals($expected, $actual);
    }

    /**
     * @dataProvider settingsProvider
     * @test
     * @param array $settings
     * @param array $expected
     */
    public function trackingObjectsByChildren(array $settings, array $expected)
    {
        $this->templateVariableContainer->expects(self::once())
            ->method('get')->with('settings')
            ->willReturn(
                $settings
            );
        $this->renderingContext->injectViewHelperVariableContainer($this->viewHelperVariableContainer->reveal());

        $this->viewHelper->setRenderChildrenClosure(
            function () use ($settings) {
                return $settings['groups']['mandatory'];
            }
        );

        $this->setArgumentsUnderTest(
            $this->viewHelper,
            [
                'group' => $settings['groups']['mandatory'],
            ]
        );
        $actual = $this->viewHelper->initializeArgumentsAndRender();

        self::assertEquals($expected, $actual);
    }

    public function settingsProvider()
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
}
