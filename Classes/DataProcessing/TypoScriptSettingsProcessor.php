<?php

declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\DataProcessing;

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
        array $processedData
    ): array {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'cookieman'
        );

        $settings = $this->sanitizeSettings($settings, $cObj);

        $processedData['settings'] = $settings;

        return $processedData;
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
                = $cObj->cObjGetSingle($trackingObject['inject']['_typoScriptNodeValue'], $trackingObject['inject']);
        }

        return $settings;
    }
}
