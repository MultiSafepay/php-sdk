<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Util\Version;

/**
 * Class RequestBody
 * @package MultiSafepay\Api\Base
 */
class RequestBody extends DataObject implements RequestBodyInterface
{
    /**
     * @return array
     */
    public function getData(): array
    {
        $this->data['plugin']['plugin_version'] = Version::getInstance()->getVersion();
        return $this->data;
    }
}
