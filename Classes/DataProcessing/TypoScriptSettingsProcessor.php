<?php
declare(strict_types=1);

/*
 * This file is part of the package dmind/cookieman.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Dmind\Cookieman\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class TypoScriptSettingsProcessor implements DataProcessorInterface
{
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
        $configurationManager = $this->getConfigurationManager();
        $settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'cookieman'
        );

        $settings = $this->sanitizeSettings($settings);

        $processedData['settings'] = $settings;

        return $processedData;
    }

    /**
     * @return ConfigurationManagerInterface
     */
    protected function getConfigurationManager(): ConfigurationManagerInterface
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get(ConfigurationManager::class);
    }

    /**
     * @param array $settings
     * @return array
     */
    protected function sanitizeSettings(array $settings)
    {
        // ignore keys on groups.trackingObjects - this makes sure it does not get output as an object in JSON
        foreach (($settings['groups'] ?? []) as $groupId => $group) {
            $trackingObjects = $group['trackingObjects'] ?? [];
            // sort to allow using TypoScript-style .20 .10 .40 etc.
            ksort($trackingObjects);
            $settings['groups'][$groupId]['trackingObjects'] = array_values($trackingObjects);
        }

        return $settings;
    }
}
