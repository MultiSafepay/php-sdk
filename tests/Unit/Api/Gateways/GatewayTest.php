<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Gateways;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Exception\InvalidDataInitializationException;
use PHPUnit\Framework\TestCase;

/**
 * Class GatewayTest
 * @package MultiSafepay\Tests\Unit\Api\Gateways
 */
class GatewayTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testNormalInitialization()
    {
        $gateway = new Gateway(['id' => 'IDEAL', 'description' => 'iDEAL']);
        $this->assertEquals('IDEAL', $gateway->getId());
        $this->assertEquals('iDEAL', $gateway->getDescription());
    }

    /**
     * Test improper initialization
     *
     * @dataProvider getWrongData
     */
    public function testImproperInitialization(string $id, string $description)
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage('No ID or description');
        new Gateway(['id' => $id, 'description' => $description]);
    }

    /**
     * @return array
     */
    public function getWrongData(): array
    {
        return [
            ['foo', ''],
            ['', 'description'],
            ['', ''],
        ];
    }
}
