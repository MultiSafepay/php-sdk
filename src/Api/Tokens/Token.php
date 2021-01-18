<?php
/**
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
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
    private $token;
    private $gatewayCode;
    private $display;
    private $bin;
    private $nameHolder;
    private $expiryDate;
    private $isExpired;
    private $lastFour;
    private $model;

    /**
     * Token constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->token = $data['token'];
        $this->gatewayCode = $data['code'];
        $this->display = $data['display'];
        $this->bin = $data['bin'];
        $this->nameHolder = $data['name_holder'];
        $this->expiryDate = $data['expiry_date'];
        $this->isExpired = (bool) $data['expired'];
        $this->lastFour = $data['last4'];
        $this->model = $data['model'];
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
    public function isExpired():bool
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
}
