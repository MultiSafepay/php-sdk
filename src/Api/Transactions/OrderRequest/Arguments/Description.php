<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
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
    private $description = '';

    /**
     * @param string $description
     * @return Description
     */
    public static function fromText(string $description): Description
    {
        return (new Description)->addDescription($description);
    }

    /**
     * @param string $description
     * @return Description
     */
    public function addDescription(string $description): Description
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getData(): string
    {
        $this->validate();

        return strip_tags($this->description);
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(): bool
    {
        if (strlen($this->description) > 200) {
            throw new InvalidArgumentException('Description can not be more than 200 characters');
        }

        return true;
    }
}
