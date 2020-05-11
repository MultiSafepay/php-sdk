<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Categorys;

use MultiSafepay\Api\Categories\Category;
use MultiSafepay\Exception\InvalidDataInitializationException;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryTest
 * @package MultiSafepay\Tests\Unit\Api\Categorys
 */
class CategoryTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testNormalInitialization()
    {
        $category = new Category(['code' => '999', 'description' => 'Adult']);
        $this->assertEquals('999', $category->getCode());
        $this->assertEquals('Adult', $category->getDescription());
    }

    /**
     * Test improper initialization
     *
     * @dataProvider getWrongData
     */
    public function testImproperInitialization(string $id, string $description)
    {
        $this->expectException(InvalidDataInitializationException::class);
        $this->expectExceptionMessage('No code or description');
        new Category(['code' => $id, 'description' => $description]);
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
