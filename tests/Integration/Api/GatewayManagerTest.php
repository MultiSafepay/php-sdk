<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Integration\Api;

use Exception;
use MultiSafepay\Api\GatewayManager;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class GatewaysTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class GatewayManagerTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAll()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('gateways');

        $gateways = new GatewayManager($mockClient);
        $gateways = $gateways->getAll();

        $this->assertNotEmpty($gateways);
        foreach ($gateways as $gateway) {
            $this->assertIsArray($gateway);
            $this->assertNotEmpty($gateway['id']);
            $this->assertNotEmpty($gateway['description']);
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

        $gateways = new GatewayManager($mockClient);
        $gateways = $gateways->getAll();

        $this->assertEmpty($gateways);
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

        $gateways = new GatewayManager($mockClient);
        $gateway = $gateways->getByCode('IDEAL');

        $this->assertNotEmpty($gateway);
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

        $gateways = new GatewayManager($mockClient);
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

        $gateways = new GatewayManager($mockClient);
        $gateway = $gateways->getByCode('MISTERCASH', ['country' => 'BE']);

        $this->assertNotEmpty($gateway);
    }
}
