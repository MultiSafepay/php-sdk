<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Integration\Api\Issuers;

use Exception;
use MultiSafepay\Api\IssuerManager;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class IssuerTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class IssuerManagerTest extends TestCase
{
    /**
     * Test if initialization fails if invalid gateway code is used
     *
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testGetIssuersByGatewayCode()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('issuers');

        $issuerManager = new IssuerManager($mockClient);
        $issuers = $issuerManager->getIssuersByGatewayCode('ideal');
        foreach ($issuers as $issuer) {
            $this->assertEquals('ideal', $issuer->getGatewayCode());
            $this->assertNotEmpty($issuer->getCode());
            $this->assertNotEmpty($issuer->getDescription());
        }
    }
}
