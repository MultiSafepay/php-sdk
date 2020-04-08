<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit;

use Exception;
use MultiSafepay\Client;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * Class GetGatewaysTest
 * @package MultiSafepay\Tests\Unit
 */
class GetGatewaysTest extends AbstractTestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetGateways()
    {
        $response = $this->getGatewaysData('gateways');

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['data']);
        $this->assertEquals(1, $response['success']);

        foreach ($response['data'] as $gateway) {
            $this->assertIsArray($gateway);
            $this->assertNotEmpty($gateway['id']);
            $this->assertNotEmpty($gateway['description']);
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetGatewaysWithNoData()
    {
        $response = $this->getGatewaysData('gateways-empty');
        $this->assertNotEmpty($response);
        $this->assertEmpty($response['data']);
        $this->assertEquals(1, $response['success']);
    }

    /**
     * @param string $returnId
     * @return array
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    private function getGatewaysData(string $returnId): array
    {
        /** @var ClientInterface $httpClientMock */
        $httpClientMock = $this->getHttpClientMockWithSendRequest($returnId);
        $client = new Client('dummy', false, $httpClientMock);
        return $client->createGetRequest('gateways');
    }
}
