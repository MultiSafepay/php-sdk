<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\RequestBodyInterface;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Transactions
 */
class CaptureRequest extends RequestBody implements RequestBodyInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive($this->data);
    }
}
