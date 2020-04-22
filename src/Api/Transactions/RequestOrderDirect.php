<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\PaymentOptions;

/**
 * Class RequestOrderDirect
 * @package MultiSafepay\Api\Transactions
 */
class RequestOrderDirect implements RequestOrderInterface
{
    /**
     * @var string
     */
    protected $type = 'direct';

    /**
     * @var string
     */
    private $orderId;

    /**
     * @var Money
     */
    private $money;

    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var PaymentOptions
     */
    private $paymentOptions;

    /**
     * @var GatewayInfo
     */
    private $gatewayInfo;

    /**
     * @var Description
     */
    private $description;

    /**
     * RequestOrderDirect constructor.
     * @param string $orderId
     * @param Money $money
     * @param string $gatewayCode
     * @param PaymentOptions $paymentOptions
     * @param GatewayInfo $gatewayInfo
     * @param Description $description
     */
    public function __construct(
        string $orderId,
        Money $money,
        string $gatewayCode,
        PaymentOptions $paymentOptions,
        GatewayInfo $gatewayInfo,
        Description $description = null
    ) {
        $this->orderId = $orderId;
        $this->money = $money;
        $this->gatewayCode = strtoupper($gatewayCode);
        $this->paymentOptions = $paymentOptions;
        $this->gatewayInfo = $gatewayInfo;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'type' => $this->type,
            'order_id' => $this->orderId,
            'currency' => (string)$this->money->getCurrency(),
            'amount' => (string)$this->money->getAmount(),
            'gateway' => $this->gatewayCode,
            'gateway_info' => $this->gatewayInfo->getData(),
            'payment_options' => $this->paymentOptions->getData(),
            'description' => $this->description->getData() ?? null,
        ];
    }
}
