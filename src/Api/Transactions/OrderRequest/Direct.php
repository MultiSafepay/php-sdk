<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest;

use MultiSafepay\Api\Transactions\OrderRequest;

/**
 * Class Direct
 * @package MultiSafepay\Api\Transactions\OrderRequest
 */
class Direct extends OrderRequest
{
    /**
     * @var string
     */
    protected $type = 'direct';

    /**
     * @param array $data
     * @return bool
     */
    protected function validate(array $data): bool
    {
        return parent::validate($data);
    }
}
