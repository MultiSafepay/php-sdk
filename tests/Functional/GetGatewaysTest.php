<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Functional;

use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;

class GetGatewaysTest extends AbstractTestCase
{
    /**
     * @throws ClientExceptionInterface
     */
    public function testGetGateways()
    {
        $response = $this->getClient()->createGetRequest('json/gateways');
        $data = $response->getResponseData();

        foreach ($data as $gateway) {
            $this->assertIsArray($gateway);
            $this->assertNotEmpty($gateway['id']);
            $this->assertNotEmpty($gateway['description']);
        }
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetGatewaysWithWrongPath()
    {
        $this->expectException(ApiException::class);
        $this->getClient()->createGetRequest('json/gateways-wrong');
    }
}
