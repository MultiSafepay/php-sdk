<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Tax;

/**
 * Class TaxTable
 * @package MultiSafepay\ValueObject\Tax
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
     * TaxTable constructor.
     * @param TaxRate $defaultRate
     * @param TaxRule[] $taxRules
     * @param bool $shippingTaxed
     */
    public function __construct(TaxRate $defaultRate, array $taxRules, bool $shippingTaxed = false)
    {
        $this->defaultRate = $defaultRate;
        $this->taxRules = $taxRules;
        $this->shippingTaxed = $shippingTaxed;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $taxRulesData = [];
        foreach ($this->taxRules as $taxRule) {
            $taxRulesData[] = $taxRule->getData();
        }

        return [
            'default' => [
                'shipping_taxed' => $this->shippingTaxed,
                'rate' => $this->defaultRate->getRate() / 100,
            ],
            'alternate' => $taxRulesData
        ];
    }
}
