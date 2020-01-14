<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

class Transaction
{
    /** @var array */
    private $data;

    /**
     * Transaction constructor.
     * @param array $transaction
     */
    public function __construct(array $transaction)
    {
        $this->data = $transaction;
    }

    /**
     * @return array
     */
    public function getData():array
    {
        return $this->data['data'];
    }

    /**
     * @return string|null
     */
    public function getPaymentLink(): ?string
    {
        if (!isset($this->getData()['payment_url'])) {
            return null;
        }
        return $this->getData()['payment_url'];
    }
}
