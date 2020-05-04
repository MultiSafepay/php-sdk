<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Redirect\GatewayInfo;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrder\Redirect as RequestOrderRedirect;

/**
 * Class QrEnabled
 * @package MultiSafepay\Api\Transactions\RequestOrder\Redirect\GatewayInfo
 */
class QrEnabled implements GatewayInfoInterface
{
    /**
     * @var bool
     */
    private $qrEnabled;

    /**
     * QrEnabled constructor.
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
            Gateway::MISTERCASH
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleTypes(): array
    {
        return [
            RequestOrderRedirect::TYPE
        ];
    }
}
