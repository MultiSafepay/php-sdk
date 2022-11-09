<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Integration\Api;

use Exception;
use MultiSafepay\Api\Categories\Category;
use MultiSafepay\Api\CategoryManager;
use MultiSafepay\Tests\Integration\MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CategoriesTest
 * @package MultiSafepay\Tests\Integration\Api
 */
class CategoryManagerTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAll()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('categories');

        $categoryManager = new CategoryManager($mockClient);
        $categories = $categoryManager->getCategories();

        $this->assertNotEmpty($categories);
        foreach ($categories as $category) {
            $this->assertInstanceOf(Category::class, $category);
            $this->assertNotEmpty($category->getCode());
            $this->assertNotEmpty($category->getDescription());
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testGetAllWithNoData()
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponseFromFixtureFile('categories-empty');

        $categoryManager = new CategoryManager($mockClient);
        $categories = $categoryManager->getCategories();
        $this->assertEquals(0, count($categories));
    }
}
