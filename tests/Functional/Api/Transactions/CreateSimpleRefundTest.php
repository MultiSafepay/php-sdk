<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use Psr\Http\Client\ClientExceptionInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;

/**
 * Class CreateSimpleRefundTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateSimpleRefundTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use ShoppingCartFixture;
    use TaxTableFixture;
    use AddressFixture;
    use MetaGatewayInfoFixture;
    use DescriptionFixture;
    use PluginDetailsFixture;
    use CountryFixture;
    use PhoneNumberFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateSimpleRefund()
    {
        $orderId = $this->getOrderId();
        if (empty($orderId)) {
            $this->markTestSkipped('No order ID has been given');
            return;
        }

        $transactionReponse = $this->getApi()->getTransactionManager()->get($orderId);
        $items = $transactionReponse->getShoppingCart()->getItems();
        $refundRequest = $this->createRefundRequestForSimpleRefund($items);

        $this->markTestSkipped('Not implemented yet');

        try {
            $refundResponse = $this->getApi()->getTransactionManager()->refund($transactionReponse, $refundRequest);
        } catch (ApiException $apiException) {
            $data = [
                'order_id' => $transactionReponse->getOrderId(),
                'request_data' => $refundRequest->getData()
            ];
            $this->assertTrue(false, $apiException->getDetails($data));
            return;
        }

        $data = $refundResponse;
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['refund_id']);
    }

    /**
     * Return the order ID
     *
     * Unfortunately the current API doesn't allow you to retrieve order IDs
     * Add the ORDER_ID_TO_REFUND to your .env.php file to test refunds
     * @throws ClientExceptionInterface
     */
    private function getOrderId(): string
    {
        $orderId = getenv('ORDER_ID_TO_REFUND');
        if (!empty($orderId)) {
            return (string)$orderId;
        }

        $this->markTestSkipped('Order creation has not been implemented yet');
        $requestOrder = $this->createOrderRequest();
        $transactionReponse = $this->getApi()->getTransactionManager()->create($requestOrder);
        return (string)$transactionReponse->getOrderId();
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return (new OrderRequest())
            ->addType('direct')
            ->addShoppingCart($this->createShoppingCartFixture())
            ->addTaxTable($this->createTaxTableFixture())
            ->addOrderId((string)time())
            ->addMoney(Money::EUR(100))
            ->addGatewayCode(Gateway::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture())
            ->addDescription($this->createRandomDescriptionFixture())
            ->addPluginDetails($this->createPluginDetailsFixture());
    }

    /**
     * @param ShoppingCartItem[] $shoppingCartItems
     * @return RefundRequest
     */
    private function createRefundRequestForSimpleRefund(array $shoppingCartItems = []): RefundRequest
    {
        $checkoutData = new CheckoutData();
        $checkoutData->addItems($shoppingCartItems);

        $refundRequest = (new RefundRequest())
            ->addMoney(Money::EUR(10))
            ->addDescription($this->createRandomDescriptionFixture())
            ->addCheckoutData($checkoutData);

        return $refundRequest;
    }
}
