<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Integration\Api;

use MultiSafepay\Api\TokenManager;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;

/**
 * Class IssuerTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class TokenManagerTest extends TestCase
{
    /**
     * Check if the function is handled correctly if you try to get the tokens with a reference that has no tokens.
     *
     * @throws ApiException
     */
    public function testGetAllTokenWithNoExistingCustomerReference()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens-empty');


        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1000);
        $this->expectExceptionMessage('Not found');
        (new TokenManager($mockClient))->getList('1');
    }

    /**
     * Check if the data has been successfully imported
     */
    public function testGetAllTokens()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens');

        $tokens = (new TokenManager($mockClient))->getList('1');

        foreach ($tokens as $token) {
            $this->assertNotEmpty($token->getToken());
            $this->assertNotEmpty($token->getGatewayCode());
            $this->assertNotEmpty($token->getDisplay());
            $this->assertNotEmpty($token->getBin());
            $this->assertNotEmpty($token->getNameHolder());
            $this->assertNotEmpty($token->getExpiryDate());
            $this->assertIsBool($token->isExpired());
            $this->assertNotEmpty($token->getLastFour());
            $this->assertNotEmpty($token->getModel());
        }
    }

    /**
     * Check if the data has been successfully imported from a single token.
     */
    public function testGetToken()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens-single');

        $token = (new TokenManager($mockClient))->get('RdLbznU5a_s', '1');
        $this->assertNotEmpty($token->getToken());
        $this->assertNotEmpty($token->getGatewayCode());
        $this->assertNotEmpty($token->getDisplay());
        $this->assertNotEmpty($token->getBin());
        $this->assertNotEmpty($token->getNameHolder());
        $this->assertNotEmpty($token->getExpiryDate());
        $this->assertNotEmpty($token->getExpiryMonth());
        $this->assertNotEmpty($token->getExpiryYear());
        $this->assertIsBool($token->isExpired());
        $this->assertNotEmpty($token->getLastFour());
        $this->assertNotEmpty($token->getModel());
    }

    /**
     * Throw an exception when a customer or a reference could not be found from the get request.
     *
     * @throws ApiException
     */
    public function testGetTokenWithInvalidReferenceOrToken()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens-single-not-found');

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1000);
        $this->expectExceptionMessage('Not found: token');

        (new TokenManager($mockClient))->get('not-found', '1');
    }

    /**
     * Check if the function return true when the token is successfully deleted.
     */
    public function testDeleteWithCorrectToken()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens-delete');

        $this->assertTrue((new TokenManager($mockClient))->delete('RdLbznU5a_s', '1'));
    }

    /**
     * Check if the the function will give an exception if the API request fails
     *
     * @throws ApiException
     */
    public function testDeleteWithInCorrectToken()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens-delete-failed');

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1000);
        $this->expectExceptionMessage('Token not removed');

        (new TokenManager($mockClient))->delete('not-found', '1');
    }

    /**
     * Check if we get all the tokens if they are VISA, MASTERCARD or AMEX.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testGetListWithCreditCardGateway()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens');

        $tokens = (new TokenManager($mockClient))->getListByGatewayCode('1', 'CREDITCARD');

        $this->assertCount(3, $tokens);
    }

    /**
     * Check if we get from all the tokens, only the VISA tokens could be fetched
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testGetListWithVisaGateway()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('tokens');

        $tokens = (new TokenManager($mockClient))->getListByGatewayCode('1', 'VISA');

        $this->assertCount(1, $tokens);

        $token = reset($tokens);
        $this->assertEquals($token->getGatewayCode(), 'VISA');
    }
}
