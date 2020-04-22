<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration;

use Http\Mock\Client as MockHttpClient;
use MultiSafepay\Api;
use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Transactions\RequestOrder;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\Order;
use MultiSafepay\Tests\Fixtures\OrderFixture;
use MultiSafepay\Util\Version;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ApiTest
 * @package MultiSafepay\Tests\Integration
 */
class ApiTest extends TestCase
{
    use OrderFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetGatewayManager()
    {
        $api = self::getInstance();
        $gatewayManager = $api->getGatewayManager();

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $gatewayManager->getGateways();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetIssuerManager()
    {
        $api = self::getInstance();
        $issuerManager = $api->getIssuerManager();

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
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
