<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Exception\InvalidRequestBodyException;
use MultiSafepay\Exception\MissingPluginVersionException;
use MultiSafepay\Util\Version;

/**
 * Class RequestBody
 * @package MultiSafepay\Api\Base
 */
class RequestBody extends DataObject
{
    /**
     * @return array
     */
    public function getData(): array
    {
        if (!isset($this->data['plugin'])) {
            $this->data['plugin'] = [];
        }

        $this->data['plugin']['plugin_version'] = Version::getInstance()->getVersion();

        $this->validate();

        return $this->data;
    }

    /**
     * @param $body
     * @todo: With which API calls would a type be used?
     */
    private function validate(): void
    {
        /*if (!isset($this->data['type'])) {
            throw new InvalidRequestBodyException('No type definition');
        }*/
    }
}
