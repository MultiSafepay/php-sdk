<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Arguments;

/**
 * Class SecondChance
 * @package MultiSafepay\Api\Transactions\RequestOrder\Arguments
 */
class SecondChance
{
    /**
     * @var bool
     */
    private $sendEmail;

    /**
     * SecondChance constructor.
     * @param bool $sendEmail
     */
    public function __construct(bool $sendEmail)
    {
        $this->sendEmail = $sendEmail;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'send_email' => $this->sendEmail
        ];
    }
}
