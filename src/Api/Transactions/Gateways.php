<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

/**
 * Class Gateways
 * @package MultiSafepay\Api\Transactions
 */
class Gateways
{
    public const SHOPPING_CART_REQUIRED_GATEWAYS = array(
        'AFTERPAY',
        'EINVOICE',
        'IN3',
        'KLARNA',
        'PAYAFTER',
        'BNPL_INSTM',
        'BNPL_INST',
        'IN3B2B',
        'SANTANDER',
        'ZINIA',
        'ZINIA_IN3',
        'BNPL_OB',
        'BNPL_MF',
        'BILLINK',
    );
}
