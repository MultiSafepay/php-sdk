<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\RequestBodyInterface;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Transactions
 */
class CaptureRequest extends RequestBody
{
    public const CAPTURE_MANUAL_TYPE = 'manual';

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive($this->data);
    }
}
