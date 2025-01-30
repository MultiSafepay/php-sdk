<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Amount;
use MultiSafepay\ValueObject\Percentage;

/**
 * Class SplitPayment
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate
 */
class SplitPayment implements GatewayInfoInterface
{
    /**
     * @var string
     */
    private $merchant;

    /**
     * @var ?string
     */
    private $description = null;

    /**
     * @var Amount
     */
    private $fixed;

    /**
     * @var Percentage
     */
    private $percentage;

    /**
     * @param string $merchant
     * @return $this
     */
    public function addMerchant(string $merchant): SplitPayment
    {
        $this->merchant = $merchant;
        return $this;
    }

    /**
     * @param Amount $fixedAmount
     * @return $this
     */
    public function addFixed(Amount $fixedAmount): SplitPayment
    {
        $this->fixed = $fixedAmount;
        return $this;
    }

    /**
     * @param Percentage $percentage
     * @return $this
     */
    public function addPercentage(Percentage $percentage): SplitPayment
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function addDescription(?string $description): SplitPayment
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        $this->validate();

        if (isset($this->percentage)) {
            return [
                "merchant" => $this->merchant,
                "percentage" => $this->percentage->getValue(),
                "description" => $this->description,
            ];
        }

        return [
            "merchant" => $this->merchant,
            "fixed" => $this->fixed ? $this->fixed->get() : null,
            "description" => $this->description,
        ];
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (!isset($this->merchant)) {
            throw new InvalidArgumentException("Merchant is required.");
        }

        if (isset($this->fixed) && isset($this->percentage)) {
            throw new InvalidArgumentException("You can only set either a fixed amount or a percentage, not both.");
        }

        if (!isset($this->fixed) && !isset($this->percentage)) {
            throw new InvalidArgumentException("You must set either a fixed amount or a percentage.");
        }
    }

    /**
     * @return Amount
     */
    public function getFixed(): Amount
    {
        return $this->fixed;
    }

    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage
    {
        return $this->percentage;
    }

    /**
     * @return string
     */
    public function getMerchant(): string
    {
        return $this->merchant;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
