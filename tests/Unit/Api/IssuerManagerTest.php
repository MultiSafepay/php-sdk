<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Issuers;

use InvalidArgumentException;
use MultiSafepay\Api\IssuerManager;
use MultiSafepay\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class IssuerTest
 * @package MultiSafepay\Tests\Unit\Api
 */
class IssuerManagerTest extends TestCase
{
    /**
     * Test if initialization fails if invalid gateway code is used
     */
    public function testGetIssuersByWrongGatewayCode()
    {
        $this->expectException(InvalidArgumentException::class);
        $clientMock = $this->createMock(Client::class);
        $issuerManager = new IssuerManager($clientMock);
        $issuerManager->getIssuersByGatewayCode('foobar');
    }
}
