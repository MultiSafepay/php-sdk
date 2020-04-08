<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit;

use MultiSafepay\Client;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * Class GetGenericTest
 * @package MultiSafepay\Tests\Unit
 */
class GetGenericTest extends AbstractTestCase
{
    /**
     * @throws ClientExceptionInterface
     */
    public function testGetSomethingWithFailure()
    {
        $this->expectException(ApiException::class);

        /** @var ClientInterface $httpClientMock */
        $httpClientMock = $this->getHttpClientMockWithSendRequest('generic-fail');
        $client = new Client('dummy', false, $httpClientMock);
        $client->createGetRequest('gateways');
    }
}
