<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\Tests\Unit;

use Dmind\Cookieman\DataProcessing\TypoScriptSettingsProcessor;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypoScriptSettingsProcessorTest extends UnitTestCase
{
    /**
     * @var ContentObjectRenderer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $contentObjectRenderer;

    /**
     * Sets up this testcase
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->contentObjectRenderer = $this->getMockBuilder(ContentObjectRenderer::class)
            ->getMock();
    }

    /**
     * @dataProvider settingsProvider
     * @test
     * @param array $pluginConfiguration
     * @param array $returnedSettings
     */
    public function returnsSettings(array $pluginConfiguration, array $returnedSettings): void
    {
        $configurationManager = $this->getMockBuilder(ConfigurationManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $configurationManager->expects(self::once())->method('getConfiguration')->willReturn(
            $pluginConfiguration
        );

        $subject = $this->getMockBuilder(TypoScriptSettingsProcessor::class)
            ->setConstructorArgs([$configurationManager])
            ->setMethods(['getConfigurationManager']) // setMethods() for PHPUnit 6.5
            ->getMock();

        $result = $subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            ['data' => []]
        );

        self::assertEquals(
            $returnedSettings,
            $result
        );
    }

    public function settingsProvider()
    {
        return [
            [
                [
                    'groups' => [
                        'mandatory' => [
                            'preselected' => 1,
                            'trackingObjects' => [ // unordered object
                                10 => 'fe_typo_user',
                                0 => 'CookieConsent',
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
                [
                    'data' => [],
                    'settings' => [
                        'groups' => [
                            'mandatory' => [
                                'preselected' => 1,
                                'trackingObjects' => [ // ordered list
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
                ],
            ],
        ];
    }
}
