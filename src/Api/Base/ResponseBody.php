<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Util\Version;

/**
 * Class ResponseBody
 * @package MultiSafepay\Api\Base
 */
class ResponseBody extends DataObject implements ResponseBodyInterface
{
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
