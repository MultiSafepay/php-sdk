<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

/**
 * Class Transaction
 * @package MultiSafepay\Api\Transactions
 */
class Transaction
{
    public const COMPLETED = 'completed';
    public const INITIALIZED = 'initialized';
    public const UNCLEARED = 'uncleared';
    public const DECLINED = 'declined';
    public const CANCELLED = 'cancelled';
    public const VOID = 'void';
    public const EXPIRED = 'expired';
    public const REFUNDED = 'refunded';
    public const PARTIAL_REFUNDED = 'partial_refunded';
    public const RESERVED = 'reserved';
    public const CHARGEDBACK = 'chargedback';
    public const SHIPPED = 'shipped';
}
