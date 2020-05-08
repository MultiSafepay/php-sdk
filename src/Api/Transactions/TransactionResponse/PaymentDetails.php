<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\ResponseBody;

/**
 * Class PaymentDetails
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class PaymentDetails extends ResponseBody
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
     * @todo: Documentation says '"account_iban": "https://betalen.rabobank.nl/...", which is a link not an IBAN number?
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
     * @todo: Documentation says '"isser_id": "0021"' with missing 'u'?
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
}
