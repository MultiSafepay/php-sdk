<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description; // @todo: Move this to a generic folder?
use MultiSafepay\Api\Base\RequestBodyInterface;

/**
 * Class RefundRequest
 * @package MultiSafepay\Api\Transactions
 */
class RefundRequest implements RequestBodyInterface
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
     * RefundRequest constructor.
     * @param Money $money
     * @param Description $description
     */
    public function __construct(
        ?Money $money = null,
        ?Description $description = null
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
            'currency' => $this->money ? (string)$this->money->getCurrency() : null,
            'amount' => $this->money ? (string)((float)$this->money->getAmount() * 100) : null,
            'description' => $this->description ? $this->description->getData() : null,
            'checkout_data' => $this->checkoutData ? $this->checkoutData->getData() : null,
        ];
    }

    /**
     * @param Money $money
     * @return RefundRequest
     */
    public function addMoney(Money $money): RefundRequest
    {
        $this->money = $money;
        return $this;
    }

    /**
     * @param Description $description
     * @return RefundRequest
     */
    public function addDescription(Description $description): RefundRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param CheckoutData $checkoutData
     * @return RefundRequest
     */
    public function addCheckoutData(CheckoutData $checkoutData): RefundRequest
    {
        $this->checkoutData = $checkoutData;
        return $this;
    }
}
