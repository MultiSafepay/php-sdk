<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\ValueObject\Customer\Country;

/**
 * Class CheckoutOptions
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class CheckoutOptions extends DataObject
{
    /**
     * @return TaxTable
     * @throws InvalidArgumentException
     */
    public function getTaxTable(): TaxTable
    {
        $default = $this->get('default');
        $defaultTaxRate = (new TaxRate)->addRate((float)$default['rate']);

        $taxRules = [];
        foreach ($this->get('alternate') as $alternateData) {
            $taxRules[] = $this->getTaxRule($alternateData);
        }

        return new TaxTable($defaultTaxRate, $taxRules, (bool)$default['shipping_taxed']);
    }

    /**
     * @param array $data
     * @return TaxRule
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
     */
    private function getTaxRateByData($data): TaxRate
    {
        return (new TaxRate)
            ->addRate((float)$data['rate'])
            ->addCountry($data['country'] ? new Country($data['country']) : null);
    }
}
