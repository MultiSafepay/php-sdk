<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use Money\Money;
use MultiSafepay\ValueObject\ShoppingCart;
use MultiSafepay\ValueObject\Weight;
use MultiSafepay\ValueObject\ShoppingCart\Item as ShoppingCartItem;

/**
 * Trait ShoppingCartFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
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
}
