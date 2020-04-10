<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api;

use MultiSafepay\Api;
use MultiSafepay\Exception\ApiException;
use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockClient;
use GuzzleHttp\Psr7\Response;

class GatewaysTest extends TestCase
{
    /**
     * Test getting gateways
     */
    public function testGetGateways(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'id' => 'IDEAL',
                    'description' => 'iDEAL'
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $gateways = $multisafepay->gateways()->get();

        $this->assertSame('IDEAL', $gateways->getData()['id']);
    }

    /**
     * Test getting iDEAL gateway
     */
    public function testGetGatewayByName(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'id' => 'IDEAL',
                    'description' => 'iDEAL'
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $gateways = $multisafepay->gateways()->get(' ideal');

        $this->assertSame('IDEAL', $gateways->getData()['id']);
    }

    /**
     * Test getting non existing gateway
     */
    public function testGetNonExistingGateway(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => false,
                'data' => [],
                'error_code' => 1023,
                'error_info' => 'No gateway (payment method) available'
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1023);
        $this->expectExceptionMessage('No gateway (payment method) available');
        $multisafepay->gateways()->get(' __NonExists__');
    }

    /**
     * Test getting allowed gateway 'Mistercash' when country is 'BE'
     */
    public function testGetAllowedGatewayByCountyFilter(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'id' => 'MISTERCASH',
                    'description' => 'Bancontact'
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $gateways = $multisafepay->gateways()->get('mistercash', ['country' => 'BE']);

        $this->assertSame('MISTERCASH', $gateways->getData()['id']);
    }


    /**
     * Test getting non allowed gateway 'Mistercash' when country is 'NL'
     */
    public function testGetNonAllowedGatewayByCountyFilter(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => false,
                'data' => [],
                'error_code' => 1023,
                'error_info' => 'No gateway (payment method) available'
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1023);
        $this->expectExceptionMessage('No gateway (payment method) available');
        $multisafepay->gateways()->get('mistercash', ['country' => 'NL']);
    }


    /**
     * Test getting gateway 'fashioncheque' when all coupons are included
     */
    public function testGiftcartIsAvailableWithIncludeFilter(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => true,
                'data' => [
                    'id' => 'FASHIONCHQ',
                    'description' => 'fashioncheque',
                    'type' => 'coupon'
                ]
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $gateways = $multisafepay->gateways()->get(null, ['include' => 'coupons']);

        $this->assertSame('FASHIONCHQ', $gateways->getData()['id']);
    }

    /**
     * Test getting non available gateway 'fashioncheque' when all coupons are NOT included
     */
    public function testGiftcartIsNotAvailableWithoutIncludeFilter(): void
    {
        $mockClient = new MockClient();
        $mockClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                'success' => false,
                'data' => [],
                'error_code' => 1023,
                'error_info' => 'No gateway (payment method) available'
            ])
        ));

        $multisafepay = new Api('__valid__', false, $mockClient);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1023);
        $this->expectExceptionMessage('No gateway (payment method) available');
        $multisafepay->gateways()->get();
    }
}
