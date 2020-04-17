<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Base;

use MultiSafepay\Util\Version;

/**
 * Class DataObject
 * @package MultiSafepay\Api\Base
 */
class DataObject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * RequestBody constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->addData($data);
    }

    /**
     * @param array $data
     * @param bool $recursive
     * @return DataObject
     */
    public function addData(array $data, bool $recursive = false): DataObject
    {
        if ($recursive) {
            $this->data = array_merge_recursive($this->data, $data);
            return $this;
        }

        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->data[$name];
    }

    /**
     * @param string $name
     * @param $value
     */
    private function set(string $name, $value)
    {
        $this->data['name'] = $value;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
