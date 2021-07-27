<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use PHPUnit\Framework\TestCase;

class ShoppingCartTest extends TestCase
{
    use ShoppingCartFixture;

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::__construct
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::getItems
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::addItem
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::addItems
     */
    public function testGetItems()
    {
        $shoppingCart = new ShoppingCart([]);
        $this->assertEmpty($shoppingCart->getItems());

        $item = new ShoppingCart\Item();
        $items = [$item];
        $shoppingCart = new ShoppingCart($items);
        $this->assertSame(1, count($shoppingCart->getItems()));

        $item = new ShoppingCart\Item();
        $shoppingCart->addItem($item);
        $this->assertSame(2, count($shoppingCart->getItems()));

        $item1 = new ShoppingCart\Item();
        $item2 = new ShoppingCart\Item();
        $shoppingCart->addItems([$item1, $item2]);
        $this->assertSame(4, count($shoppingCart->getItems()));
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::validate
     */
    public function testValidate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No items in cart');
        $shoppingCart = new ShoppingCart([]);
        $this->assertEmpty($shoppingCart->getItems());
        $shoppingCart->validate();
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::fromData
     */
    public function testFromData()
    {
        $data = $this->createShoppingCartFixture()->getData();
        $shoppingCart = ShoppingCart::fromData($data);
        $this->assertSame(1, count($shoppingCart->getItems()));
    }
    
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart::fromData
     */
    public function testShoppingCartFromDataWithNull()
    {
        $this->expectException(InvalidArgumentException::class);
        $shoppingCart = (new ShoppingCart([]))::fromData(null);
        $shoppingCart->getData();
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\ShippingItem::getMerchantItemId
     */
    public function testMerchantItemIdFromShippingItemData()
    {
        $data = $this->createShippingCartFixture()->getData();
        $shoppingCart = ShoppingCart::fromData($data);
        $items = $shoppingCart->getItems();
        $this->assertSame('msp-shipping', $items[0]->getMerchantItemId());
    }
}
