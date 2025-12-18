<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class PaymentData
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class PaymentData extends DataObject
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $gateway;

    /**
     * @var bool
     */
    private $tokenize;

    /**
     * @param string $payload
     * @return PaymentData
     */
    public function addPayload(string $payload): PaymentData
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param string $gateway
     * @return PaymentData
     */
    public function addGateway(string $gateway): PaymentData
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @param bool $tokenize
     * @return PaymentData
     */
    public function addTokenize(bool $tokenize): PaymentData
    {
        $this->tokenize = $tokenize;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive([
            'payload' => $this->payload,
            'gateway' => $this->gateway,
            'tokenize' => $this->tokenize,
        ]);
    }
}
