<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Wallets\ApplePay;

use MultiSafepay\Api\Base\RequestBody;

/**
 * Class UpdateRequest
 * @package MultiSafepay\Api\Wallets\ApplePay
 */
class MerchantSessionRequest extends RequestBody
{
    /**
     * @var string
     */
    private $validationUrl;

    /**
     * @var string
     */
    private $originDomain;

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->removeNullRecursive(array_merge(
            [
                'validation_url' => $this->validationUrl ?? null,
                'origin_domain' => $this->originDomain ?? null,
            ],
            $this->data
        ));
    }

    /**
     * @param string $validationUrl
     * @return MerchantSessionRequest
     */
    public function addValidationUrl(string $validationUrl): MerchantSessionRequest
    {
        $this->validationUrl = $validationUrl;
        return $this;
    }

    /**
     * @param string $originDomain
     * @return MerchantSessionRequest
     */
    public function addOriginDomain(string $originDomain): MerchantSessionRequest
    {
        $this->originDomain = $originDomain;
        return $this;
    }
}
