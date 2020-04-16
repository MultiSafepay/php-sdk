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
 * Class Response
 * @package MultiSafepay\Api\Base
 */
class RequestBody
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * RequestBody constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->addData($data);
    }

    /**
     * @param array $data
     * @param bool $recursive
     * @return array
     */
    public function addData(array $data, bool $recursive = false): array
    {
        if ($recursive) {
            return $this->data = array_merge_recursive($this->data, $data);
        }

        return $this->data = array_merge($this->data, $data);
    }

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
