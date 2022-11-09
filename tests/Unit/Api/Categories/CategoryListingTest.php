<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Categories;

use MultiSafepay\Api\Categories\CategoryListing;
use PHPUnit\Framework\TestCase;

/**
 * Class CategoryListingTest
 * @package MultiSafepay\Tests\Unit\Api\Categories
 */
class CategoryListingTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testGetCategories()
    {
        $categoryListing = new CategoryListing([['code' => '999', 'description' => 'Adult']]);
        $categories = $categoryListing->getCategories();
        $this->assertEquals(1, count($categories));

        $category = array_shift($categories);
        $this->assertEquals('999', $category->getCode());
        $this->assertEquals('Adult', $category->getDescription());
    }
}
