<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures;

trait Order
{
    /**
     * @return array
     */
    public function createOrder(): array
    {
        $orderId = time();
        return [
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
                'locale' => 'en',
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
            ],
            'plugin' => [
            'shop' => 'Testshop',
            'plugin_version' => '1.6.4',
            'partner' => 'MultiSafepay'
            ]
        ];
    }
}
