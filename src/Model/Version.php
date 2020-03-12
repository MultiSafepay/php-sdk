<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Model;

class Version
{
    public const SDK_VERSION = '1.0.0';

    /**
     * @param $orderData
     * @return array
     */
    public static function append($orderData): array
    {
        $orderData['plugin']['plugin_version'] .= ' - PHP SDK ' . self::SDK_VERSION;

        return $orderData;
    }
}
