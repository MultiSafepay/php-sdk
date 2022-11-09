<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Gateways;

use MultiSafepay\Api\Issuers\IssuerListing;
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
        $issuerListing = new IssuerListing('ideal', [['code' => '0021', 'description' => 'bar']]);
        $issuers = $issuerListing->getIssuers();
        $this->assertCount(1, $issuers);

        $issuer = array_shift($issuers);
        $this->assertEquals('0021', $issuer->getCode());
        $this->assertEquals('bar', $issuer->getDescription());
    }


    /**
     * Test normal initialization
     */
    public function testListIssuersWhenResponseIsEmpty()
    {
        $issuerListing = new IssuerListing('ideal', []);
        $issuers = $issuerListing->getIssuers();
        $this->assertCount(0, $issuers);
    }
}
