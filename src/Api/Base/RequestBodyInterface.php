<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

/**
 * Class RequestBodyInterface
 * @package MultiSafepay\Api\Base
 */
interface RequestBodyInterface
{
    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @param bool $strictMode
     * @return void
     */
    public function useStrictMode(bool $strictMode);
}
