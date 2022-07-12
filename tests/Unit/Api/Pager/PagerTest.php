<?php declare(strict_types=1);
/**
 * Copyright © 2022 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Api\Pager;

use MultiSafepay\Api\Pager\Cursor;
use MultiSafepay\Api\Pager\Pager;
use PHPUnit\Framework\TestCase;

class PagerTest extends TestCase
{
    /** @var Pager */
    private $testData = [
        'after' => 'https://example.com/12345',
        'before' => 'https://example.com/54321',
        'limit' => 100,
        'cursor' => [
            'after' => '12345',
            'before' => '54321',
        ],
    ];

    /**
     * Test whether the after string could be fetched
     */
    public function testGetAfter(): void
    {
        $testPager = new Pager($this->testData);
        $this->assertEquals('https://example.com/12345', $testPager->getAfter());
    }

    /**
     * Test whether the before string could be fetched
     */
    public function testGetBefore(): void
    {
        $testPager = new Pager($this->testData);
        $this->assertEquals('https://example.com/54321', $testPager->getBefore());
    }

    /**
     * Test whether the limit could be fetched
     */
    public function testGetLimit(): void
    {
        $testPager = new Pager($this->testData);
        $this->assertEquals(100, $testPager->getLimit());
    }

    /**
     * Test whether the cursor is actually a Cursor object
     */
    public function testGetCursor(): void
    {
        $testPager = new Pager($this->testData);
        $this->assertInstanceOf(Cursor::class, $testPager->getCursor());
    }

    /**
     * Test missing data when initializing a new Pager object
     */
    public function testMissingData(): void
    {
        $pager = new Pager([]);
        $this->assertEquals(null, $pager->getLimit());
        $this->assertEquals(null, $pager->getBefore());
        $this->assertEquals(null, $pager->getAfter());
    }
}
