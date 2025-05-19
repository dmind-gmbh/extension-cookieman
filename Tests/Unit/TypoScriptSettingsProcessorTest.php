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
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\Container;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\CaseContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectArrayContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectArrayInternalContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectFactory;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\FilesContentObject;
use TYPO3\CMS\Frontend\ContentObject\FluidTemplateContentObject;
use TYPO3\CMS\Frontend\ContentObject\HierarchicalMenuContentObject;
use TYPO3\CMS\Frontend\ContentObject\ImageContentObject;
use TYPO3\CMS\Frontend\ContentObject\ImageResourceContentObject;
use TYPO3\CMS\Frontend\ContentObject\LoadRegisterContentObject;
use TYPO3\CMS\Frontend\ContentObject\RecordsContentObject;
use TYPO3\CMS\Frontend\ContentObject\RestoreRegisterContentObject;
use TYPO3\CMS\Frontend\ContentObject\ScalableVectorGraphicsContentObject;
use TYPO3\CMS\Frontend\ContentObject\TextContentObject;
use TYPO3\CMS\Frontend\ContentObject\UserContentObject;
use TYPO3\CMS\Frontend\ContentObject\UserInternalContentObject;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypoScriptSettingsProcessorTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;
    protected ContentObjectRenderer|MockObject $contentObjectRenderer;
    /**
     * Default content object name -> class name map, shipped with TYPO3 CMS
     */
    private array $contentObjectMap = [
        'TEXT' => TextContentObject::class,
        'CASE' => CaseContentObject::class,
        'COBJ_ARRAY' => ContentObjectArrayContentObject::class,
        'COA' => ContentObjectArrayContentObject::class,
        'COA_INT' => ContentObjectArrayInternalContentObject::class,
        'USER' => UserContentObject::class,
        'USER_INT' => UserInternalContentObject::class,
        'FILES' => FilesContentObject::class,
        'IMAGE' => ImageContentObject::class,
        'IMG_RESOURCE' => ImageResourceContentObject::class,
        'CONTENT' => ContentContentObject::class,
        'RECORDS' => RecordsContentObject::class,
        'HMENU' => HierarchicalMenuContentObject::class,
        'CASEFUNC' => CaseContentObject::class,
        'LOAD_REGISTER' => LoadRegisterContentObject::class,
        'RESTORE_REGISTER' => RestoreRegisterContentObject::class,
        'FLUIDTEMPLATE' => FluidTemplateContentObject::class,
        'SVG' => ScalableVectorGraphicsContentObject::class,
    ];

    public static function settingsProvider(): array
    {
        return [
            [
                [
                    'groups' => [
                        'mandatory' => [
                            'preselected' => '1',
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
                                // plain text
                                'simpleTextInject',
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
                            'inject' => [
                                // simple TEXT
                                '_typoScriptNodeValue' => 'TEXT',
                                'insertData' => 1,
                                'value' => '{date : Y}',
                                'wrap' => 'year:|',
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
                            'inject' => [
                                // (recursive) COA
                                '_typoScriptNodeValue' => 'COA',
                                'wrap' => 'outer COA:|',
                                10 => [
                                    '_typoScriptNodeValue' => 'TEXT',
                                    'insertData' => 1,
                                    'value' => '{date : Y}',
                                ],
                                20 => [
                                    // COA
                                    '_typoScriptNodeValue' => 'COA',
                                    'wrap' => ';inner COA:|',
                                    10 => [
                                        '_typoScriptNodeValue' => 'TEXT',
                                        'data' => 'date : Y',
                                    ],
                                    20 => [
                                        '_typoScriptNodeValue' => 'TEXT',
                                        'data' => 'path : fileadmin/file.ext',
                                        'wrap' => ',|',
                                    ],
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
                                    'simpleTextInject',
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
                                'inject' => 'year:' . date('Y'),
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
                                'inject' => 'outer COA:2025;inner COA:2025,fileadmin/file.ext',
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
        $GLOBALS['SIM_ACCESS_TIME'] = 1534278180;
        $frontendControllerMock =
            $this->getAccessibleMock(
                TypoScriptFrontendController::class,
                ['sL'],
                [],
                '',
                false
            );
        $frontendControllerMock->_set('context', new Context());
        $frontendControllerMock->config = [];

        $cacheManagerMock = $this->getMockBuilder(CacheManager::class)->disableOriginalConstructor()->getMock();
        GeneralUtility::setSingletonInstance(CacheManager::class, $cacheManagerMock);

        $this->contentObjectRenderer = $this->getAccessibleMock(
            ContentObjectRenderer::class,
            ['getResourceFactory', 'getEnvironmentVariable'],
            [$frontendControllerMock]
        );

        $logger = new NullLogger();
        $this->contentObjectRenderer->setLogger($logger);
        $request = new ServerRequest();
        $this->contentObjectRenderer->setRequest($request);

        $contentObjectFactoryMock = $this->createContentObjectFactoryMock();
        $cObj = $this->contentObjectRenderer;
        foreach ($this->contentObjectMap as $name => $className) {
            $contentObjectFactoryMock->addGetContentObjectCallback($name, $className, $request, $cObj);
        }
        $container = new Container();
        $container->set(ContentObjectFactory::class, $contentObjectFactoryMock);
        $container->set(EventDispatcherInterface::class, new NoopEventDispatcher());
        GeneralUtility::setContainer($container);

        $this->contentObjectRenderer->start([], 'tt_content');
    }

    private function createContentObjectFactoryMock(): ContentObjectFactory
    {
        return new class (new Container()) extends ContentObjectFactory {
            /**
             * @var array<string, callable>
             */
            private array $getContentObjectCallbacks = [];

            public function getContentObject(
                string $name,
                ServerRequestInterface $request,
                ContentObjectRenderer $contentObjectRenderer
            ): ?AbstractContentObject {
                if (is_callable($this->getContentObjectCallbacks[$name] ?? null)) {
                    return $this->getContentObjectCallbacks[$name]();
                }
                return null;
            }

            /**
             * @internal This method is just for testing purpose.
             */
            public function addGetContentObjectCallback(
                string $name,
                string $className,
                ServerRequestInterface $request,
                ContentObjectRenderer $cObj
            ): void {
                $this->getContentObjectCallbacks[$name] = static function() use ($className, $request, $cObj) {
                    $contentObject = new $className();
                    $contentObject->setRequest($request);
                    $contentObject->setContentObjectRenderer($cObj);
                    return $contentObject;
                };
            }
        };
    }
}
