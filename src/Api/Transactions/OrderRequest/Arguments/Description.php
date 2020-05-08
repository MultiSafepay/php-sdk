<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class Description
 * @package MultiSafepay\Api\Transactions\OrderRequest\Arguments
 */
class Description
{
    /**
     * @var string
     */
    private $description;

    /**
     * GoogleAnalytics constructor.
     * @param string $description
     */
    public function __construct(string $description)
    {
        if (strlen($description) > 200) {
            throw new InvalidArgumentException('Description can not be more than 200 characters');
        }

        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->description;
    }
}
