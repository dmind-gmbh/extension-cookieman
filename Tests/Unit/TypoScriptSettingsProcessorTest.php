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
use Symfony\Component\DependencyInjection\Container;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\SystemResource\Publishing\SystemResourcePublisherInterface;
use TYPO3\CMS\Core\SystemResource\SystemResourceFactory;
use TYPO3\CMS\Core\SystemResource\Type\PublicResourceInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
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
use TYPO3\CMS\Frontend\Page\PageInformation;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypoScriptSettingsProcessorTest extends UnitTestCase
{
    protected bool $resetSingletonInstances = true;
    protected ContentObjectRenderer|MockObject $contentObjectRenderer;
    protected ContentObjectFactory $contentObjectFactory;
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
        $year = '2018';
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
                                'inject' => 'year:' . $year,
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
                                'inject' => 'outer COA:' . $year . ';inner COA:' . $year . ',fileadmin/file.ext',
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
            $pluginConfiguration,
        );

        /** @var TypoScriptSettingsProcessor|MockObject $subject */
        $subject = $this->getMockBuilder(TypoScriptSettingsProcessor::class)
            ->setConstructorArgs([$configurationManager])
            ->onlyMethods([])
            ->getMock();

        $this->contentObjectRenderer->method('stdWrapValue')->willReturnCallback(
            function($key, $config, $defaultValue = '') {
                if (isset($config[$key])) {
                    if (!isset($config[$key . '.'])) {
                        return $config[$key];
                    }
                } elseif (isset($config[$key . '.'])) {
                    $config[$key] = '';
                } else {
                    return $defaultValue;
                }
                return $this->contentObjectRenderer->stdWrap($config[$key], $config[$key . '.'] ?? []);
            },
        );

        $result = $subject->process(
            $this->contentObjectRenderer,
            [],
            [],
            ['data' => []],
        );

        self::assertSame(
            $returnedSettings,
            $result,
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        // 2018-08-14
        $GLOBALS['SIM_ACCESS_TIME'] = 1534278180;
        $GLOBALS['EXEC_TIME'] = 1534278180;

        $this->contentObjectRenderer = $this->getMockBuilder(
            ContentObjectRenderer::class,
        )
            ->disableOriginalConstructor()
            ->getMock();

        $ref = new \ReflectionProperty(ContentObjectRenderer::class, 'eventDispatcher');
        $ref->setValue($this->contentObjectRenderer, new NoopEventDispatcher());

        // AI has slopped me some hardcore stubbing here. Would be nice to somehow just use
        // ContentObjectRenderer->cObjGetSingle() here somehow to test if the TypoScript config gets really
        // rendered as we expect it.

        $systemResourceFactory = $this->getMockBuilder(SystemResourceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $systemResourcePublisher = $this->createMock(SystemResourcePublisherInterface::class);

        $ref = new \ReflectionProperty(ContentObjectRenderer::class, 'systemResourceFactory');
        $ref->setValue($this->contentObjectRenderer, $systemResourceFactory);
        $ref = new \ReflectionProperty(ContentObjectRenderer::class, 'systemResourcePublisher');
        $ref->setValue($this->contentObjectRenderer, $systemResourcePublisher);

        $systemResourceFactory->method('createPublicResource')->willReturnCallback(function($key) {
            $resource = $this->createMock(PublicResourceInterface::class);
            $resource->method('getResourceIdentifier')->willReturn($key);
            $resource->method('__toString')->willReturn($key);
            return $resource;
        });
        $systemResourcePublisher->method('generateUri')->willReturnCallback(
            fn($resource) => new Uri($resource->getResourceIdentifier()),
        );

        $request = new ServerRequest();
        $pageInformation = new PageInformation();
        $pageInformation->setId(1);
        $pageInformation->setPageRecord(['uid' => 1]);
        $request = $request->withAttribute('frontend.page.information', $pageInformation);
        $this->contentObjectRenderer->method('getRequest')->willReturn($request);
        $this->contentObjectRenderer->setRequest($request);

        $this->contentObjectFactory = $this->createContentObjectFactoryMock();

        $cObjMock = $this->contentObjectRenderer;
        foreach ($this->contentObjectMap as $name => $className) {
            $this->contentObjectFactory->addGetContentObjectCallback($name, $className, $request, $cObjMock);
        }

        // Stub cObjGet for COA
        $this->contentObjectRenderer->method('cObjGet')->willReturnCallback(
            function(array $setup) {
                $content = '';
                foreach (ArrayUtility::filterAndSortByNumericKeys($setup) as $key) {
                    $content .= $this->contentObjectRenderer->cObjGetSingle(
                        (string) $setup[$key],
                        $setup[$key . '.'] ?? [],
                    );
                }
                return $content;
            },
        );

        // Stub getData using the real upstream method
        $this->contentObjectRenderer->method('getData')->willReturnCallback(
            function(string $key, $fieldArray = null) {
                $ref = new \ReflectionMethod(ContentObjectRenderer::class, 'getData');
                return $ref->invoke($this->contentObjectRenderer, $key, $fieldArray);
            },
        );

        // Stub insertData for common patterns
        $this->contentObjectRenderer->method('insertData')->willReturnCallback(
            fn(string $content) => preg_replace_callback(
                '/\{([^}]+)\}/',
                fn($matches) => $this->contentObjectRenderer->getData($matches[1]),
                $content,
            ),
        );

        // Stub wrap for general use
        $this->contentObjectRenderer->method('wrap')->willReturnCallback(
            function($content, $wrap) {
                if ($wrap) {
                    $parts = explode('|', (string) $wrap);
                    return ($parts[0] ?? '') . $content . ($parts[1] ?? '');
                }
                return (string) $content;
            },
        );

        // Stub stdWrap more generally
        $this->contentObjectRenderer->method('stdWrap')->willReturnCallback(
            function($content, $conf) {
                $content = (string) $content;
                if (isset($conf['data'])) {
                    $content = $this->contentObjectRenderer->getData($conf['data']);
                }
                if ($conf['insertData'] ?? false) {
                    $content = $this->contentObjectRenderer->insertData($content);
                }
                if (isset($conf['wrap'])) {
                    $content = $this->contentObjectRenderer->wrap($content, $conf['wrap']);
                }
                return (string) $content;
            },
        );

        $this->contentObjectRenderer->method('cObjGetSingle')->willReturnCallback(
            function(string $name, array $conf) {
                $contentObject = $this->contentObjectFactory->getContentObject(
                    $name,
                    $this->contentObjectRenderer->getRequest(),
                    $this->contentObjectRenderer,
                );
                if ($contentObject instanceof AbstractContentObject) {
                    return $contentObject->render($conf);
                }
                return '';
            },
        );

        $container = new Container();
        $container->set(ContentObjectFactory::class, $this->contentObjectFactory);
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
                ContentObjectRenderer $contentObjectRenderer,
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
                ContentObjectRenderer $cObj,
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
