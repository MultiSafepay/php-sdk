<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Api\Base\RequestBody;
use MultiSafepay\Api\Base\Response;
use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\ShoppingCart;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\RefundRequest\Arguments\CheckoutData;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CheckoutOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Utils\FixtureLoader;
use MultiSafepay\ValueObject\Money;
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
    use GenericOrderRequestFixture;
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

        $this->markTestSkipped('Skipped due to issue 96');
        //$refundResponse = $this->getRefundReponseFromMockFile($orderId);
        $refundResponse = $this->getRefundResponseFromOrderId($orderId);
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
        $refundRequest = RequestBody::createRequestBodyFromArray(FixtureLoader::loadFixtureDataById('refund'));
        return $this->getClient()->createPostRequest('json/orders/' . $orderId . '/refunds', $refundRequest);
    }

    /**
     * @param string $orderId
     * @return Response
     * @throws ClientExceptionInterface
     */
    private function getRefundResponseFromOrderId(string $orderId): Response
    {
        $transactionReponse = $this->getApi()->getTransactionManager()->get($orderId);
        $shoppingCart = $transactionReponse->getShoppingCart();
        $refundRequest = $this->createRefundRequestForSimpleRefund($shoppingCart);

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

        try {
            $transactionReponse = $this->getApi()->getTransactionManager()->create($requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails());
            return '';
        }

        return (string)$transactionReponse->getOrderId();
    }

    /**
     * @return OrderRequest
     */
    private function createOrderRequest(): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addShoppingCart($this->createShoppingCartFixture())
            ->addMoney(new Money(10000, 'EUR'))
            ->addGatewayCode(GatewayFixture::PAYAFTER)
            ->addGatewayInfo($this->createRandomMetaGatewayInfoFixture())
            ->addPaymentOptions($this->createPaymentOptionsFixture());
    }

    /**
     * @param ShoppingCart $shoppingCart
     * @return RefundRequest
     */
    private function createRefundRequestForSimpleRefund(ShoppingCart $shoppingCart): RefundRequest
    {
        $checkoutData = new CheckoutData();
        $checkoutData->addTaxTable($this->createTaxTableFixture());
        $checkoutData->generateFromShoppingCart($shoppingCart);

        $refundRequest = (new RefundRequest())
            ->addCheckoutData($checkoutData);

        return $refundRequest;
    }
}
