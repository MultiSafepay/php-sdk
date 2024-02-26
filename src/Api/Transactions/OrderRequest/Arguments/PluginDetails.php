<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Util\Version;

/**
 * Class PluginDetails
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class PluginDetails
{
    /**
     * @var Version
     */
    private $pluginVersion;

    /**
     * @var string
     */
    private $applicationName;

    /**
     * @var string
     */
    private $applicationVersion;

    /**
     * @var string
     */
    private $partner = '';

    /**
     * @var string
     */
    private $shopRootUrl = '';

    /**
     * PluginDetails constructor.
     */
    public function __construct()
    {
        $this->pluginVersion = Version::getInstance();
    }

    /**
     * @param string $applicationVersion
     * @return PluginDetails
     */
    public function addApplicationVersion(string $applicationVersion): PluginDetails
    {
        $this->applicationVersion = $applicationVersion;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApplicationVersion(): ?string
    {
        return $this->applicationVersion;
    }

    /**
     * @param string $applicationName
     * @return PluginDetails
     */
    public function addApplicationName(string $applicationName): PluginDetails
    {
        $this->applicationName = $applicationName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApplicationName(): ?string
    {
        return $this->applicationName;
    }

    /**
     * @param string $pluginVersion
     * @return PluginDetails
     */
    public function addPluginVersion(string $pluginVersion): PluginDetails
    {
        $this->pluginVersion->addPluginVersion($pluginVersion);
        return $this;
    }

    /**
     * @return Version
     */
    public function getPluginVersion(): Version
    {
        return $this->pluginVersion;
    }

    /**
     * @param string $partner
     * @return PluginDetails
     */
    public function addPartner(string $partner): PluginDetails
    {
        $this->partner = $partner;
        return $this;
    }

    /**
     * @param string $shopRootUrl
     * @return PluginDetails
     */
    public function addShopRootUrl(string $shopRootUrl): PluginDetails
    {
        $this->shopRootUrl = $shopRootUrl;
        return $this;
    }

    /**
     * @return string[]
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        $this->validate();

        return [
            'sdk_version' => $this->pluginVersion->getSdkVersion(),
            'plugin_version' => $this->pluginVersion->getPluginVersion(),
            'shop' => $this->applicationName,
            'shop_version' => $this->applicationVersion,
            'partner' => $this->partner,
            'shop_root_url' => $this->shopRootUrl,
        ];
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(): bool
    {
        if (empty($this->applicationVersion) || empty($this->applicationName)) {
            throw new InvalidArgumentException('Application name and version can not be empty');
        }

        if (!$this->pluginVersion instanceof Version) {
            throw new InvalidArgumentException('Plugin version can not be empty');
        }

        return true;
    }
}
