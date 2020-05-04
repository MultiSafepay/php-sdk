<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Transactions\RequestOrder\Redirect;

use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\CustomerDetails;
use MultiSafepay\Api\Transactions\RequestOrder\Description;
use MultiSafepay\Api\Transactions\RequestOrder\GatewayInfoInterface;
use MultiSafepay\Api\Transactions\RequestOrder\PaymentOptions;
use MultiSafepay\Api\Transactions\RequestOrderRedirect;
use MultiSafepay\ValueObject\Customer;
use MultiSafepay\ValueObject\ShoppingCart;
use MultiSafepay\ValueObject\Tax\TaxTable;

/**
 * Class Payafter
 * @package MultiSafepay\Api\Transactions\RequestOrder\Redirect
 */
class Payafter extends RequestOrderRedirect
{
    /**
     * @var CustomerDetails
     */
    private $customerDetails;
    /**
     * @var Customer
     */
    private $delivery;
    /**
     * @var ShoppingCart
     */
    private $shoppingCart;
    /**
     * @var TaxTable
     */
    private $taxTable;

    /**
     * Payafter constructor.
     * @param string $orderId
     * @param Money $money
     * @param string $gatewayCode
     * @param PaymentOptions $paymentOptions
     * @param GatewayInfoInterface $gatewayInfo
     * @param CustomerDetails $customerDetails
     * @param Customer $delivery
     * @param ShoppingCart $shoppingCart
     * @param TaxTable $taxTable
     * @param Description|null $description
     */
    public function __construct(
        string $orderId,
        Money $money,
        string $gatewayCode,
        PaymentOptions $paymentOptions,
        GatewayInfoInterface $gatewayInfo,
        CustomerDetails $customerDetails,
        Customer $delivery,
        ShoppingCart $shoppingCart,
        TaxTable $taxTable,
        Description $description = null
    ) {
        parent::__construct($orderId, $money, $gatewayCode, $paymentOptions, $gatewayInfo, $description);
        $this->customerDetails = $customerDetails;
        $this->delivery = $delivery;
        $this->shoppingCart = $shoppingCart;
        $this->taxTable = $taxTable;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = parent::getData();
        $data['plugin'] = $this->getPluginData();
        $data['customer'] = $this->customerDetails->getData();
        $data['delivery'] = $this->delivery->getData();
        $data['shopping_cart'] = $this->shoppingCart->getData();
        $data['checkout_options'] = [
            'tax_tables' => $this->taxTable->getData()
        ];

        return $data;
    }

    /**
     * @return array
     * @todo: Do all these values need to be in here?
     */
    private function getPluginData(): array
    {
        return [
            'shop' =>  'ApiTestTool',
            'plugin_version' => '1.0.0',
            'shop_version' => '1',
            'partner' => 'partner',
            'shop_root_url' => 'https://multisafepay.com'
        ];
    }
}
