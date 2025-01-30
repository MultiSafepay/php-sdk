<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Exception\InvalidTotalAmountException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\AffiliateFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as DirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\OrderRequestWithoutPluginDetails;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RedirectOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\TerminalFixture;
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
    use TerminalFixture;
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
    use OrderRequestWithoutPluginDetails;
    use AffiliateFixture;

    /**
     * Test if regular creation of an order works
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
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
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
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
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
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

    /**
     * Test if order request can be created adding a terminal ID
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
     */
    public function testRequestOrderWithTerminalId()
    {
        $orderRequest = $this->createTerminalOrderRedirectRequestFixture();
        $data = $orderRequest->getData();
        $this->assertIsArray($data['gateway_info']);
        $this->assertArrayHasKey('terminal_id', $data['gateway_info']);
        $this->assertEquals('terminal-id', $data['gateway_info']['terminal_id']);
    }

    /**
     * Test if we can add a customer object, only setting up the reference, and get the Order Request
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
     */
    public function testCreateAndAddCustomerReference()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();
        $customer = (new OrderRequest\Arguments\CustomerDetails())->addReference('customer-reference');
        $orderRequest->addCustomer($customer);
        $data = $orderRequest->getData();
        $this->assertIsArray($data['customer']);
        $this->assertEquals(2, count($data['customer']));
        $this->assertEquals('customer-reference', $data['customer']['reference']);
        $this->assertArrayNotHasKey('address1', $data['customer']);
    }

    /**
     * Test if order request can be created without set pluginDetails
     * @throws InvalidTotalAmountException
     * @throws InvalidArgumentException
     */
    public function testRequestOrderRequestWithoutPluginDetails()
    {
        $orderRequest = $this->createOrderRequestWithoutPluginDetails();
        $data = $orderRequest->getData();
        $this->assertArrayNotHasKey('plugin', $data);
    }

    /**
     * Test if we can add a customer info object, only setting up the reference, and get the Order Request
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
     */
    public function testRequestOrderRequestWithCustomInfo()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();
        $customInfo =  (new OrderRequest\Arguments\CustomInfo())->addCustom1('Multi')->addCustom2('Safe')->addCustom3('pay');
        $orderRequest->addCustomInfo($customInfo);
        $data = $orderRequest->getData();
        $this->assertIsArray($data['custom_info']);
        $this->assertEquals(3, count($data['custom_info']));
    }

    /**
     * Test if we can get the Var data, within an order request
     * @throws InvalidArgumentException
     */
    public function testOrderRequestWithVarCollection()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();
        $orderRequest->addVar1('Multi');
        $orderRequest->addVar2('Safe');
        $orderRequest->addVar3('Pay');
        $this->assertEquals('Multi', $orderRequest->getVar1());
        $this->assertEquals('Safe', $orderRequest->getVar2());
        $this->assertEquals('Pay', $orderRequest->getVar3());
    }

    /**
     * Test if we can get affiliate data, within an order request
     * @throws InvalidArgumentException
     * @throws InvalidTotalAmountException
     */
    public function testOrderWithAffiliate()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();
        $orderRequest->addAffiliate($this->createAffiliateFixture());
        $data = $orderRequest->getData();

        $this->assertArrayHasKey('affiliate', $data);
        $this->assertArrayHasKey('split_payments', $data['affiliate']);
    }
}
