<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Integration\Api;

use Exception;
use MultiSafepay\Api\Gateways;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GatewaysTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class GatewaysTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAll()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('gateways');

        $gateways = new Gateways($mockClient);
        $gateways = $gateways->getGateways();

        $this->assertNotEmpty($gateways);
        foreach ($gateways as $gateway) {
            $this->assertInstanceOf(Gateways\Gateway::class, $gateway);
            $this->assertNotEmpty($gateway->getId());
            $this->assertNotEmpty($gateway->getDescription());
            //$this->assertNotContains('type', $gateway->getData()); // @todo
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllWithNoData()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('gateways-empty');

        $gateways = new Gateways($mockClient);
        $gateways = $gateways->getGateways();

        $this->assertEquals(0, count($gateways->getGateways()));
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllWithCoupons()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('gateways-with-coupons');

        $gateways = new Gateways($mockClient);
        $gateways = $gateways->getGateways();

        $couponFound = false;
        foreach ($gateways->getGateways() as $gateway) {
            if ($gateway->getType() === 'coupon') {
                $couponFound = true;
            }
        }

        $this->assertTrue($couponFound);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetSpecific()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'id' => 'IDEAL',
            'description' => 'iDEAL'
        ]);

        $gateways = new Gateways($mockClient);
        $gateway = $gateways->getByCode('IDEAL');

        $this->assertEquals('IDEAL', $gateway->getId());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetByCodeWithWrongCode()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([], false, 1023, 'No gateway (payment method) available');

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1023);
        $this->expectExceptionMessage('No gateway (payment method) available');

        $gateways = new Gateways($mockClient);
        $gateways->getByCode('IDEAL');
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetSpecificByCountyFilter()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([
            'id' => 'MISTERCASH',
            'description' => 'Bancontact'
        ]);

        $gateways = new Gateways($mockClient);
        $gateway = $gateways->getByCode('MISTERCASH', ['country' => 'BE']);
        $this->assertEquals('MISTERCASH', $gateway->getId());
    }
}
