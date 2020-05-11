<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Utils;

use MultiSafepay\Client\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class MockGenerator
 * @package MultiSafepay\Tests\Utils
 */
class MockGenerator extends TestCase
{
    const TARGET_FOLDER = __DIR__ . '/../fixture-data/';

    /**
     * @param array $getRequests
     * @return void
     * @throws ClientExceptionInterface
     */
    public function generateGetRequests(array $getRequests)
    {
        foreach ($getRequests as $getRequest) {
            $this->writeFile($getRequest, $this->getClient()->createGetRequest($getRequest));
        }
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        require_once __DIR__ . '/../bootstrap.php';

        $apiKey = getenv('API_KEY');
        $this->assertNotEmpty($apiKey);

        return new Client(getenv('API_KEY'), false);
    }

    /**
     * @param string $fileId
     * @param mixed $data
     */
    public function writeFile(string $fileId, $data)
    {
        $file = self::TARGET_FOLDER . $fileId . '.json';
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
}
