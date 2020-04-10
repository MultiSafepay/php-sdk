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
     * @todo Why input $transactionData here, if it is only used by create() and not refund()?
     */
    public function __construct(array $transactionData, Client $client)
    {
        parent::__construct($client);
        $this->data = $transactionData;
    }

    /**
     * @return array
     */
    public function getOrderData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     * @todo: Why is this method public?
     */
    public function getData(): array
    {
        return isset($this->data['data']) ? $this->data['data'] : [];
    }

    /**
     * @return string|null
     * @todo: Why return a `null` when an empty string would suffice?
     */
    public function getPaymentLink(): ?string
    {
        if (!isset($this->getData()['payment_url'])) {
            return null;
        }
        return $this->getData()['payment_url'];
    }

    /**
     * @return string
     * @todo: Should this be a string or an integer?
     */
    public function getOrderId(): string
    {
        if (empty($this->data['data']['order_id'])) {
            throw new InvalidOrderDataException('No order ID found');
        }

        return (string)$this->data['data']['order_id'];
    }
}
