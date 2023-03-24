<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RedirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\ValueObject\Money;
use MultiSafepay\ValueObject\Weight;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestOrderTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class OrderRequestTest extends TestCase
{
    use GenericOrderRequestFixture;
    use DirectOrderRequestFixture;
    use RedirectOrderRequestFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use PaymentOptionsFixture;
    use DescriptionFixture;
    use PluginDetailsFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;
    use CountryFixture;
    use PhoneNumberFixture;
    use ShoppingCartFixture;

    /**
     * Test if regular creation of an order works
     */
    public function testRequestOrderWithTypeRedirect()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();

        $data = $orderRequest->getData();
        $this->assertEquals('redirect', $data['type']);
        $this->assertEquals('redirect', $orderRequest->getType());
        $this->assertEquals(GatewayFixture::IDEAL, $data['gateway']);
        $this->assertEquals(GatewayFixture::IDEAL, $orderRequest->getGatewayCode());
        $this->assertIsNumeric($data['order_id']);
        $this->assertTrue((int)$orderRequest->getOrderId() > 0);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('EUR', $orderRequest->getCurrency());
        $this->assertEquals('2000', $data['amount']);
        $this->assertEquals(2000, $orderRequest->getAmount());
        $this->assertEquals('foobar', $data['description']);
        $this->assertEquals('foobar', $orderRequest->getDescriptionText());
    }

    /**
     * Test if regular creation of an order works
     */
    public function testRequestOrderWithTypeDirect()
    {
        $orderRequest = $this->createOrderIdealDirectRequestFixture();

        $data = $orderRequest->getData();
        $this->assertEquals('direct', $data['type']);
        $this->assertEquals('direct', $orderRequest->getType());
        $this->assertEquals(GatewayFixture::IDEAL, $data['gateway']);
        $this->assertEquals(GatewayFixture::IDEAL, $orderRequest->getGatewayCode());
        $this->assertIsNumeric($data['order_id']);
        $this->assertTrue((int)$orderRequest->getOrderId() > 0);
        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('EUR', $orderRequest->getCurrency());
        $this->assertEquals('20', $data['amount']);
        $this->assertEquals(20.00, $orderRequest->getAmount());
        $this->assertEquals('foobar', $data['description']);
        $this->assertEquals('foobar', $orderRequest->getDescriptionText());
    }

    /**
     * Test if we can modify the shopping cart after having created the order request
     */
    public function testCreateAndAddNewItem()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();
        $orderRequest->addShoppingCart($this->createShoppingCartFixture());
        $shoppingCart = $orderRequest->getShoppingCart();
        $items = $shoppingCart->getItems();
        $this->assertEquals(1, count($items));

        $item = (new ShoppingCartItem())
            ->addName('Foobar')
            ->addUnitPrice(new Money(10000, 'EUR'))
            ->addQuantity(1)
            ->addDescription('4321')
            ->addTaxRate(0)
            ->addMerchantItemId('4321')
            ->addWeight(
                new Weight('KG', 42)
            );
        $shoppingCart->addItem($item);

        $shoppingCart2 = $orderRequest->getShoppingCart();
        $items = $shoppingCart2->getItems();
        $this->assertEquals(2, count($items));

        $data = $orderRequest->getData();
        $this->assertEquals(2, count($data['shopping_cart']['items']));
    }

    /**
     * Check if the correct exception and message is given when an invalid model is used.
     */
    public function testCorrectErrorWhenUsingIncorrectModel()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Type "non-existing-model" is not a known type. Available types: cardOnFile, subscription, unscheduled'
        );
        (new OrderRequest())->addRecurringModel('non-existing-model');
    }
}
