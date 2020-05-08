<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\OrderRequest;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\OrderRequest\Direct as DirectOrderRequest;

/**
 * Trait DirectFixture
 * @package MultiSafepay\Tests\Fixtures\OrderRequest
 */
trait DirectFixture
{
    /**
     * @return DirectOrderRequest
     */
    public function createOrderIdealDirectRequestFixture(): DirectOrderRequest
    {
        $orderId = (string)time();
        $money = Money::EUR(20);
        $gatewayCode = Gateway::IDEAL;
        $gatewayInfo = new IdealGatewayInfo('0021');
        $paymentOptions = $this->createPaymentOptionsFixture();

        $request = new DirectOrderRequest(
            $orderId,
            $money,
            $gatewayCode,
            $gatewayInfo,
            $paymentOptions
        );

        $request->addDescription(new Description('Foobar'));
        $request->addCustomerDetails($this->createCustomerDetailsFixture());
        $request->addSecondChance(new SecondChance(true));
        $request->addGoogleAnalytics(new GoogleAnalytics('foobar'));
        $request->addPluginDetails(new PluginDetails('Foobar', '0.0.1'));

        return $request;
    }

    /**
     * @return DirectOrderRequest
     */
    public function createRandomOrderIdealDirectRequestFixture(): DirectOrderRequest
    {
        $faker = FakerFactory::create();
        $orderId = (string)time();
        $money = Money::EUR(20);
        $gatewayCode = Gateway::IDEAL;
        $gatewayInfo = new IdealGatewayInfo('0021');
        $paymentOptions = $this->createPaymentOptionsFixture();

        $request = new DirectOrderRequest(
            $orderId,
            $money,
            $gatewayCode,
            $gatewayInfo,
            $paymentOptions
        );

        $request->addDescription(new Description($faker->sentence));
        $request->addCustomerDetails($this->createCustomerDetailsFixture());
        $request->addSecondChance(new SecondChance(true));
        $request->addGoogleAnalytics(new GoogleAnalytics($faker->word));
        $request->addPluginDetails(new PluginDetails('Foobar', '0.0.1'));

        return $request;
    }
}
