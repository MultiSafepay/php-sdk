<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\ValueObject;

use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\Customer\IpAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package MultiSafepay\Tests\Unit\ValueObject
 */
class CustomerTest extends TestCase
{
    /**
     * Test whether basic values can be set
     */
    public function testAddThings()
    {
        $customer = new Customer();
        $customer->changeIpAddress(new IpAddress('127.0.0.1'));
        $this->assertEquals('127.0.0.1', $customer->getIpAddress()->get());
    }
}
