<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\IpAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class IpAddressTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class IpAddressTest extends TestCase
{
    /**
     * Test whether a valid IPv4 address can could be set and used
     */
    public function testWhetherValueCanBeSetAndUsed()
    {
        $ipAddress = new IpAddress('10.0.0.1');
        $this->assertEquals('10.0.0.1', $ipAddress->get());
    }

    /**
     * Test if the first valid IPv4 address from a comma-separated list can be set and retrieved.
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Forwarded-For#examples
     */
    public function testWhetherCommaSeparatedValuesCanBeSetAndUsed()
    {
        $ipAddress = new IpAddress('203.0.113.195, 70.41.3.18, 150.172.238.178');
        $this->assertEquals('203.0.113.195', $ipAddress->get());
    }

    /**
     * Test if a valid IPv6 address can be set and retrieved.
     */
    public function testWhetherIPv6ValueCanBeSetAndUsed()
    {
        $ipAddress = new IpAddress('2001:0db8:85a3:0000:0000:8a2e:0370:7334');
        $this->assertEquals('2001:0db8:85a3:0000:0000:8a2e:0370:7334', $ipAddress->get());
    }

    /**
     * Test if the first valid IPv6 address from a comma-separated list can be set and retrieved.
     */
    public function testWhetherCommaSeparatedIPv6ValuesCanBeSetAndUsed()
    {
        $ipAddress = new IpAddress('2001:0db8:85a3:0000:0000:8a2e:0370:7334, 2001:0db8:85a3:0000:0000:8a2e:0370:7335');
        $this->assertEquals('2001:0db8:85a3:0000:0000:8a2e:0370:7334', $ipAddress->get());
    }

    /**
     * Test whether a value could be set and used
     */
    public function testWhetherWrongValueCanNotBeSetAndUsed()
    {
        $this->expectException(InvalidArgumentException::class);
        new IpAddress('foobar');
    }
}
