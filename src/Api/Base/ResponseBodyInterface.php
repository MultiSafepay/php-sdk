<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

/**
 * Class ResponseBodyInterface
 * @package MultiSafepay\Api\Base
 */
interface ResponseBodyInterface
{
    /**
     * @return array
     */
    public function getData(): array;
}
