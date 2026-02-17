<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Unit\Util;

use MultiSafepay\Util\Encode;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{
    /**
     * @return array
     */
    public static function encodeDataProvider(): array
    {
        return [
            'Simple string' => [
                'input' => 'order123',
                'expected' => 'order123',
            ],
            'String with underscore' => [
                'input' => 'order_123',
                'expected' => 'order_123',
            ],
            'String with dashes' => [
                'input' => 'order-123-test',
                'expected' => 'order-123-test',
            ],
            'Partially encoded string' => [
                'input' => 'Order%20ID #1',
                'expected' => 'Order%20ID%20%231',
            ],
            'String with spaces' => [
                'input' => 'Order ID 123',
                'expected' => 'Order%20ID%20123',
            ],
            'Already encoded string (valid hex)' => [
                'input' => 'Order%20ID%20123',
                'expected' => 'Order%20ID%20123',
            ],
            'Literal percent not hex' => [
                'input' => 'order%ID',
                'expected' => 'order%25ID',
            ],
            'Special characters' => [
                'input' => 'test@example.com/foo&bar',
                'expected' => 'test%40example.com%2Ffoo%26bar',
            ],
            'Unicode string' => [
                'input' => 'Order-日本語-123',
                'expected' => 'Order-%E6%97%A5%E6%9C%AC%E8%AA%9E-123',
            ],
            'Plus sign in string' => [
                'input' => 'Order+123',
                'expected' => 'Order%2B123',
            ],
        ];
    }

    /**
     * @dataProvider encodeDataProvider
     * @param string $input
     * @param string $expected
     */
    public function testEncode(string $input, string $expected): void
    {
        $this->assertEquals($expected, Encode::encode($input));
    }
}
