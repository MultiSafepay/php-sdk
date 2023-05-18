<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

/**
 * Class SecondChance
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class SecondChance
{
    /**
     * @var bool
     */
    private $sendEmail = false;

    /**
     * @param bool $sendEmail
     * @return SecondChance
     */
    public function addSendEmail(bool $sendEmail): SecondChance
    {
        $this->sendEmail = $sendEmail;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'send_email' => $this->sendEmail,
        ];
    }
}
