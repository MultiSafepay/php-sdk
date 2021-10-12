<?php declare(strict_types=1);
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Wallets\ApplePay;

use MultiSafepay\Api\Base\RequestBody;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Wallets\ApplePay
 */
class MerchantSessionRequest extends RequestBody
{
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive($this->data);
    }
}
