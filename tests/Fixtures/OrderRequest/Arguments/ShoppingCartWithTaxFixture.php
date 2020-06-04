<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;

/**
 * Trait ShoppingCartWithTaxFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait ShoppingCartWithTaxFixture
{
    /**
     * @return ShoppingCart
     */
    public function createShoppingCartWithTaxFixture(): ShoppingCart
    {
        $items = [];
        $items[] = (new ShoppingCartItem())
            ->addName('Geometric Candle Holders')
            ->addUnitPrice(Money::EUR(520))
            ->addQuantity(3)
            ->addDescription('1234')
            ->addTaxRate(21)
            ->addTaxTableSelector('BTW21')
            ->addWeight(
                new Weight('KG', 12)
            );

        return new ShoppingCart($items);
    }

    /**
     * @return ShoppingCart
     */
    public function createRandomShoppingCartWithTaxFixture(): ShoppingCart
    {
        $faker = FakerFactory::create();

        $items = [];
        $items[] = (new ShoppingCartItem())
            ->addName($faker->sentence(3))
            ->addUnitPrice(Money::EUR(520))
            ->addQuantity(3)
            ->addMerchantItemId($faker->uuid)
            ->addDescription($faker->sentence(10))
            ->addTaxRate(21)
            ->addTaxTableSelector('BTW21')
            ->addWeight(
                new Weight('KG', rand(1, 10))
            );

        return new ShoppingCart($items);
    }
}
