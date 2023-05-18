<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Pager;

/**
 * Class Pager
 *
 * @package MultiSafepay\Api\Pager
 */
class Pager
{
    public const AFTER_NAME = 'after';
    public const BEFORE_NAME = 'before';
    public const LIMIT_NAME = 'limit';
    public const CURSOR_NAME = 'cursor';

    /**
     * @var string|null
     */
    private $after;

    /**
     * @var string|null
     */
    private $before;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var Cursor
     */
    private $cursor;

    /**
     * Pager constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->after = $data[self::AFTER_NAME] ?? null;
        $this->before = $data[self::BEFORE_NAME] ?? null;
        $this->limit = $data[self::LIMIT_NAME] ?? null;
        $this->cursor = new Cursor($data[self::CURSOR_NAME] ?? []);
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            self::AFTER_NAME => $this->getAfter(),
            self::BEFORE_NAME => $this->getBefore(),
            self::LIMIT_NAME => $this->getLimit(),
            self::CURSOR_NAME => $this->getCursor()->getData(),
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

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return Cursor
     */
    public function getCursor(): Cursor
    {
        return $this->cursor;
    }
}
