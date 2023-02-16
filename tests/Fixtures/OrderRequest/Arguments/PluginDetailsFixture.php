<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;

/**
 * Trait PluginDetailsFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait PluginDetailsFixture
{
    /**
     * @return PluginDetails
     */
    public function createPluginDetailsFixture(): PluginDetails
    {
        return (new PluginDetails())
            ->addApplicationName('PHP-SDK Test Fixtures')
            ->addApplicationVersion('0.0.1');
    }
}
