<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Tax;

/**
 * Class TaxRule
 * @package MultiSafepay\ValueObject\Tax
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
     * TaxRule constructor.
     * @param string $name
     * @param TaxRate[] $taxRates
     */
    public function __construct(
        string $name,
        array $taxRates
    ) {
        $this->name = $name;
        $this->taxRates = $taxRates;
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
