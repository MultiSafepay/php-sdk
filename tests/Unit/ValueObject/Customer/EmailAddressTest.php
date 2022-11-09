<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\ValueObject\Customer;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailAddressTest
 * @package MultiSafepay\Tests\Unit\ValueObject\Customer
 */
class EmailAddressTest extends TestCase
{
    /**
     * Test whether a value could be set and used
     */
    public function testWhetherValueCanBeSetAndUsed()
    {
        $emailAddress = new EmailAddress('info@example.org');
        $this->assertEquals('info@example.org', $emailAddress->get());
    }

    /**
     * Test whether a value could be set and used
     */
    public function testWhetherWrongValueCanNotBeSetAndUsed()
    {
        $this->expectException(InvalidArgumentException::class);
        new EmailAddress('foobar');
    }
}
