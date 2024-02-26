<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Wallets\ApplePay;

use MultiSafepay\Exception\InvalidDataInitializationException;

/**
 * Class MerchantSession
 *
 * @package MultiSafepay\Api\Wallets\ApplePay
 */
class MerchantSession
{
    /**
     * @var string
     */
    private $merchantSession;

    /**
     * ApiToken constructor.
     *
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->merchantSession = $data['session'];
    }

    /**
     * @return string
     */
    public function getMerchantSession(): string
    {
        return $this->merchantSession;
    }

    /**
     * @param array $data
     * @throws InvalidDataInitializationException
     */
    private function validate(array $data): void
    {
        if (!isset($data['session'])) {
            throw new InvalidDataInitializationException('No Merchant Session was found');
        }
    }
}
