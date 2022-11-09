<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;

class PluginDetailsTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails::getData
     */
    public function testGetData()
    {
        $pluginDetails = new PluginDetails();
        $pluginDetails->addPluginVersion('0.0.1');
        $pluginDetails->addApplicationName('foobar');
        $pluginDetails->addApplicationVersion('0.0.2');
        $pluginDetails->addPartner('Partner Name');
        $pluginDetails->addShopRootUrl('http://example.org/');
        $data = $pluginDetails->getData();
        $this->assertSame(Version::SDK_VERSION, $data['sdk_version']);
        $this->assertSame('0.0.1', $data['plugin_version']);
        $this->assertSame('foobar', $data['shop']);
        $this->assertSame('0.0.2', $data['shop_version']);
        $this->assertSame('http://example.org/', $data['shop_root_url']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails::getData
     */
    public function testInvalidData()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Application name and version can not be empty');
        $pluginDetails = new PluginDetails();
        $pluginDetails->getData();
    }
}
