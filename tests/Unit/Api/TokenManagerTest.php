<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Api;

use MultiSafepay\Api\TokenManager;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;

/**
 * Class IssuerTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class TokenManagerTest extends TestCase
{
    /**
     * Check if we get the tokens as array
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testGetListOfTokensAsArray()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens');

        $tokens = (new TokenManager($mockClient))->getListByGatewayCodeAsArray('1', 'VISA');

        $this->assertCount(1, $tokens);
        $this->assertIsArray($tokens);
        $this->assertIsArray(reset($tokens));
    }
}
