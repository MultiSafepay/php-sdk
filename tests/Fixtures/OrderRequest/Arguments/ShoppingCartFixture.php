<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;

/**
 * Trait ShoppingCartFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait ShoppingCartFixture
{
    /**
     * @return ShoppingCart
     */
    public function createShoppingCartFixture(): ShoppingCart
    {
        $items = [];
        $items[] = (new ShoppingCartItem())
            ->addName('Geometric Candle Holders')
            ->addUnitPrice(new Money(5000, 'EUR'))
            ->addQuantity(2)
            ->addDescription('1234')
            ->addTaxRate(0)
            ->addTaxTableSelector('none')
            ->addMerchantItemId('1234')
            ->addWeight(
                new Weight('KG', 12)
            );

        return new ShoppingCart($items);
    }

    /**
     * @return ShoppingCart
     */
    public function createRandomShoppingCartFixture(): ShoppingCart
    {
        $faker = FakerFactory::create();

        $items = [];
        $items[] = (new ShoppingCartItem())
            ->addName($faker->sentence(3) . ' with VAT')
            ->addUnitPrice(new Money(20, 'EUR'))
            ->addQuantity(2)
            ->addMerchantItemId($faker->uuid)
            ->addDescription($faker->sentence(10))
            ->addTaxRate(0)
            ->addTaxTableSelector('none')
            ->addWeight(
                new Weight('KG', rand(1, 10))
            );

        return new ShoppingCart($items);
    }

    /**
     * @return ShoppingCart
     */
    public function createShoppingCartFixtureWithSimilarTaxRates(): ShoppingCart
    {
        $items = [];
        $items[] = (new ShoppingCartItem())
            ->addName('Geometric Candle Holders 1')
            ->addUnitPrice(new Money(5000, 'EUR'))
            ->addQuantity(2)
            ->addDescription('1234')
            ->addTaxRate(21.20)
            ->addTaxTableSelector('21.20')
            ->addMerchantItemId('1234')
            ->addWeight(
                new Weight('KG', 12)
            );
        $items[] = (new ShoppingCartItem())
            ->addName('Geometric Candle Holders 2')
            ->addUnitPrice(new Money(5000, 'EUR'))
            ->addQuantity(2)
            ->addDescription('1234')
            ->addTaxRate(21.30)
            ->addTaxTableSelector('21.30')
            ->addMerchantItemId('12345')
            ->addWeight(
                new Weight('KG', 12)
            );

        return new ShoppingCart($items);
    }
}
