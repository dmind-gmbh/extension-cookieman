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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypoScriptSettingsProcessorTest extends UnitTestCase
{
    protected ContentObjectRenderer|MockObject $contentObjectRenderer;

    public static function settingsProvider(): array
    {
        return [
            [
                [
                    'groups' => [
                        'mandatory' => [
                            'preselected' => '1', // all numbers come as strings from TypoScript
                            'disabled' => '1',
                            'respectDnt' => '0',
                            'showDntMessage' => '0',
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
                            'inject' => [
                                '<script>simpleTextInject</script>'
                            ]
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
                                'preselected' => true,
                                'disabled' => true,
                                'respectDnt' => false,
                                'showDntMessage' => false,
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
                                'inject' => [
                                    '<script>simpleTextInject</script>'
                                ]
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

    /**
     * @param array $pluginConfiguration
     * @param array $returnedSettings
     */
    #[DataProvider('settingsProvider')]
    #[Test]
    public function returnsSettings(array $pluginConfiguration, array $returnedSettings): void
    {
        $configurationManager = $this->getMockBuilder(ConfigurationManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $configurationManager->expects(self::once())->method('getConfiguration')->willReturn(
            $pluginConfiguration
        );

        $subject = new TypoScriptSettingsProcessor($configurationManager);

        $result = $subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            ['data' => []]
        );

        self::assertSame(
            $returnedSettings,
            $result
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->contentObjectRenderer = $this->getMockBuilder(ContentObjectRenderer::class)
            ->getMock();
    }
}
