<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class IpAddress
 * @package MultiSafepay\ValueObject
 */
class IpAddress
{
    /**
     * @var string
     */
    private $ipAddress;

    /**
     * Country constructor.
     * @param string $ipAddress
     * @throws InvalidArgumentException
     */
    public function __construct(string $ipAddress)
    {
        // Clean up in case of comma-separated IPs
        $ipAddressList = explode(',', $ipAddress);
        $ipAddress = trim(reset($ipAddressList));

        if (filter_var($ipAddress, FILTER_VALIDATE_IP) === false) {
            throw new InvalidArgumentException('Value "' . $ipAddress . '" is not a valid IP address');
        }

        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->ipAddress;
    }
}
