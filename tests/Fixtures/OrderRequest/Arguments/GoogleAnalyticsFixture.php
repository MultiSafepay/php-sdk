<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;

/**
 * Trait GoogleAnalyticsFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait GoogleAnalyticsFixture
{
    /**
     * @return GoogleAnalytics
     */
    public function createGoogleAnalyticsFixture(): GoogleAnalytics
    {
        return (new GoogleAnalytics)
            ->addAccountId('foobar');
    }

    /**
     * @return GoogleAnalytics
     */
    public function createRandomGoogleAnalyticsFixture(): GoogleAnalytics
    {
        $faker = FakerFactory::create();
        return (new GoogleAnalytics)
            ->addAccountId($faker->word);
    }
}
