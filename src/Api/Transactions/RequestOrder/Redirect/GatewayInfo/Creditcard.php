<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Redirect\GatewayInfo;

use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrderRedirect;

/**
 * Class Creditcard
 * @package MultiSafepay\Api\Transactions\RequestOrder\Redirect\GatewayInfo
 */
class Creditcard implements GatewayInfoInterface
{
    /**
     * @var bool
     */
    private $flexible3d;

    /**
     * @var string
     */
    private $termUrl;

    /**
     * Creditcard constructor.
     * @param bool $flexible3d
     * @param string $termUrl
     */
    public function __construct(
        bool $flexible3d = false,
        string $termUrl = ''
    ) {
        $this->flexible3d = $flexible3d;
        $this->termUrl = $termUrl;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'flexible_3d' => $this->flexible3d,
            'term_url' => $this->termUrl,
        ];
    }

    /**
     * @return array
     */
    public function getCompatibleGateways(): array
    {
        return [
            Gateway::VISA,
            Gateway::MASTERCARD,
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
