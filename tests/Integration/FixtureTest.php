<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Integration;

use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use PHPUnit\Framework\TestCase;

/**
 * Class FixtureTest
 * @package MultiSafepay\Tests\Unit
 */
class FixtureTest extends TestCase
{
    use ShoppingCartFixture;

    /**
     * Test whether the shopping cart fixture is working
     */
    public function testShoppingCartFixture()
    {
        $shoppingCart = $this->createShoppingCartFixture();
        $this->assertNotEmpty($shoppingCart);
    }
}
