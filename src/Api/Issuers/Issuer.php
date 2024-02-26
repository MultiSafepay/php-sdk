<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Issuers;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Issuer
 * @package MultiSafepay\Api\Issuers
 */
class Issuer
{
    /**
     * @const string[]
     */
    public const ALLOWED_GATEWAY_CODES = ['ideal', 'mybank'];

    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * Issuer constructor.
     * @param string $gatewayCode
     * @param string $code
     * @param string $description
     * @throws InvalidArgumentException
     */
    public function __construct(string $gatewayCode, string $code, string $description)
    {
        $this->validateGatewayCode($gatewayCode);
        $this->gatewayCode = strtoupper($gatewayCode);
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @param string $gatewayCode
     * @return bool
     * @throws InvalidArgumentException
     */
    private function validateGatewayCode(string $gatewayCode): bool
    {
        $gatewayCode = strtolower($gatewayCode);
        if (!in_array($gatewayCode, self::ALLOWED_GATEWAY_CODES)) {
            throw new InvalidArgumentException('Gateway code is not allowed');
        }

        return true;
    }

    /**
     * @return string
     */
    public function getGatewayCode(): string
    {
        return $this->gatewayCode;
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
    public function getDescription(): string
    {
        return $this->description;
    }
}
