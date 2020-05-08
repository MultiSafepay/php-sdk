<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\ResponseBody;
use MultiSafepay\ValueObject\Customer\Country;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRate;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable\TaxRule;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\TaxTable;

/**
 * Class CheckoutOptions
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class CheckoutOptions extends ResponseBody
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
            $taxRule = (new TaxRule)->addName($alternateData['name']);
            foreach ($alternateData['rules'] as $ruleData) {
                $taxRule->addTaxRate($this->getTaxRateByData($ruleData));
            }

            $taxRules[] = $taxRule;
        }

        $taxTable = new TaxTable($defaultTaxRate, $taxRules, (bool)$default['shipping_taxed']);
        return $taxTable;
    }

    /**
     * @param $data
     * @return TaxRate
     */
    private function getTaxRateByData($data): TaxRate
    {
        return (new TaxRate)
            ->addRate((float)$data['rate'])
            ->addCountry($data['country'] ? new Country($data['country']) : null)
            ->addState((string)$data['state'])
            ->addPostcode((string)$data['postcode']);
    }
}
