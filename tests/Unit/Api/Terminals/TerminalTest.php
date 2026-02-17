<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Terminals;

use MultiSafepay\Api\Terminals\Terminal;
use MultiSafepay\Exception\InvalidDataInitializationException;
use PHPUnit\Framework\TestCase;

/**
 * Class TerminalTest
 * @package MultiSafepay\Tests\Unit\Api\Terminals
 */
class TerminalTest extends TestCase
{
    /**
     * Test normal initialization with all fields
     */
    public function testNormalInitialization()
    {
        $data = [
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal 000013Z1',
            'code' => '8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae',
            'created' => '2025-12-15T09:18:50',
            'last_updated' => '2025-12-29T20:44:04',
            'manufacturer_id' => 'SUNMI',
            'serial_number' => 'P211226V20181',
            'active' => true,
            'group_id' => 107265,
            'country' => 'NL',
        ];

        $terminal = new Terminal($data);

        $this->assertEquals('000013Z1', $terminal->getId());
        $this->assertEquals('SMARTPOS', $terminal->getProvider());
        $this->assertEquals('Terminal 000013Z1', $terminal->getName());
        $this->assertEquals('8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae', $terminal->getCode());
        $this->assertEquals('2025-12-15T09:18:50', $terminal->getCreated());
        $this->assertEquals('2025-12-29T20:44:04', $terminal->getLastUpdated());
        $this->assertEquals('SUNMI', $terminal->getManufacturerId());
        $this->assertEquals('P211226V20181', $terminal->getSerialNumber());
        $this->assertTrue($terminal->isActive());
        $this->assertEquals(107265, $terminal->getGroupId());
        $this->assertEquals('NL', $terminal->getCountry());
    }

    /**
     * Test initialization with null optional fields
     */
    public function testNullOptionalFields()
    {
        $data = [
            'id' => '000013YX',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal 000013YX',
            'code' => '8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae',
            'created' => '2025-12-15T09:18:13',
            'last_updated' => '2025-12-15T09:20:08',
            'manufacturer_id' => null,
            'serial_number' => null,
            'active' => false,
            'group_id' => 107265,
            'country' => null,
        ];

        $terminal = new Terminal($data);

        $this->assertEquals('000013YX', $terminal->getId());
        $this->assertEquals('SMARTPOS', $terminal->getProvider());
        $this->assertEquals('Terminal 000013YX', $terminal->getName());
        $this->assertEquals('8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae', $terminal->getCode());
        $this->assertEquals('2025-12-15T09:18:13', $terminal->getCreated());
        $this->assertEquals('2025-12-15T09:20:08', $terminal->getLastUpdated());
        $this->assertNull($terminal->getManufacturerId());
        $this->assertNull($terminal->getSerialNumber());
        $this->assertFalse($terminal->isActive());
        $this->assertEquals(107265, $terminal->getGroupId());
        $this->assertNull($terminal->getCountry());
    }

    /**
     * Test getCode returns string or null
     */
    public function testGetCodeReturnsStringOrNull()
    {
        $terminalWithCode = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'code' => '8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae',
        ]);
        $this->assertEquals('8bc6d17f-e6c0-474c-b8b9-bed7d9c002ae', $terminalWithCode->getCode());

        $terminalWithoutCode = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutCode->getCode());
    }

    /**
     * Test getCreated returns string or null
     */
    public function testGetCreatedReturnsStringOrNull()
    {
        $terminalWithCreated = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'created' => '2025-12-15T09:18:50',
        ]);
        $this->assertEquals('2025-12-15T09:18:50', $terminalWithCreated->getCreated());

        $terminalWithoutCreated = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutCreated->getCreated());
    }

    /**
     * Test getLastUpdated returns string or null
     */
    public function testGetLastUpdatedReturnsStringOrNull()
    {
        $terminalWithLastUpdated = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'last_updated' => '2025-12-29T20:44:04',
        ]);
        $this->assertEquals('2025-12-29T20:44:04', $terminalWithLastUpdated->getLastUpdated());

        $terminalWithoutLastUpdated = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutLastUpdated->getLastUpdated());
    }

    /**
     * Test getManufacturerId returns string or null
     */
    public function testGetManufacturerIdReturnsStringOrNull()
    {
        $terminalWithManufacturerId = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'manufacturer_id' => 'SUNMI',
        ]);
        $this->assertEquals('SUNMI', $terminalWithManufacturerId->getManufacturerId());

        $terminalWithoutManufacturerId = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutManufacturerId->getManufacturerId());
    }

    /**
     * Test getSerialNumber returns string or null
     */
    public function testGetSerialNumberReturnsStringOrNull()
    {
        $terminalWithSerialNumber = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'serial_number' => 'P211226V20181',
        ]);
        $this->assertEquals('P211226V20181', $terminalWithSerialNumber->getSerialNumber());

        $terminalWithoutSerialNumber = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutSerialNumber->getSerialNumber());
    }

    /**
     * Test isActive returns bool
     */
    public function testIsActiveReturnsBool()
    {
        $terminalActive = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'active' => true,
        ]);
        $this->assertTrue($terminalActive->isActive());

        $terminalInactive = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'active' => false,
        ]);
        $this->assertFalse($terminalInactive->isActive());

        $terminalWithoutActive = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertFalse($terminalWithoutActive->isActive());
    }

    /**
     * Test getGroupId returns int or null
     */
    public function testGetGroupIdReturnsIntOrNull()
    {
        $terminalWithGroupId = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'group_id' => 107265,
        ]);
        $this->assertEquals(107265, $terminalWithGroupId->getGroupId());
        $this->assertIsInt($terminalWithGroupId->getGroupId());

        $terminalWithoutGroupId = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutGroupId->getGroupId());
    }

    /**
     * Test getCountry returns string or null
     */
    public function testGetCountryReturnsStringOrNull()
    {
        $terminalWithCountry = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
            'country' => 'NL',
        ]);
        $this->assertEquals('NL', $terminalWithCountry->getCountry());

        $terminalWithoutCountry = new Terminal([
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal',
        ]);
        $this->assertNull($terminalWithoutCountry->getCountry());
    }

    /**
     * Test getData returns the original data
     */
    public function testGetDataReturnsOriginalData()
    {
        $data = [
            'id' => '000013Z1',
            'provider' => 'SMARTPOS',
            'name' => 'Terminal 000013Z1',
            'active' => true,
        ];

        $terminal = new Terminal($data);
        $this->assertEquals($data, $terminal->getData());
    }

    /**
     * Test improper initialization throws exception
     *
     * @dataProvider getWrongData
     */
    public function testImproperInitialization(array $data, string $expectedMessage)
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage($expectedMessage);
        new Terminal($data);
    }

    /**
     * @return array
     */
    public function getWrongData(): array
    {
        return [
            'missing id' => [
                ['provider' => 'SMARTPOS', 'name' => 'Terminal'],
                'Missing required field: ID',
            ],
            'empty id' => [
                ['id' => '', 'provider' => 'SMARTPOS', 'name' => 'Terminal'],
                'Missing required field: ID',
            ],
            'missing provider' => [
                ['id' => '000013Z1', 'name' => 'Terminal'],
                'Missing required field: Provider',
            ],
            'empty provider' => [
                ['id' => '000013Z1', 'provider' => '', 'name' => 'Terminal'],
                'Missing required field: Provider',
            ],
            'missing name' => [
                ['id' => '000013Z1', 'provider' => 'SMARTPOS'],
                'Missing required field: Name',
            ],
            'empty name' => [
                ['id' => '000013Z1', 'provider' => 'SMARTPOS', 'name' => ''],
                'Missing required field: Name',
            ],
            'empty array' => [
                [],
                'Missing required field: ID',
            ],
        ];
    }
}
