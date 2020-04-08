<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional;

use MultiSafepay\Exception\ApiException;

class GetGatewaysTest extends AbstractTestCase
{
    public function testGetGateways()
    {
        $response = $this->getClient()->createGetRequest('gateways');
        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['data']);
        $this->assertEquals(1, $response['success']);

        foreach ($response['data'] as $gateway) {
            $this->assertIsArray($gateway);
            $this->assertNotEmpty($gateway['id']);
            $this->assertNotEmpty($gateway['description']);
        }
    }

    public function testGetGatewaysWithWrongPath()
    {
        $this->expectException(ApiException::class);
        $this->getClient()->createGetRequest('gateways-wrong');
    }
}
