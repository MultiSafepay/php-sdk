<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\Api\Gateways\Gateway;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\PluginDetails;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Redirect\GatewayInfo\Meta as MetaGatewayInfo;
use MultiSafepay\Api\Transactions\OrderRequest\Redirect as RedirectOrderRequest;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use MultiSafepay\ValueObject\BankAccount;
use MultiSafepay\ValueObject\Customer\EmailAddress;
use MultiSafepay\ValueObject\Customer\PhoneNumber;
use MultiSafepay\ValueObject\Date;
use Psr\Http\Client\ClientExceptionInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Direct as DirectOrderRequest;
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
        $refundRequest = $this->createRefundRequestForSimpleRefund();

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

        $requestOrder = $this->getOrderRequestFixture();

        try {
            $transactionReponse = $this->getApi()->getTransactionManager()->create($requestOrder);
        } catch (ApiException $apiException) {
            return '';
        }

        return (string) $transactionReponse->getOrderId();
    }

    /**
     * @return DirectOrderRequest
     */
    private function getOrderRequestFixture(): DirectOrderRequest
    {
        $faker = FakerFactory::create();

        $requestOrder = new DirectOrderRequest(
            (string)time(),
            Money::EUR(100),
            Gateway::EINVOICE,
            $this->getMetaGatewayInfoFixture(),
            $this->createPaymentOptionsFixture()
        );

        $requestOrder->addDescription(new Description($faker->sentence));
        $requestOrder->addPluginDetails(new PluginDetails('Foobar', '0.0.1'));

        return $requestOrder;
    }

    /**
     * @return MetaGatewayInfo
     */
    private function getMetaGatewayInfoFixture()
    {
        $faker = FakerFactory::create();

        return new MetaGatewayInfo(
            new Date('17 december 2001'),
            new BankAccount('0417164300'),
            new PhoneNumber($faker->phoneNumber),
            new EmailAddress($faker->email)
        );
    }

    /**
     * @return RefundRequest
     */
    private function createRefundRequestForSimpleRefund(): RefundRequest
    {
        return new RefundRequest(Money::EUR(10), new Description('Your refund description'));
    }
}
