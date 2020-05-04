<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder;

use MultiSafepay\ValueObject\Creditcard\CardNumber;
use MultiSafepay\ValueObject\Creditcard\Cvc;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Date;
use MultiSafepay\ValueObject\Gender;

/**
 * Class GatewayInfoRedirectCreditcard
 * @package MultiSafepay\Api\Transactions\RequestOrder
 */
class GatewayInfoRedirectCreditcard implements GatewayInfoInterface
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
     * GatewayInfoCreditcard constructor.
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
            'flexible_3d' => $this->flexible3d
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
