<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class PaymentDetails
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 */
class PaymentDetails extends DataObject
{
    /**
     * @return string
     */
    public function getRecurringId(): string
    {
        return (string)$this->get('recurring_id');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->get('type');
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return (string)$this->get('account_id');
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
    public function getExternalTransactionId(): string
    {
        return (string)$this->get('external_transaction_id');
    }

    /**
     * @return string
     */
    public function getAccountIban(): string
    {
        return (string)$this->get('account_iban');
    }

    /**
     * @return string
     */
    public function getAccountBic(): string
    {
        return (string)$this->get('account_bic');
    }

    /**
     * @return string
     */
    public function getIssuerId(): string
    {
        return (string)$this->get('issuer_id');
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
    public function getCardExpiryDate(): string
    {
        return (string)$this->get('card_expiry_date');
    }

    /**
     * @return string
     */
    public function getCapture(): string
    {
        return (string)$this->get('capture');
    }

    /**
     * @return string
     */
    public function getCaptureExpiry(): string
    {
        return (string)$this->get('capture_expiry');
    }

    /**
     * @return int
     */
    public function getCaptureRemain(): int
    {
        return (int)$this->get('capture_remain');
    }
}
