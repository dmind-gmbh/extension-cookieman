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
    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * insert 'settings' key with plugin settings at rendering time
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
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

        $settings = $this->sanitizeSettings($settings);

        $processedData['settings'] = $settings;

        return $processedData;
    }

    /**
     * Prepare TypoScript for the frontend.
     */
    protected function sanitizeSettings(array $settings)
    {
        foreach (($settings['groups'] ?? []) as $groupId => $group) {
            if (isset($group['preselected'])) {
                $settings['groups'][$groupId]['preselected'] = (bool)$group['preselected'];
            }
            if (isset($group['disabled'])) {
                $settings['groups'][$groupId]['disabled'] = (bool)$group['disabled'];
            }
            if (isset($group['respectDnt'])) {
                $settings['groups'][$groupId]['respectDnt'] = (bool)$group['respectDnt'];
            }
            if (isset($group['showDntMessage'])) {
                $settings['groups'][$groupId]['showDntMessage'] = (bool)$group['showDntMessage'];
            }

            // ignore keys on groups.trackingObjects - this makes sure it does not get output as an object in JSON
            $trackingObjects = $group['trackingObjects'] ?? [];
            // sort to allow using TypoScript-style .20 .10 .40 etc.
            ksort($trackingObjects);
            $settings['groups'][$groupId]['trackingObjects'] = array_values($trackingObjects);
        }

        return $settings;
    }
}
