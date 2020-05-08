<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description; // @todo: Move this to a generic folder?

/**
 * Class RequestOrderDirect
 * @package MultiSafepay\Api\Transactions
 */
class RequestRefund implements RequestOrderInterface
{
    /**
     * @var Money
     */
    private $money;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var CheckoutData
     */
    private $checkoutData;

    /**
     * RequestOrderDirect constructor.
     * @param Money $money
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
            'currency' => (string)$this->money->getCurrency(),
            'amount' => (string)((float)$this->money->getAmount() * 100),
            'description' => $this->description->getData() ?? null,
            'checkout_data' => $this->checkoutData->getData() ?? null,
        ];
    }

    /**
     * @param CheckoutData $checkoutData
     */
    public function addCheckoutData(CheckoutData $checkoutData)
    {
        $this->checkoutData = $checkoutData;
    }
}
