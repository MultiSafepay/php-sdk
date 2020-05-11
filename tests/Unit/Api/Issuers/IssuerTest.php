<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Api\Issuers\Issuer;
use PHPUnit\Framework\TestCase;

/**
 * Class IssuerTest
 * @package MultiSafepay\Tests\Unit\Api
 */
class IssuerTest extends TestCase
{
    /**
     * Test if normal initialization works
     */
    public function testNormalInitialization()
    {
        $issuer = new Issuer('ideal', 1234, 'bar');
        $this->assertEquals('IDEAL', $issuer->getGatewayCode());
        $this->assertEquals(1234, $issuer->getCode());
        $this->assertEquals('bar', $issuer->getDescription());

        $issuer = new Issuer('IDEAL', 1234, 'bar');
        $this->assertEquals('IDEAL', $issuer->getGatewayCode());
    }

    /**
     * Test if initialization fails if invalid gateway code is used
     */
    public function testInitializationWithWrongGatewayCode()
    {
        $this->expectException(InvalidArgumentException::class);
        new Issuer('wrong', 1234, 'foobar');
    }
}
