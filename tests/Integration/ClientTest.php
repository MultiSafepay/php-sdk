<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit;

use Exception;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class ClientTest
 * @package MultiSafepay\Tests\Unit
 */
class ClientTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetSomethingWithFailure()
    {
        $this->expectException(ApiException::class);

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('generic-fail');
        $mockClient->createGetRequest('json/gateways');
    }
}
