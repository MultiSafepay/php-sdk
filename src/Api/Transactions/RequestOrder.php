<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use InvalidArgumentException;
use MultiSafepay\Api\Base;

/**
 * Class RequestOrder
 * @package MultiSafepay\Api\Transactions
 */
class RequestOrder extends Base\RequestBody
{
    const ALLOWED_TYPES = ['direct', 'redirect'];

    /**
     * RequestOrder constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->addInitialData();
        parent::__construct($data);
    }

    /**
     * Add initial data
     */
    private function addInitialData()
    {
        $this->addType('direct');
    }

    /**
     * @param string $type
     */
    public function addType(string $type)
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('Type "' . $type . '" is not allowed');
        }

        $this->addData(['type' => $type]);
    }
}
