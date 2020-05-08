<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse;

use MultiSafepay\Api\Base\ResponseBody;

/**
 * Class OrderAdjustment
 * @package MultiSafepay\Api\Transactions\TransactionResponse
 */
class OrderAdjustment extends ResponseBody
{
    /**
     * @return string
     */
    public function getTotalAdjustment(): string
    {
        return (string)$this->get('total_adjustment');
    }

    /**
     * @return string
     */
    public function getTotalTax(): string
    {
        return (string)$this->get('total_tax');
    }
}
