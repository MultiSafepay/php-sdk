<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Money\Money;
use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CheckoutOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Utils\FixtureLoader;
use Psr\Http\Client\ClientExceptionInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart\Item as ShoppingCartItem;

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
    use CheckoutOptionsFixture;
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

        // @todo: If financial_status is "uncleared", can we refund?
        $this->markTestSkipped('Skipped due to issue 96');
        //$refundResponse = $this->getRefundReponseFromMockFile($orderId);
        $refundResponse = $this->getRefundReponseFromOrderId($orderId);
        $data = $refundResponse->getResponseData();
        $this->assertNotEmpty($data['transaction_id']);
        $this->assertNotEmpty($data['refund_id']);
    }

    /**
     * @param string $orderId
     * @return Response
     * @throws ClientExceptionInterface
     */
    private function getRefundReponseFromMockFile(string $orderId): Response
    {
        //$transactionReponse = $this->getApi()->getTransactionManager()->get($orderId);
        //echo json_encode($transactionReponse->getData(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //exit;

        $refundRequest = RequestBody::createRequestBodyFromArray(FixtureLoader::loadFixtureDataById('refund'));
        return $this->getClient()->createPostRequest('orders/' . $orderId . '/refunds', $refundRequest);
    }

    /**
     * @param string $orderId
     * @return Response
     * @throws ClientExceptionInterface
     */
    private function getRefundReponseFromOrderId(string $orderId): Response
    {
        $transactionReponse = $this->getApi()->getTransactionManager()->get($orderId);
        $items = $transactionReponse->getShoppingCart()->getItems();
        $refundRequest = $this->createRefundRequestForSimpleRefund($items);

        try {
            $response = $this->getApi()->getTransactionManager()->refund($transactionReponse, $refundRequest);
        } catch (ApiException $apiException) {
            $response = null;
            $apiException->addContext(['order_id' => $transactionReponse->getOrderId()]);
            $this->assertTrue(false, $apiException->getDetails());
        }

        return $response;
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

        $requestOrder = $this->createOrderRequest();
        $transactionReponse = $this->getApi()->getTransactionManager()->create($requestOrder);
        return (string)$transactionReponse->getOrderId();
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        $customer = $this->createCustomerDetailsFixture();

        return (new OrderRequest())
            ->addType('direct')
            ->addShoppingCart($this->createShoppingCartFixture())
            ->addCheckoutOptions($this->createCheckoutOptionsFixture())
            ->addCustomer($customer)
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
        $checkoutData->addTaxTable($this->createTaxTableFixture());

        foreach ($shoppingCartItems as $shoppingCartItem) {
            $shoppingCartItem->addTaxTableSelector('none');
            $checkoutData->addItem($shoppingCartItem);
        }

        $refundRequest = (new RefundRequest())
            ->addCheckoutData($checkoutData);

        return $refundRequest;
    }
}
