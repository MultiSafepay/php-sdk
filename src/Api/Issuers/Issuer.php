<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Issuers;

use InvalidArgumentException;

/**
 * Class Issuer
 * @package MultiSafepay\Api\Issuers
 */
class Issuer
{
    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * @const string[]
     */
    const ALLOWED_GATEWAY_CODES = ['ideal'];

    /**
     * Issuer constructor.
     * @param string $gatewayCode
     * @param int $code
     * @param string $description
     */
    public function __construct(string $gatewayCode, int $code, string $description)
    {
        $this->initGatewayCode($gatewayCode);
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @param string $gatewayCode
     * @todo Replace exception with MSP-specific exception
     */
    private function initGatewayCode(string $gatewayCode)
    {
        $gatewayCode = strtolower($gatewayCode);
        if (!in_array($gatewayCode, self::ALLOWED_GATEWAY_CODES)) {
            throw new InvalidArgumentException('Gateway code is not allowed');
        }

        $this->gatewayCode = $gatewayCode;
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return $this->gatewayCode;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
