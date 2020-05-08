<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
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
        $this->taxRates = $taxRates;
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
