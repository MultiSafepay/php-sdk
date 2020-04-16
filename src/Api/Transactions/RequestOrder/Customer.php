<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions;

use MultiSafepay\Api\Base;

/**
 * Class Customer
 * @package MultiSafepay\Api\Transactions
 */
class Customer extends Base\Customer
{
    /**
     * @param string $locale
     * @return Base\DataObject
     * @todo Add input validation why a value object Locale
     */
    public function addLocale(string $locale)
    {
        return $this->addData(['locale' => $locale]);
    }

    /**
     * @param string $referrer
     * @return Base\DataObject
     * @todo Add input validation why a value object Url
     */
    public function addReferrer(string $referrer)
    {
        return $this->addData(['referrer' => $referrer]);
    }

    /**
     * @param string $userAgent
     * @return Base\DataObject
     */
    public function addUserAgent(string $userAgent)
    {
        return $this->addData(['user_agent' => $userAgent]);
    }
}
