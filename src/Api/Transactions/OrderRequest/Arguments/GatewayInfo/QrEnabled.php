<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as OrderRequestRedirect;

/**
 * Class QrEnabled
 * @package MultiSafepay\Api\Transactions\OrderRequest\GatewayInfo
 */
class QrEnabled implements GatewayInfoInterface
{
    /**
     * @var bool
     */
    private $qrEnabled;

    /**
     * @param bool $qrEnabled
     * @return QrEnabled
     */
    public function addQrEnabled(bool $qrEnabled): QrEnabled
    {
        $this->qrEnabled = $qrEnabled;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'qr_enabled' => (int)$this->qrEnabled,
        ];
    }
}
