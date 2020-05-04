<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Direct\GatewayInfo;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrderDirect;

/**
 * Class QrCode
 * @package MultiSafepay\Api\Transactions\RequestOrder\Direct\GatewayInfo
 */
class QrCode implements GatewayInfoInterface
{
    /**
     * @var int
     */
    private $qrSize;

    /**
     * @var bool
     */
    private $allowMultiple;

    /**
     * @var bool
     */
    private $allowChangeAmount;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * QrCode constructor.
     * @param int $qrSize
     * @param bool $allowMultiple
     * @param bool $allowChangeAmount
     * @param int $maxAmount
     */
    public function __construct(
        int $qrSize = 250,
        bool $allowMultiple = false,
        bool $allowChangeAmount = false,
        int $maxAmount = 1000
    ) {
        $this->qrSize = $qrSize;
        $this->allowMultiple = $allowMultiple;
        $this->allowChangeAmount = $allowChangeAmount;
        $this->maxAmount = $maxAmount;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'qr_size' => $this->qrSize,
            'allow_multiple' => $this->allowMultiple,
            'allow_change_amount' => $this->allowChangeAmount,
            'max_amount' => $this->maxAmount,
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
            Gateway::IDEALQR
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleTypes(): array
    {
        return [
            RequestOrderDirect::TYPE
        ];
    }
}
