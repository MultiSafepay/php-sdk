<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Model\Unit;

use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Util\Version;
use MultiSafepay\Tests\Fixtures\Order;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    use Order;

    /**
     * Test whether the version could be fetched
     */
    public function testGetVersion(): void
    {
        $version = Version::getInstance();
        $this->assertNotEmpty($version->getVersion());
    }

    /**
     * Test whether the SDK version could be fetched
     */
    public function testGetSdkVersion(): void
    {
        $version = Version::getInstance();
        $this->assertNotEmpty($version->getSdkVersion());
    }

    /**
     * Test whether the plugin version can be set and retrieved again
     */
    public function testGetAndSetSdkVersion(): void
    {
        $version = Version::getInstance();
        $version->addPluginVersion('0.0.1');
        $this->assertEquals('0.0.1', $version->getPluginVersion());

        $newVersion = Version::getInstance();
        $this->assertEquals('0.0.1', $newVersion->getPluginVersion());
    }
}
