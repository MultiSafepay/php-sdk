<?php
declare(strict_types=1);

namespace MultiSafepay\Test\Unit\Utils;

use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    /**
     * Test for the class instantiation
     */
    public function testGetInstance()
    {
        $instance = Version::getInstance();
        $this->assertNotEmpty($instance->getPluginVersion());
    }

    /**
     * Test for the entire version string
     */
    public function testGetVersion()
    {
        $instance = Version::getInstance();
        $this->assertContains('Plugin ', $instance->getVersion());
        $this->assertContains('PHP-SDK ', $instance->getVersion());
    }

    /**
     * Test for the SDK version
     */
    public function testGetSdkVersion()
    {
        $instance = Version::getInstance();
        $this->assertTrue((bool)preg_match('/([0-9]+)\.([0-9]+)\.([0-9]+)/', $instance->getSdkVersion()));
    }

    /**
     * Test for the plugin version
     */
    public function testGetPluginVersion()
    {
        $instance = Version::getInstance();
        $instance->addPluginVersion('foobar');
        $this->assertContains('foobar', $instance->getPluginVersion());
    }
}
