<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Affiliate;
use MultiSafepay\ValueObject\Money;

/**
 * Trait AffiliateFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait AffiliateFixture
{
    /**
     * @return Affiliate
     */
    public function createAffiliateFixture(?string $merchantId = '00000001'): Affiliate
    {
        $splitPayment = new Affiliate\SplitPayment();
        $splitPayment->addMerchant($merchantId);
        $splitPayment->addFixed(new Money(10));
        $splitPayment->addDescription('test description');

        return new Affiliate([$splitPayment]);
    }
}
