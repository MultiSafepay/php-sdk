<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails;

use MultiSafepay\Api\Base\DataObject;

/**
 * Class CardAuthenticationDetails
 * @package MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails
 */
class CardAuthenticationDetails extends DataObject
{
    /**
     * Get the card authentication flow.
     *
     * @return string|null
     */
    public function getFlow(): ?string
    {
        return $this->get('flow');
    }
}
