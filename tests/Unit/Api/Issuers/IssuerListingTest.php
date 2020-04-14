<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Gateways;

use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Gateways\GatewayListing;
use MultiSafepay\Api\Issuers\IssuerListing;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use PHPUnit\Framework\TestCase;

/**
 * Class IssuerListingTest
 * @package MultiSafepay\Tests\Unit\Api\Gateways
 */
class IssuerListingTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testGetIssuers()
    {
        $issuerListing = new IssuerListing('ideal', [['code' => 1234, 'description' => 'bar']]);
        $issuers = $issuerListing->getIssuers();
        $this->assertEquals(1, count($issuers));

        $issuer = array_shift($issuers);
        $this->assertEquals(1234, $issuer->getCode());
        $this->assertEquals('bar', $issuer->getDescription());
    }
}
