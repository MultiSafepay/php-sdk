<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Issuers;

/**
 * Class IssuerListing
 * @package MultiSafepay\Api\Issuers
 */
class IssuerListing
{
    private $issuers;

    /**
     * Issuers constructor.
     * @param string $gatewayCode
     * @param string[] $data
     */
    public function __construct(string $gatewayCode, array $data)
    {
        foreach ($data as $issuerData) {
            $this->issuers[] = new Issuer($gatewayCode, $issuerData['code'], $issuerData['description']);
        }
    }

    /**
     * @return Issuer[]
     */
    public function getIssuers(): array
    {
        return $this->issuers;
    }
}
