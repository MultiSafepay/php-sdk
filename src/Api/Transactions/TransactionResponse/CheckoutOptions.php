<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;

/**
 * Class CheckoutOptions
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class CheckoutOptions extends DataObject
{
    /**
     * @return TaxTable
     */
    public function getTaxTable(): TaxTable
    {
        $default = $this->get('default');
        $defaultTaxRate = (new TaxRate)->addRate((float)$default['rate']);

        $taxRules = [];
        foreach ($this->get('alternate') as $alternateData) {
            $taxRules[] = $this->getTaxRule($alternateData);
        }

        $taxTable = new TaxTable($defaultTaxRate, $taxRules, (bool)$default['shipping_taxed']);
        return $taxTable;
    }

    /**
     * @return TaxRule
     */
    private function getTaxRule(array $data): TaxRule
    {
        $taxRule = (new TaxRule)->addName($data['name']);
        foreach ($data['rules'] as $ruleData) {
            $taxRule->addTaxRate($this->getTaxRateByData($ruleData));
        }

        return $taxRule;
    }

    /**
     * @param $data
     * @return TaxRate
     */
    private function getTaxRateByData($data): TaxRate
    {
        return (new TaxRate)
            ->addRate((float)$data['rate'])
            ->addCountry($data['country'] ? new Country($data['country']) : null);
    }
}
