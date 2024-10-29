<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\RequestBodyInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Currency;
use MultiSafepay\ValueObject\Money;

/**
 * Class RefundRequest
 * @package MultiSafepay\Api\Transactions
 */
class RefundRequest extends RequestBody implements RequestBodyInterface
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
     * @var Amount
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        return $this->removeNullRecursive(array_merge(
            [
                'currency' => $this->getCurrency(),
                'amount' => $this->getAmount(),
                'description' => $this->description ? $this->description->getData() : null,
                'checkout_data' => $this->checkoutData ? $this->checkoutData->getData() : null,
            ],
            $this->data
        ));
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
     * @param Amount $amount
     * @return $this
     */
    public function addAmount(Amount $amount): RefundRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param Currency $currency
     * @return $this
     */
    public function addCurrency(Currency $currency): RefundRequest
    {
        $this->currency = $currency;
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
     * @param string $description
     * @return RefundRequest
     */
    public function addDescriptionText(string $description): RefundRequest
    {
        $this->description = (new Description())->addDescription($description);
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

    /**
     * @return CheckoutData
     */
    public function getCheckoutData(): CheckoutData
    {
        return $this->checkoutData;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        if ($this->money) {
            return $this->money->getCurrency() ?? null;
        }

        if ($this->currency) {
            return $this->currency->get() ?? null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        if ($this->money) {
            return (int)round($this->money->getAmount()) ?? null;
        }

        if ($this->amount) {
            return $this->amount->get() ?? null;
        }

        return null;
    }
}
