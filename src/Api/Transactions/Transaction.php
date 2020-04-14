<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base;
use MultiSafepay\Client;
use MultiSafepay\Exception\InvalidOrderDataException;

/**
 * Model Transaction for containing transaction data received from the API
 * @package MultiSafepay\Api\Transactions
 */
class Transaction extends Base
{
    /** @var array */
    private $data;

    /**
     * Transaction constructor.
     * @param array $transactionData
     * @param Client $client
     */
    public function __construct(array $transactionData, Client $client)
    {
        parent::__construct($client);
        $this->data = $transactionData;
    }

    /**
     * @return array
     * @todo: Why is this method public?
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getPaymentLink(): string
    {
        if (!isset($this->getData()['payment_url'])) {
            return '';
        }
        return $this->getData()['payment_url'];
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        if (empty($this->data['order_id'])) {
            throw new InvalidOrderDataException('No order ID found');
        }

        return (string)$this->data['order_id'];
    }
}
