<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;

/**
 * Class TaxRule
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable
 */
class TaxRule
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var TaxRate[]
     */
    private $taxRates;

    /**
     * @param string $name
     * @return TaxRule
     */
    public function addName(string $name): TaxRule
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param TaxRate[] $taxRates
     * @return TaxRule
     */
    public function addTaxRates(array $taxRates): TaxRule
    {
        foreach ($taxRates as $taxRate) {
            $this->addTaxRate($taxRate);
        }
        return $this;
    }

    /**
     * @param TaxRate $taxRate
     * @return TaxRule
     */
    public function addTaxRate(TaxRate $taxRate): TaxRule
    {
        $this->taxRates[] = $taxRate;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $taxRatesData = [];
        foreach ($this->taxRates as $taxRate) {
            $taxRatesData[] = [
                'rate' => $taxRate->getRate() / 100,
                'country' => $taxRate->getCountry() ? $taxRate->getCountry()->getCode() : '',
            ];
        }

        return [
            'name' => $this->name,
            'rules' => $taxRatesData,
        ];
    }
}
