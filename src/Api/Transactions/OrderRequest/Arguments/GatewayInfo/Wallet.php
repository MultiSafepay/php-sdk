<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;

/**
 * Class Wallet
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo
 */
class Wallet implements GatewayInfoInterface
{
    /**
     * @var string
     */
    private $paymentToken;

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'payment_token' => $this->paymentToken,
        ];
    }

    /**
     * @param string $paymentToken
     * @return Wallet
     */
    public function addPaymentToken(string $paymentToken): Wallet
    {
        $this->paymentToken = $paymentToken;

        return $this;
    }
}
