<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Gender
 * @package MultiSafepay\ValueObject
 */
class Gender
{
    /**
     * Allowed values
     */
    public const ALLOWED_VALUES = ['male', 'female', 'mr', 'mrs', 'miss'];

    /**
     * @var string
     */
    private $gender = 'female';

    /**
     * Country constructor.
     * @param string $gender
     * @throws InvalidArgumentException
     */
    public function __construct(string $gender = 'female')
    {
        if (!in_array($gender, self::ALLOWED_VALUES)) {
            throw new InvalidArgumentException('Gender "'.$gender.'" value is unknown');
        }

        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->gender;
    }
}
