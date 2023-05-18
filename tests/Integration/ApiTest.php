<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration;

use Http\Mock\Client as MockHttpClient;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Sdk;
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
    public function testGetGatewayManager()
    {
        $sdk = self::getInstance();
        $gatewayManager = $sdk->getGatewayManager();

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $gatewayManager->getGateways();
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testGetIssuerManager()
    {
        $sdk = self::getInstance();
        $issuerManager = $sdk->getIssuerManager();

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Unknown data');
        $issuerManager->getIssuersByGatewayCode('ideal');
    }

    /**
     * @param string $apiKey
     * @return Sdk
     */
    public static function getInstance(string $apiKey = '__valid__'): Sdk
    {
        Version::getInstance()->addPluginVersion('integration-test');
        $mockClient = new MockHttpClient();
        return new Sdk($apiKey, false, $mockClient);
    }
}
