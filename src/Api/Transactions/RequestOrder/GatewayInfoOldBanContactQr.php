<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

/**
 * Class GatewayInfoBanContactQr
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfoBanContactQr implements GatewayInfoInterface
{
    /**
     * @var bool
     */
    private $qrEnabled;

    /**
     * GatewayInfoIdeal constructor.
     * @param bool $qrEnabled
     */
    public function __construct(bool $qrEnabled = true)
    {
        $this->qrEnabled = $qrEnabled;
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


    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleTypes(): array
    {
        return [
            'redirect'
        ];
    }
}
