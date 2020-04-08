<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Model\Unit;

use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Model\Version;
use MultiSafepay\Tests\Fixtures\Order;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    use Order;

    /**
     * Test if the function correctly appends the SDK version in the plugin data
     */
    public function testVersionAppendWithPluginData(): void
    {
        $orderData = $this->createOrder();
        $newOrderData = Version::append($orderData);

        $expected = '1.6.4 - PHP SDK '. Version::SDK_VERSION;

        $actual = $newOrderData['plugin']['plugin_version'];

        $this->assertEquals($expected, $actual);
    }
}
