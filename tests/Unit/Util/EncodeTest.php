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
     * @return array[]
     */
    public static function findInvalidUtf8FieldsProvider(): array
    {
        return [
            'all valid utf8 strings' => [
                [
                    'name' => 'José',
                    'city' => 'München',
                    'nested' => [
                        'message' => 'こんにちは',
                        'emoji' => '😊',
                    ],
                ],
                '',
                [],
            ],
            'top level invalid utf8' => [
                [
                    'valid' => 'Hello',
                    'invalid' => "\xB1\x31",
                ],
                '',
                ['invalid'],
            ],
            'nested invalid utf8' => [
                [
                    'user' => [
                        'profile' => [
                            'bio' => "\xB1\x31",
                        ],
                    ],
                ],
                '',
                ['user.profile.bio'],
            ],
            'multiple invalid utf8 fields' => [
                [
                    'first' => "\xB1\x31",
                    'nested' => [
                        'second' => "\xC3\x28",
                        'deep' => [
                            'third' => "\xA0\xA1",
                        ],
                    ],
                    'valid' => 'Normal text',
                ],
                '',
                [
                    'first',
                    'nested.second',
                    'nested.deep.third',
                ],
            ],
            'ignores non string values' => [
                [
                    'int' => 123,
                    'float' => 12.34,
                    'bool' => true,
                    'null' => null,
                    'array' => [
                        'items' => [1, 2, 3],
                    ],
                ],
                '',
                [],
            ],
            'uses provided prefix' => [
                [
                    'field' => "\xB1\x31",
                    'nested' => [
                        'child' => "\xC3\x28",
                    ],
                ],
                'root',
                [
                    'root.field',
                    'root.nested.child',
                ],
            ],
            'empty input' => [
                [],
                '',
                [],
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

    /**
     * Tests the findInvalidUtf8Fields method with various input scenarios
     *
     * @dataProvider findInvalidUtf8FieldsProvider
     * @param array $data
     * @param string $prefix
     * @param array $expected
     * @return void
     */
    public function testFindInvalidUtf8Fields(array $data, string $prefix, array $expected): void
    {
        $result = Encode::findInvalidUtf8Fields($data, $prefix);

        $this->assertSame($expected, $result);
    }
}
