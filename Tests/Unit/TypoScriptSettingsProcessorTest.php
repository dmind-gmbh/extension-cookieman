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
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
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
     * @test
     */
    public function returnsSettings()
    {
        $configurationManager = $this->getMockBuilder(ConfigurationManagerInterface::class)->getMockForAbstractClass();
        $configurationManager->expects(self::once())->method('getConfiguration')->willReturn(
            [
                'settings' => [
                    'groups' => [
                        'mandatory' => [
                            'preselected' => 1,
                        ],
                    ],
                ]
            ]
        );

        $subject = $this->getMockBuilder(TypoScriptSettingsProcessor::class)
            ->setMethods(['getConfigurationManager']) // setMethods() for PHPUnit 6.5
            ->setMockClassName('ConfigurationManagerInterface')->getMock();
        $subject->expects(self::once())->method('getConfigurationManager')->willReturn($configurationManager);

        $result = $subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            ['data' => []]
        );

        self::assertEquals(
            [
                'data' => [],
                'settings' => [
                    'settings' => [
                        'groups' => [
                            'mandatory' => [
                                'preselected' => 1,
                            ],
                        ],
                    ],
                ],
            ],
            $result
        );
    }
}
