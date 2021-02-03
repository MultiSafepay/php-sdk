<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

/**
 * Class Gateways
 * @package MultiSafepay\Api\Transactions
 */
class Gateways
{
    const SHOPPING_CART_REQUIRED_GATEWAYS = array(
        'AFTERPAY',
        'EINVOICE',
        'IN3',
        'KLARNA',
        'PAYAFTER',
    );
}
