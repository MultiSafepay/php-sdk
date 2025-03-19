<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Util;

use MultiSafepay\Exception\MissingPluginVersionException;
use RuntimeException;

/**
 * Class Version
 * @package MultiSafepay\Model
 *
 * Make sure a plugin calls upon Version::getInstance()->addPluginVersion() to initialize its own version properly.
 */
class Version
{
    public const SDK_VERSION = '5.16.0';

    /**
     * @var Version
     */
    private static $instance;

    /**
     * @var string
     */
    private $pluginVersion = 'unknown';

    /**
     * @var string
     */
    private $sdkVersion = 'unknown';

    /**
     * @return Version|null
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Version();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if ($this->getPluginVersion() === 'unknown') {
            throw new MissingPluginVersionException('Plugin version is missing');
        }

        return 'Plugin ' . $this->getPluginVersion() . '; PHP-SDK ' . $this->getSdkVersion();
    }

    /**
     * @return string
     */
    public function getSdkVersion(): string
    {
        $this->sdkVersion = $this->detectSdkVersion();
        return $this->sdkVersion;
    }

    /**
     * @return string
     */
    public function getPluginVersion(): string
    {
        return $this->pluginVersion;
    }

    /**
     * @param string $pluginVersion
     */
    public function addPluginVersion(string $pluginVersion)
    {
        $this->pluginVersion = $pluginVersion;
    }

    /**
     * @return string
     */
    private function detectSdkVersion(): string
    {
        $composerFile = __DIR__ . '/../../composer.json';
        if (!file_exists($composerFile)) {
            throw new RuntimeException('Composer file "' . $composerFile . '" is missing');
        }

        $composerContents = file_get_contents($composerFile);
        if (empty($composerContents)) {
            throw new RuntimeException('Could not read file "' . $composerFile . '"');
        }

        $composerData = json_decode($composerContents, true);
        if (isset($composerData['version'])) {
            $this->sdkVersion = $composerData['version'];
        }

        return self::SDK_VERSION;
    }
}
