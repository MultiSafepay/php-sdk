<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Pager;

/**
 * Class Cursor
 *
 * @package MultiSafepay\Api\Pager
 */
class Cursor
{
    public const AFTER_NAME = 'after';
    public const BEFORE_NAME = 'before';

    /**
     * @var string|null
     */
    private $after;

    /**
     * @var string|null
     */
    private $before;

    /**
     * Pager constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->after = $data[self::AFTER_NAME] ?? null;
        $this->before = $data[self::BEFORE_NAME] ?? null;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            self::AFTER_NAME => $this->getAfter(),
            self::BEFORE_NAME => $this->getBefore(),
        ];
    }

    /**
     * @return string|null
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * @return string|null
     */
    public function getBefore()
    {
        return $this->before;
    }
}
