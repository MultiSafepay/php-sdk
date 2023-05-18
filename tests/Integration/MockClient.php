<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration;

use Exception;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockHttpClient;
use MultiSafepay\Client\Client;
use MultiSafepay\Tests\Utils\FixtureLoader;
use MultiSafepay\Util\Version;

/**
 * Class MockClient
 * @package MultiSafepay\Tests\Integration
 */
class MockClient extends Client
{
    /**
     * @param string $apiKey
     * @return MockClient
     */
    public static function getInstance(string $apiKey = '__valid__')
    {
        Version::getInstance()->addPluginVersion('integration-test');
        $mockClient = new MockHttpClient();
        return new self($apiKey, false, $mockClient);
    }

    /**
     * @param array $data
     * @param bool $success
     * @param int $errorCode
     * @param string $errorInfo
     */
    public function mockResponse(array $data, bool $success = true, int $errorCode = 0, string $errorInfo = ''): void
    {
        $responseData = [
            'success' => $success,
            'data' => $data,
        ];

        if (!empty($errorCode)) {
            $responseData['error_code'] = $errorCode;
        }

        if (!empty($errorInfo)) {
            $responseData['error_info'] = $errorInfo;
        }

        /** @var MockHttpClient $httpClient */
        $httpClient = $this->httpClient;
        $httpClient->reset();
        $httpClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode($responseData)
        ));
    }

    /**
     * @param string $id
     * @throws Exception
     */
    public function mockResponseFromFixtureFile(string $id): void
    {
        $fixtureData = $this->loadFixtureDataById($id);

        /** @var MockHttpClient $httpClient */
        $httpClient = $this->httpClient;
        $httpClient->reset();
        $httpClient->addResponse(new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode($fixtureData)
        ));
    }

    /**
     * @param string $fixtureId ID identifying a JSON file in the fixture-data/ folder
     * @return array
     * @throws Exception
     */
    public function loadFixtureDataById(string $fixtureId): array
    {
        return FixtureLoader::loadFixtureDataById($fixtureId);
    }
}
