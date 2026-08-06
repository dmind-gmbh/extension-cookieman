<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\DataProcessing;

use Dmind\Cookieman\Middleware\PopupRoute;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class TypoScriptSettingsProcessor implements DataProcessorInterface
{
    public function __construct(protected ConfigurationManager $configurationManager)
    {
    }

    /**
     * insert 'settings' key with plugin settings at rendering time
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData,
    ): array {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'cookieman',
        );

        $settings = $this->sanitizeSettings($settings, $cObj);

        $processedData['settings'] = $settings;
        $processedData['settingsForStub'] = $this->stubSettings($settings);
        $processedData['popupUrl'] = $this->popupUrl($settings, $cObj);

        return $processedData;
    }

    /**
     * The settings that cookieman needs before it loads the popup.
     *
     * They stay in the page, so that the tracking objects of a user who consented before
     * start without a wait for the popup. Everything else only matters when the popup is
     * open, @see \Dmind\Cookieman\Middleware\PopupRoute.
     */
    protected function stubSettings(array $settings): array
    {
        $stub = [
            'cookie' => $settings['cookie'] ?? [],
            'consentConfigurationVersion' => $settings['consentConfigurationVersion'] ?? '',
            'groups' => $settings['groups'] ?? [],
            'trackingObjects' => [],
        ];

        // `inject` only. `show` is a lot of data and only fills the table in the popup.
        foreach (($settings['trackingObjects'] ?? []) as $trackingObjectKey => $trackingObject) {
            if (!isset($trackingObject['inject'])) {
                continue;
            }
            $stub['trackingObjects'][$trackingObjectKey] = ['inject' => $trackingObject['inject']];
        }

        return $stub;
    }

    /**
     * URL of the popup on the root page of the site, in the language of the page.
     *
     * The value of the argument is a hash of the settings. The browser keeps the popup
     * for a long time, and a changed hash makes it load the popup again.
     */
    protected function popupUrl(array $settings, ContentObjectRenderer $cObj): string
    {
        $hash = substr(md5(json_encode($settings, JSON_THROW_ON_ERROR)), 0, 10);

        $language = $cObj->getRequest()->getAttribute('language');
        $base = $language instanceof SiteLanguage ? $language->getBase()->getPath() : '/';

        return rtrim($base, '/') . '/?' . PopupRoute::ARGUMENT . '=' . $hash;
    }

    /**
     * Prepare TypoScript for the frontend.
     */
    protected function sanitizeSettings(array $settings, ContentObjectRenderer $cObj): array
    {
        foreach (($settings['groups'] ?? []) as $groupId => $group) {
            if (isset($group['preselected'])) {
                $settings['groups'][$groupId]['preselected'] = (bool) $group['preselected'];
            }
            if (isset($group['disabled'])) {
                $settings['groups'][$groupId]['disabled'] = (bool) $group['disabled'];
            }
            if (isset($group['respectDnt'])) {
                $settings['groups'][$groupId]['respectDnt'] = (bool) $group['respectDnt'];
            }
            if (isset($group['showDntMessage'])) {
                $settings['groups'][$groupId]['showDntMessage'] = (bool) $group['showDntMessage'];
            }

            $trackingObjects = $group['trackingObjects'] ?? [];
            // sort to allow using TypoScript-style .20 .10 .40 etc.
            ksort($trackingObjects);
            // ignore keys on groups.trackingObjects - this makes sure it does not get output as an object in JSON
            $settings['groups'][$groupId]['trackingObjects'] = array_values($trackingObjects);
        }

        // render `<trackingObjects.‹tracking-object-key›.inject>
        foreach (($settings['trackingObjects'] ?? []) as $trackingObjectKey => $trackingObject) {
            if (!($trackingObject['inject']['_typoScriptNodeValue'] ?? false)) {
                continue;
            }

            $settings['trackingObjects'][$trackingObjectKey]['inject']
                = $this->renderCObject($trackingObject['inject'], $cObj);
        }

        return $settings;
    }

    protected function renderCObject(array $config, ContentObjectRenderer $cObj): string
    {
        $type = $config['_typoScriptNodeValue'] ?? null;
        if (!$type) {
            return '';
        }
        unset($config['_typoScriptNodeValue']);

        if ($type === 'COA') {
            // Bring into "non-Extbasey" TypoScript form to render sub-objects directly
            $config = $this->convertPlainArrayToTypoScriptArray($config);
        }

        return $cObj->cObjGetSingle($type, $config);
    }

    /**
     * Taken from @see \TYPO3\CMS\Core\TypoScript\TypoScriptService::convertPlainArrayToTypoScriptArray
     */
    protected function convertPlainArrayToTypoScriptArray(array $plainArray): array
    {
        $typoScriptArray = [];
        foreach ($plainArray as $key => $value) {
            if (is_array($value)) {
                if (isset($value['_typoScriptNodeValue'])) {
                    $typoScriptArray[$key] = $value['_typoScriptNodeValue'];
                    unset($value['_typoScriptNodeValue']);
                }
                $typoScriptArray[$key . '.'] = $this->convertPlainArrayToTypoScriptArray($value);
            } else {
                $typoScriptArray[$key] = $value ?? '';
            }
        }
        return $typoScriptArray;
    }
}
