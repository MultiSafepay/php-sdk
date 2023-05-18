<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;

/**
 * Trait SecondChanceFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait SecondChanceFixture
{
    /**
     * @return SecondChance
     */
    public function createSecondChanceFixture(): SecondChance
    {
        return (new SecondChance)
            ->addSendEmail(false);
    }
}
