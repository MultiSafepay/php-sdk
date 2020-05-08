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
     * @todo: Move these constructors to TaxRate, TaxRule classes themselves
     */
    public function getTaxTable(): TaxTable
    {
        $default = $this->get('default');
        $defaultTaxRate = new TaxRate((float)$default['rate']);

        $taxRules = [];
        foreach ($this->get('alternate') as $alternateData) {
            $taxRates = [];
            foreach ($alternateData['rules'] as $ruleData) {
                $taxRates[] = $this->getTaxRateByData($ruleData);
            }
            $taxRules[] = new TaxRule($alternateData['name'], $taxRates);
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
        return new TaxRate(
            (float)$data['rate'],
            $data['country'] ? new Country($data['country']) : null,
            (string)$data['state'],
            (string)$data['postcode']
        );
    }
}
