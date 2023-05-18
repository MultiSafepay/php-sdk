<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest\Arguments;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;

/**
 * Trait DescriptionFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest\Arguments
 */
trait DescriptionFixture
{
    /**
     * @return Description
     */
    public function createDescriptionFixture(): Description
    {
        return (new Description)
            ->addDescription('foobar');
    }

    /**
     * @return Description
     */
    public function createRandomDescriptionFixture(): Description
    {
        $faker = FakerFactory::create();
        return (new Description)
            ->addDescription($faker->word);
    }
}
