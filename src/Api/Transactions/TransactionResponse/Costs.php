<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class Costs
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class Costs extends DataObject
{
    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return (int)$this->get('transaction_id');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->get('description');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->get('type');
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return (float)$this->get('amount');
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return (string)$this->get('currency');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return (string)$this->get('status');
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return (string)$this->get('created');
    }
}
