<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Gateways;

use MultiSafepay\Api\Gateways\GatewayListing;
use PHPUnit\Framework\TestCase;

/**
 * Class GatewayListingTest
 * @package MultiSafepay\Tests\Unit\Api\Gateways
 */
class GatewayListingTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testGetGateways()
    {
        $gatewayListing = new GatewayListing([['id' => 'IDEAL', 'description' => 'iDEAL']]);
        $gateways = $gatewayListing->getGateways();
        $this->assertEquals(1, count($gateways));

        $gateway = array_shift($gateways);
        $this->assertEquals('IDEAL', $gateway->getId());
        $this->assertEquals('iDEAL', $gateway->getDescription());
    }
}
