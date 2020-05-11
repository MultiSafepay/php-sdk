<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest;

use Money\Money;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CustomerDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Redirect
 * @package MultiSafepay\Api\Transactions\OrderRequest
 */
class Redirect extends OrderRequest
{
    /**
     * @var string
     */
    protected $type = 'redirect';

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        parent::validate();

        if (!$this->shoppingCart && $this->taxTable) {
            throw new InvalidArgumentException('Shopping cart is required when adding a tax table');
        }

        if (!$this->taxTable && $this->shoppingCart) {
            throw new InvalidArgumentException('Tax table is required when adding a shopping cart');
        }

        return true;
    }
}
