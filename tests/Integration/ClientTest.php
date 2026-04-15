<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit;

use Exception;
use MultiSafepay\Api\Base\RequestBodyInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\ApiUnavailableException;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpClient\MockHttpClient;

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

    /**
     * @return void
     * @throws ApiException
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     * @throws ApiUnavailableException
     */
    public function testCreatePostRequestWithNullBodySendsRequestWithoutBody(): void
    {
        $mockClient = MockClient::getInstance();

        $mockClient->mockResponse(['ok' => true]);
        $mockClient->createPostRequest('json/gateways', null);

        /** @var MockHttpClient $httpClient */
        $httpClient = $mockClient->getHttpClient();
        $requests = $httpClient->getRequests();

        $this->assertCount(1, $requests);

        $request = $requests[0];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('', (string) $request->getBody(), 'Expected empty request body when passing null');
    }

    /**
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function testCreatePatchRequestWithNullBodySendsRequestWithoutBody(): void
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse(['ok' => true]);

        $mockClient->createPatchRequest('json/gateways', null);

        /** @var MockHttpClient $httpClient */
        $httpClient = $mockClient->getHttpClient();
        $requests = $httpClient->getRequests();

        $this->assertCount(1, $requests);

        $request = $requests[0];
        $this->assertSame('PATCH', $request->getMethod());
        $this->assertSame('', (string) $request->getBody(), 'Expected empty request body when passing null');
    }

    /**
     * @return void
     * @throws ApiException
     * @throws ApiUnavailableException
     * @throws ClientExceptionInterface
     * @throws InvalidArgumentException
     */
    public function testCreatePostRequestWithInvalidUtf8ThrowsInvalidArgumentException(): void
    {
        $mockClient = MockClient::getInstance();

        $mockClient->mockResponse(['ok' => true]);

        // "café" in ISO-8859-1 (0xE9) => invalid UTF-8 for json_encode()
        $badString = "caf" . chr(0xE9);

        $requestBody = new class(['description' => $badString]) implements RequestBodyInterface {
            /**
             * @var array
             */
            private $data;

            /**
             * @param array $data
             */
            public function __construct(array $data)
            {
                $this->data = $data;
            }

            /**
             * @return array
             */
            public function getData(): array
            {
                return $this->data;
            }

            /**
             * @param bool $strictMode
             * @return void
             */
            public function useStrictMode(bool $strictMode): void
            {
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $mockClient->createPostRequest('json/gateways', $requestBody);

        /** @var MockHttpClient $httpClient */
        $httpClient = $mockClient->getHttpClient();
        $this->assertCount(0, $httpClient->getRequests());
    }
}
