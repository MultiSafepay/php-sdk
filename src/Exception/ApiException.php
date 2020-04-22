<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Exception;

use LogicException;

class ApiException extends LogicException
{
    /**
     * @param array $additionalData
     * @return string
     */
    public function getDetails(array $additionalData = []): string
    {
        $lines = [];
        $lines[] = ApiException::class . ': ' . $this->getMessage();
        $lines[] = 'Additional data: ' . var_export($additionalData, true);
        return implode("\n", $lines);
    }
}
