<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Pager\Pager;

class TransactionListing
{
    /**
     * @var array
     */
    private $transactions;

    /**
     * @var Pager
     */
    private $pager;

    /**
     * TransactionListing constructor.
     * @param array $data
     * @param Pager|null $pager
     */
    public function __construct(array $data, Pager $pager = null)
    {
        $transactions = [];
        if (!empty($data)) {
            foreach ($data as $transactionData) {
                $transactions[] = new TransactionResponse($transactionData, json_encode($transactionData));
            }
        }
        $this->transactions = $transactions;

        if (isset($pager)) {
            $this->pager = $pager;
        }
    }

    /**
     * @return TransactionResponse[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * @return Pager|null
     */
    public function getPager(): ?Pager
    {
        return $this->pager ?? null;
    }
}
