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
        $issuer = new Issuer('ideal', '0021', 'bar');
        $this->assertEquals('IDEAL', $issuer->getGatewayCode());
        $this->assertEquals('0021', $issuer->getCode());
        $this->assertEquals('bar', $issuer->getDescription());

        $issuer = new Issuer('IDEAL', '0021', 'bar');
        $this->assertEquals('IDEAL', $issuer->getGatewayCode());
    }

    /**
     * Test if initialization fails if invalid gateway code is used
     */
    public function testInitializationWithInvalidGatewayCode()
    {
        $this->expectException(InvalidArgumentException::class);
        new Issuer('wrong', '0021', 'foobar');
    }
}
