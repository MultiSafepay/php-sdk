<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Api\Pager;

use MultiSafepay\Api\Pager\Cursor;
use PHPUnit\Framework\TestCase;

class CursorTest extends TestCase
{
    /**
     * Test whether the after string could be fetched
     */
    public function testGetAfter(): void
    {
        $testCursor = new Cursor(['after' => '12345', 'before' => '54321']);
        $this->assertEquals('12345', $testCursor->getAfter());
    }

    /**
     * Test whether the before string could be fetched
     */
    public function testGetBefore(): void
    {
        $testCursor = new Cursor(['after' => '12345', 'before' => '54321']);
        $this->assertEquals('54321', $testCursor->getBefore());
    }
}
