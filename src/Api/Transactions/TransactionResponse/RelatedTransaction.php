<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\ValueObject\Money;

/**
 * Class RelatedTransaction
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class RelatedTransaction extends DataObject
{
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
        return strtoupper((string)$this->get('currency'));
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return new Money($this->getAmount(), $this->getCurrency());
    }

    /**
     * @return Costs
     */
    public function getCosts(): Costs
    {
        return new Costs((array)$this->get('costs'));
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
    public function getCreated(): string
    {
        return (string)$this->get('created');
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return (string)$this->get('modified');
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
    public function getTransactionId(): string
    {
        return (string)$this->get('transaction_id');
    }
}
