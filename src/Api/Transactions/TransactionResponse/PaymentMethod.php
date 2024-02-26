<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\ValueObject\Money;

/**
 * Class PaymentMethod
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 */
class PaymentMethod extends DataObject
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
        return (string)$this->get('currency');
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return new Money($this->getAmount(), $this->getCurrency());
    }

    /**
     * @return string
     */
    public function getAccountHolderName(): string
    {
        return (string)$this->get('account_holder_name');
    }

    /**
     * @return string
     */
    public function getCardExpiryDate(): string
    {
        return (string)$this->get('card_expiry_date');
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
    public function getExternalTransactionId(): string
    {
        return (string)$this->get('external_transaction_id');
    }

    /**
     * @return string
     */
    public function getLast4(): string
    {
        return (string)$this->get('last4');
    }

    /**
     * @return string
     */
    public function getPaymentDescription(): string
    {
        return (string)$this->get('payment_description');
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
    public function getType(): string
    {
        return (string)$this->get('type');
    }
}
