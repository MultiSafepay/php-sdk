<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Utils;

use MultiSafepay\Exception\MissingPluginVersionException;
use RuntimeException;

/**
 * Class Locale
 * @package MultiSafepay\Tests\Utils
 */
class Locale
{
    /**
     * @param string $countryCode
     * @return string
     */
    public static function getLocaleByCountryCode(string $countryCode): string
    {
        return strtolower($countryCode) . '_' . $countryCode;
    }
}
