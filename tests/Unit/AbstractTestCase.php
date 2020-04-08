<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use MultiSafepay\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class TestCase
 * @package MultiSafepay\Tests\Unit
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @param MockObject $httpClientMock
     * @return Client
     */
    protected function getClientWithMockedHttpClient(MockObject $httpClientMock): Client
    {
        return new Client('dummy', false, $httpClientMock);
    }

    /**
     * @return ClientInterface
     */
    protected function getHttpClientMock(): MockObject
    {
        $httpClientMock = $this->createMock(ClientInterface::class);
        return $httpClientMock;
    }

    /**
     * @param string $returnId ID identifying a JSON file in the data/ folder
     * @return MockObject A mocked instance of ClientInterface
     * @throws Exception
     */
    protected function getHttpClientMockWithSendRequest(string $returnId = ''): MockObject
    {
        $mockedContents = $this->loadMockedContentsById($returnId);

        $bodyMock = $this->createMock(StreamInterface::class);
        $bodyMock->method('getContents')->willReturn($mockedContents);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($bodyMock);

        $httpClientMock = $this->getHttpClientMock();
        $httpClientMock->method('sendRequest')->willReturn($response);
        return $httpClientMock;
    }

    /**
     * @param string $returnId ID identifying a JSON file in the data/ folder
     * @return string
     * @throws Exception
     */
    private function loadMockedContentsById(string $returnId): string
    {
        $file = __DIR__ . '/../fixture-data/' . $returnId . '.json';
        if (!file_exists($file)) {
            throw new Exception('Mock data file "' . $file . '" could not be found');
        }

        return file_get_contents($file);
    }
}
