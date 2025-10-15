<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class CardAuthenticationResult
 * @package MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails
 */
class CardAuthenticationResult extends DataObject
{
    /**
     * Get the ACS transaction ID.
     *
     * @return string|null
     */
    public function getAcsTransactionId(): ?string
    {
        return $this->get('acs_transaction_id');
    }

    /**
     * Get the chargeback liability.
     *
     * @return string|null
     */
    public function getChargebackLiability(): ?string
    {
        return $this->get('chargeback_liability');
    }

    /**
     * Get the DS transaction ID.
     *
     * @return string|null
     */
    public function getDsTransactionId(): ?string
    {
        return $this->get('ds_transaction_id');
    }

    /**
     * Get the status of the card authentication result.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->get('status');
    }

    /**
     * Get the version of the card authentication result.
     *
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->get('version');
    }

    /**
     * Get the CAVV (Cardholder Authentication Verification Value).
     *
     * @return string|null
     */
    public function getCavv(): ?string
    {
        return $this->get('cavv');
    }

    /**
     * Get the ECI (Electronic Commerce Indicator).
     *
     * @return string|null
     */
    public function getEci(): ?string
    {
        return $this->get('eci');
    }

    /**
     * Get the challenge cancel status.
     *
     * @return string|null
     */
    public function getChallengeCancel(): ?string
    {
        return $this->get('challenge_cancel');
    }

    /**
     * Get the transaction status reason.
     *
     * @return string|null
     */
    public function getTransactionStatusReason(): ?string
    {
        return $this->get('transaction_status_reason');
    }
}
