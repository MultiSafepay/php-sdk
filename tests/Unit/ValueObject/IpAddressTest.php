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
     * Test whether a value could be set and used
     */
    public function testWhetherValueCanBeSetAndUsed()
    {
        $ipAddress = new IpAddress('10.0.0.1');
        $this->assertEquals('10.0.0.1', $ipAddress->get());
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
