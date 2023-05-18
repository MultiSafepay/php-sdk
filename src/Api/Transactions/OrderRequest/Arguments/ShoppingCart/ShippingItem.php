<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;

use MultiSafepay\ValueObject\CartItem;

/**
 * Class Item
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart
 */
class ShippingItem extends CartItem
{

    public const MULTISAFEPAY_SHIPPING_ITEM_CODE = 'msp-shipping';

    /**
     * @return string
     */
    public function getMerchantItemId(): string
    {
        return self::MULTISAFEPAY_SHIPPING_ITEM_CODE;
    }
}
