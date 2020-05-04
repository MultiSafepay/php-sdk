<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\PaymentOptions;
use MultiSafepay\Api\Transactions\RequestOrderInterface;

/**
 * Class Redirect
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class Redirect implements RequestOrderInterface
{
    const TYPE = 'redirect';

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
     * @var GatewayInfoInterface
     */
    private $gatewayInfo;

    /**
     * @var Description
     */
    private $description;

    /**
     * Redirect constructor.
     * @param string $orderId
     * @param Money $money
     * @param string $gatewayCode
     * @param PaymentOptions $paymentOptions
     * @param GatewayInfoInterface $gatewayInfo
     * @param Description $description
     */
    public function __construct(
        string $orderId,
        Money $money,
        string $gatewayCode, // @todo: Replace this with actual Gateway class
        PaymentOptions $paymentOptions,
        GatewayInfoInterface $gatewayInfo,
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
            'type' => self::TYPE,
            'order_id' => $this->orderId,
            'currency' => (string)$this->money->getCurrency(),
            'amount' => (string)$this->money->getAmount() * 100,
            'gateway' => $this->gatewayCode,
            'gateway_info' => $this->gatewayInfo->getData(),
            'payment_options' => $this->paymentOptions->getData(),
            'description' => $this->description->getData() ?? null,
        ];
    }
}
