<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration;

use Http\Mock\Client as MockHttpClient;
use MultiSafepay\Api;
use MultiSafepay\Tests\Fixtures\Order;
use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ApiTest
 * @package MultiSafepay\Tests\Integration
 */
class ApiTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     */
    public function testGetTransactionManager()
    {
        $api = self::getInstance();
        $transactionManager = $api->getTransactionManager();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetGatewayManager()
    {
        $api = self::getInstance();
        $gatewayManager = $api->getGatewayManager();
        $gateways = $gatewayManager->getGateways();
        $this->assertIsArray($gateways);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetIssuerManager()
    {
        $api = self::getInstance();
        $issuerManager = $api->getIssuerManager();
        $issuerManager->getIssuersByGatewayCode('ideal');
    }

    /**
     * @param string $apiKey
     * @return Api
     */
    public static function getInstance(string $apiKey = '__valid__'): Api
    {
        Version::getInstance()->addPluginVersion('integration-test');
        $mockClient = new MockHttpClient();
        return new Api($apiKey, false, $mockClient);
    }
}
