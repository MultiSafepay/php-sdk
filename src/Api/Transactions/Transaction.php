<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

/**
 * Class Transaction
 * @package MultiSafepay\Api\Transactions
 */
class Transaction
{
    const COMPLETED = 'completed';
    const INITIALIZED = 'initialized';
    const UNCLEARED = 'uncleared';
    const DECLINED = 'declined';
    const CANCELLED = 'cancelled';
    const VOID = 'void';
    const EXPIRED = 'expired';
    const REFUNDED = 'refunded';
    const PARTIAL_REFUNDED = 'partial_refunded';
    const RESERVED = 'reserved';
    const CHARGEDBACK = 'chargedback';
    const SHIPPED = 'shipped';
}
