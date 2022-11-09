<?php declare(strict_types=1);
namespace MultiSafepay\Api\Transactions\OrderRequest\Validators;

use MultiSafepay\Exception\InvalidTotalAmountException;

/**
 * Class TotalAmount
 */
class TotalAmountValidator
{
    /**
     * @param array $data
     * @return bool
     * @throws InvalidTotalAmountException
     */
    public function validate(array $data): bool
    {
        if (!isset($data['amount'])) {
            return false;
        }

        if (!isset($data['shopping_cart']['items'])) {
            return false;
        }

        $amount = $data['amount'];
        $totalUnitPrice = $this->calculateTotals($data);

        if ($totalUnitPrice != $amount) {
            $msg = sprintf('Total of unit_price (%s) does not match amount (%s)', $totalUnitPrice, $amount);
            $msg .= "\n" . json_encode($data, JSON_PRETTY_PRINT);
            throw new InvalidTotalAmountException($msg);
        }

        return true;
    }

    /**
     * @param array $data
     * @return float
     */
    private function calculateTotals(array $data): float
    {
        $totalUnitPrice = 0;
        foreach ($data['shopping_cart']['items'] as $item) {
            $taxRate = $this->getTaxRateByItem($item, $data);
            $itemPrice = $item['unit_price'] * $item['quantity'];
            $itemPrice = $itemPrice + ($taxRate * $itemPrice);
            $totalUnitPrice = +$itemPrice;
        }

        return (float)$totalUnitPrice * 100;
    }

    /**
     * @param array $item
     * @param array $data
     * @return float
     */
    private function getTaxRateByItem(array $item, array $data): float
    {
        if (empty($item['tax_table_selector'])) {
            return 0;
        }

        if (!isset($data['checkout_options']['tax_tables']['alternate'])) {
            return 0;
        }

        foreach ($data['checkout_options']['tax_tables']['alternate'] as $taxTable) {
            if ($taxTable['name'] !== $item['tax_table_selector']) {
                continue;
            }

            $taxRule = array_shift($taxTable['rules']);
            return $taxRule['rate'];
        }

        return 0;
    }
}
