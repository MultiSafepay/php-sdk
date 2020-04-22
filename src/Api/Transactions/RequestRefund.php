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
class RequestRefund implements RequestOrderInterface
{
    /**
     * @var string
     */
    protected $type = 'direct';

    /**
     * @var Money
     */
    private $money;

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
        Money $money,
        Description $description = null
    ) {
        $this->money = $money;
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'currency' => $this->money->getCurrency(),
            'amount' => $this->money->getAmount(),
            'description' => $this->description->getData() ?? null,
        ];
    }
}
