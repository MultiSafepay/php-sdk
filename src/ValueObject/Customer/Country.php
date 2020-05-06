<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

use League\ISO3166\ISO3166;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Country
 * @package MultiSafepay\ValueObject\Customer
 */
class Country
{
    /**
     * @var string
     */
    private $code = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var ISO3166
     */
    private $iso3166;

    /**
     * Country constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        if (strlen($code) !== 2) {
            throw new InvalidArgumentException('Country code should be 2 characters (ISO3166 alpha 2)');
        }

        $code = strtoupper($code);
        $this->iso3166 = new ISO3166;
        $data = $this->iso3166->alpha2($code);
        if (empty($data) || empty($data['name'])) {
            throw new InvalidArgumentException('Unknown country code');
        }

        $this->name = $data['name'];
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
