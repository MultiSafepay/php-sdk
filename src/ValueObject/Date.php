<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Exception\InvalidArgumentException;

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
     * @return string
     */
    public function get(): string
    {
        return date('Y-m-d', $this->timestamp);
    }
}
