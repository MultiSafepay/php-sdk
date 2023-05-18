<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

/**
 * Class Date
 * @package MultiSafepay\ValueObject
 */
class Date
{
    /**
     * @var int
     */
    private $timestamp = 0;

    /**
     * Country constructor.
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->timestamp = strtotime($date);
    }

    /**
     * @param string $format
     * @return string
     */
    public function get(string $format = 'Y-m-d'): string
    {
        return date($format, $this->timestamp);
    }
}
