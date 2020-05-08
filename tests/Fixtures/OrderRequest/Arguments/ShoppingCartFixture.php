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
        $items[] = new ShoppingCartItem(
            'Geometric Candle Holders',
            Money::EUR(50),
            2,
            '1234',
            'none',
            new Weight('KG', 12)
        );

        return new ShoppingCart($items);
    }

    /**
     * @return ShoppingCart
     * @todo Changing amount and quantiy also requires a different test when sending to testing API
     */
    public function createRandomShoppingCartFixture(): ShoppingCart
    {
        $faker = FakerFactory::create();

        $items = [];
        $items[] = new ShoppingCartItem(
            $faker->sentence(3),
            Money::EUR(50),
            2,
            $faker->uuid,
            'none',
            new Weight('KG', rand(1, 10))
        );

        return new ShoppingCart($items);
    }
}
