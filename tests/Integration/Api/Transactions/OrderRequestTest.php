<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration\Api\Transactions;

use Faker\Factory as FakerFactory;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Weight;
use PHPUnit\Framework\TestCase;

class OrderRequestTest extends TestCase
{
    use GenericOrderRequestFixture;
    use DirectOrderRequestFixture;
    use PaymentOptionsFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use IdealGatewayInfoFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;
    use PluginDetailsFixture;
    use PhoneNumberFixture;
    use CountryFixture;
    use ShoppingCartFixture;

    /**
     * Test whether creating a new shopping cart also generates a correct TaxTable
     */
    public function testGenerateTaxTables(): void
    {
        $orderRequest = $this->createGenericOrderRequestFixture();
        $orderRequest->addShoppingCart($this->getShoppingCart());
        $orderRequestData = $orderRequest->getData();
        $this->assertArrayHasKey('shopping_cart', $orderRequestData);
        $this->assertArrayHasKey('items', $orderRequestData['shopping_cart']);

        $items = $orderRequestData['shopping_cart']['items'];
        $this->assertTrue(count($items) > 0);

        $this->assertArrayHasKey('checkout_options', $orderRequestData);
        $this->assertArrayHasKey('tax_tables', $orderRequestData['checkout_options']);
        $this->assertArrayHasKey('alternate', $orderRequestData['checkout_options']['tax_tables']);
        $taxRules = $orderRequestData['checkout_options']['tax_tables']['alternate'];
        $this->assertCount(1, $taxRules);

        $firstItem = array_shift($items);
        $taxRule = array_shift($taxRules);
        $this->assertEquals($taxRule['rules'][0]['rate'] * 100, $firstItem['tax_table_selector']);
    }

    /**
     * @return ShoppingCart
     */
    private function getShoppingCart(): ShoppingCart
    {
        $items = [];
        $items[] = $this->getShoppingCartItem(12, 2, 21);
        $items[] = $this->getShoppingCartItem(3, 3, 21);
        $items[] = $this->getShoppingCartItem(11, 4, 21);

        return new ShoppingCart($items);
    }

    /**
     * @param int $amount
     * @param int $quantity
     * @param float $taxRate
     * @return ShoppingCartItem
     */
    private function getShoppingCartItem(int $amount, int $quantity, float $taxRate): ShoppingCartItem
    {
        $faker = FakerFactory::create();
        return (new ShoppingCartItem())
            ->addName($faker->word)
            ->addUnitPrice(new Money($amount, 'EUR'))
            ->addQuantity($quantity)
            ->addDescription($faker->word)
            ->addTaxRate($taxRate)
            ->addMerchantItemId($faker->word)
            ->addWeight(
                new Weight('KG', $faker->numberBetween(1, 100))
            );
    }
}
