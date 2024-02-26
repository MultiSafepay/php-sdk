<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class TaxTable
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class TaxTable
{
    /**
     * @var TaxRate
     */
    private $defaultRate;

    /**
     * @var TaxRule[]
     */
    private $taxRules;

    /**
     * @var bool
     */
    private $shippingTaxed;

    /**
     * @param TaxRate $defaultRate
     * @return TaxTable
     */
    public function addDefaultRate(TaxRate $defaultRate): TaxTable
    {
        $this->defaultRate = $defaultRate;
        return $this;
    }

    /**
     * @param TaxRule[] $taxRules
     * @return TaxTable
     */
    public function addTaxRules(array $taxRules): TaxTable
    {
        $this->taxRules = $taxRules;
        return $this;
    }

    /**
     * @param TaxRule $taxRule
     * @return TaxTable
     */
    public function addTaxRule(TaxRule $taxRule): TaxTable
    {
        $this->taxRules[] = $taxRule;
        return $this;
    }

    /**
     * @param bool $shippingTaxed
     * @return TaxTable
     */
    public function addShippingTaxed(bool $shippingTaxed): TaxTable
    {
        $this->shippingTaxed = $shippingTaxed;
        return $this;
    }

    /**
     * TaxTable constructor.
     * @param TaxRate|null $defaultRate
     * @param array $taxRules
     * @param bool $shippingTaxed
     */
    public function __construct(?TaxRate $defaultRate = null, array $taxRules = [], bool $shippingTaxed = false)
    {
        $this->defaultRate = $defaultRate;
        $this->taxRules = $taxRules;
        $this->shippingTaxed = $shippingTaxed;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getData(): array
    {
        $this->validate();

        $taxRulesData = [];
        foreach ($this->taxRules as $taxRule) {
            $taxRulesData[] = $taxRule->getData();
        }

        $data = ['alternate' => $taxRulesData];
        if ($this->defaultRate) {
            $data['default'] = [
                'shipping_taxed' => $this->shippingTaxed,
                'rate' => ($this->defaultRate->getRate() / 100),
            ];
        }

        return $data;
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(): bool
    {
        if (!$this->taxRules) {
            throw new InvalidArgumentException('No tax rules given');
        }

        return true;
    }
}
