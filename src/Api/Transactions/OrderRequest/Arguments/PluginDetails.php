<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Util\Version;

/**
 * Class PluginDetails
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
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
     * @param string $applicationName
     * @param string $applicationVersion
     */
    public function __construct(
        string $applicationName,
        string $applicationVersion
    ) {
        $this->pluginVersion = new Version();
        $this->applicationName = $applicationName;
        $this->applicationVersion = $applicationVersion;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'sdk_version' => $this->pluginVersion->getSdkVersion(),
            'plugin_version' => $this->pluginVersion->getPluginVersion(),
            'shop' => $this->applicationName,
            'shop_version' => $this->applicationVersion,
            'partner' => $this->partner,
            'shop_root_url' => $this->shopRootUrl
        ];
    }

    /**
     * @param string $partner
     */
    public function addPartner(string $partner): void
    {
        $this->partner = $partner;
    }

    /**
     * @param string $shopRootUrl
     */
    public function addShopRootUrl(string $shopRootUrl): void
    {
        $this->shopRootUrl = $shopRootUrl;
    }
}
