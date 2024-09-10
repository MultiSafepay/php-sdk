<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Percentage;

/**
 * Class SplitPayment
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
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
     * @var Money
     */
    private $fixed;

    /**
     * @var Percentage
     */
    private $percentage;

    /**
     * SplitPayment constructor.
     * @param string|null $merchant
     * @param Money|null $fixed
     * @param Percentage|null $percentage
     * @param string|null $description
     */
    public function __construct(
        ?string $merchant = null,
        ?Money $fixed = null,
        ?Percentage $percentage = null,
        ?string $description = null
    ) {
        if ($merchant !== null) {
            $this->merchant = $merchant;
        }

        $this->description = $description;

        if ($percentage !== null && $fixed !== null) {
            throw new \InvalidArgumentException("You can only set either a fixed amount or a percentage, not both.");
        }

        if ($percentage !== null) {
            $this->percentage = $percentage;
        }
        if ($fixed !== null) {
            $this->fixed = $fixed;
        }
    }


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
     * @param Money $fixedAmount
     * @return $this
     */
    public function addFixed(Money $fixedAmount): SplitPayment
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
            "fixed" => $this->fixed ? (int)round($this->fixed->getAmount()) : null,
            "description" => $this->description,
        ];
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (isset($this->fixed) && isset($this->percentage)) {
            throw new InvalidArgumentException("You can only set either a fixed amount or a percentage, not both.");
        }

        if (!isset($this->fixed) && !isset($this->percentage)) {
            throw new InvalidArgumentException("You must set either a fixed amount or a percentage.");
        }
    }

    /**
     * @return Money
     */
    public function getFixed(): Money
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
