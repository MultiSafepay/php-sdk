<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Api;

use MultiSafepay\Api;
use MultiSafepay\Exception\ApiException;
use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase
{
    /**
     * Test the creation of a transaction
     */
    public function testCreateTransactionWithValidData()
    {
        $orderData = [
            'type' => 'redirect',
            'order_id' => time(),
            'currency' => 'EUR',
            'amount' => 1,
            'description' => 'Test transaction'
        ];

        $multiSafepay = new Api(getenv('API_KEY'), false);
        $paymentLink = $multiSafepay->transactions()->create($orderData)->getPaymentLink();

        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/', $paymentLink);
    }


    /**
     * Test the return of an Exception when an invalid API key is being used.
     */
    public function testCreateTransactionWithInvalidApiKey()
    {
        $orderData = [
            'type' => 'redirect',
            'order_id' => time(),
            'currency' => 'EUR',
            'amount' => 1,
            'description' => 'lorem ipsum'
        ];

        $multiSafepay = new Api('__invalid__', false);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1032);
        $this->expectExceptionMessage('Invalid API key');
        $multiSafepay->transactions()->create($orderData);
    }

    /**
     * Test the creation of a PAD transaction
     *
     * @return int
     * @throws \Http\Client\Exception
     */
    public function testCreatePADTransaction(): int
    {
        $orderId = time();
        $orderData = [
            'type' => 'direct',
            'gateway' => 'PAYAFTER',
            'order_id' => $orderId,
            'currency' => 'EUR',
            'amount' => 25200,
            'description' => 'Order to Test SDK',
            'gateway_info' => [
                'birthday' => '1980-01-30',
                'bank_account' => '0417164300',
                'phone' => '0208500500',
                'email' => 'example@multisafepay.com'
            ],
            'customer' => [
                'locale' => 'nl',
                'ip_address' => '89.20.162.110',
                'first_name' => 'msp',
                'last_name' => 'MultiSafepay',
                'address1' => 'Kraanspoor',
                'house_number' => '39',
                'zip_code' => '1033 SC',
                'city' => 'Amsterdam',
                'country' => 'NL',
                'email' => 'example@multisafepay.com',
            ],
            'delivery' => [
                'first_name' => 'msp',
                'last_name' => 'MultiSafepay',
                'address1' => 'Kraanspoor',
                'house_number' => '39',
                'zip_code' => '1033 SC',
                'city' => 'Amsterdam',
                'country' => 'NL',
            ],
            'shopping_cart' => [
                'items' => [
                    [
                        'name' => 'Geometric Candle Holders',
                        'unit_price' => '100',
                        'quantity' => '2',
                        'merchant_item_id' => '111111',
                        'tax_table_selector' => 'BTW21',
                        'weight' => [
                            'unit' => 'KG',
                            'value' => '12'
                        ]
                    ],
                    [
                        'name' => 'Flat Rate - Fixed',
                        'description' => 'Shipping',
                        'unit_price' => '10',
                        'quantity' => '1',
                        'merchant_item_id' => 'msp-shipping',
                        'tax_table_selector' => 'none',
                        'weight' => [
                            'unit' => 'KG',
                            'value' => '0'
                        ]
                    ]
                ]
            ],
            'checkout_options' => [
                'tax_tables' => [
                    'default' => [
                        'shipping_taxed' => 'true',
                        'rate' => '0.21'
                    ],
                    'alternate' => [
                        [
                            'name' => 'BTW21',
                            'standalone' => true,
                            'rules' => [
                                [
                                    'rate' => '0.21'
                                ]
                            ]
                        ],
                        [
                            'name' => 'none',
                            'standalone' => true,
                            'rules' => [
                                [
                                    'rate' => '0.00'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $multiSafepay = new Api(getenv('API_KEY'), false);
        $response = $multiSafepay->transactions()->create($orderData)->getData();

        $this->assertEquals('completed', $response['status']);

        return $orderId;
    }

    /**
     * Test the return of an Exception when an invalid API key is being used.
     *
     * @param string $orderId
     * @depends testCreatePADTransaction
     */
    public function testGetTransactionWithInvalidApiKey(string $orderId): void
    {
        $multiSafepay = new Api('__invalid__', false);
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1006);
        $this->expectExceptionMessage('Invalid transaction ID');
        $multiSafepay->transactions()->get($orderId)->getData();
    }

    /**
     * @param string $orderId
     * @depends testCreatePADTransaction
     */
    public function testGetTransaction(string $orderId)
    {
        $multiSafepay = new Api(getenv('API_KEY'), false);
        $transactionData = $multiSafepay->transactions()->get($orderId)->getData();

        $this->assertEquals($orderId, $transactionData['order_id']);
        $this->assertEquals('completed', $transactionData['status']);
        $this->assertEquals('MultiSafepay', $transactionData['customer']['last_name']);

        // Test if amount is the same as the shopping cart amount
        $totalInclTax = 0;

        # Default tax-rate
        $taxes['default'] = $transactionData['checkout_options']['default']['rate'];

        # Get rest of tax-rates
        foreach ($transactionData['checkout_options']['alternate'] as $tax) {
            $taxes[$tax['name']] = $tax['rules'][0]['rate'];
        }

        # Get total amount of all items in the shopping-cart
        foreach ($transactionData['shopping_cart']['items'] as $item) {
            $rate = $taxes[$item['tax_table_selector']] ?? $taxes['default'];
            $totalInclTax += ($item['unit_price'] * $item['quantity']) * (1 + $rate);
        }

        $this->assertEquals($transactionData['amount'], $totalInclTax * 100);
    }


    /**
     * @param string $orderId
     * @depends testCreatePADTransaction
     */
    public function testTransactionWithPaymentLinkAsNull(string $orderId): void
    {
        $multiSafepay = new Api(getenv('API_KEY'), false);
        $paymentLink = $multiSafepay->transactions()->get($orderId)->getPaymentLink();

        $this->assertNull($paymentLink);
    }
}
