<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Tokens;

/**
 * Class Token
 * @package MultiSafepay\Api\Tokens
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 */
class Token
{
    public const TOKEN_KEY = 'token';
    public const CODE_KEY = 'code';
    public const DISPLAY_KEY = 'display';
    public const BIN_KEY = 'bin';
    public const NAME_HOLDER_KEY = 'name_holder';
    public const EXPIRY_DATE_KEY = 'expiry_date';
    public const EXPIRED_KEY = 'expired';
    public const LAST4_KEY = 'last4';
    public const MODEL_KEY = 'model';

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $gatewayCode;

    /**
     * @var string
     */
    private $display;

    /**
     * @var int
     */
    private $bin;

    /**
     * @var string
     */
    private $nameHolder;

    /**
     * @var int
     */
    private $expiryDate;

    /**
     * @var bool
     */
    private $isExpired;

    /**
     * @var int
     */
    private $lastFour;

    /**
     * @var string
     */
    private $model;

    /**
     * Token constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->token = $data[self::TOKEN_KEY];
        $this->gatewayCode = $data[self::CODE_KEY];
        $this->display = $data[self::DISPLAY_KEY];
        $this->bin = $data[self::BIN_KEY];
        $this->nameHolder = $data[self::NAME_HOLDER_KEY];
        $this->expiryDate = $data[self::EXPIRY_DATE_KEY];
        $this->isExpired = (bool) $data[self::EXPIRED_KEY];
        $this->lastFour = $data[self::LAST4_KEY];
        $this->model = $data[self::MODEL_KEY];
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
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
    public function getDisplay(): string
    {
        return $this->display;
    }

    /**
     * @return string|int
     */
    public function getBin()
    {
        return $this->bin;
    }

    /**
     * @return string
     */
    public function getNameHolder(): string
    {
        return $this->nameHolder;
    }

    /**
     * @return int|string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     *
     */
    public function getExpiryMonth()
    {
        return str_split((string)$this->expiryDate, 2)[1];
    }

    /**
     *
     */
    public function getExpiryYear()
    {
        return str_split((string)$this->expiryDate, 2)[0];
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    /**
     * @return string|int
     */
    public function getLastFour()
    {
        return $this->lastFour;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Return an array with the Token object information
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            self::TOKEN_KEY => $this->token,
            self::CODE_KEY => $this->gatewayCode,
            self::DISPLAY_KEY => $this->display,
            self::BIN_KEY => $this->bin,
            self::NAME_HOLDER_KEY => $this->nameHolder,
            self::EXPIRY_DATE_KEY => $this->expiryDate,
            self::EXPIRED_KEY => $this->isExpired,
            self::LAST4_KEY => $this->lastFour,
            self::MODEL_KEY => $this->model,
        ];
    }
}
