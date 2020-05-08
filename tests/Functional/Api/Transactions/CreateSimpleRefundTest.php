<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\Api\Transactions\RefundRequest;
use Psr\Http\Client\ClientExceptionInterface;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\SecondChance;
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
    use AddressFixture;
    use MetaGatewayInfoFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateSimpleRefund()
    {
        // Unfortunately the current API doesn't allow you to retrieve order IDs
        // Add the ORDER_ID_TO_REFUND to your .env.php file to test refunds
        $orderId = getenv('ORDER_ID_TO_REFUND');
        if (empty($orderId)) {
            $this->markTestSkipped('No order ID given');
            return;
        }

        try {
            $transactionReponse = $this->getApi()->getTransactionManager()->get($orderId);
            $orderId = $transactionReponse->getOrderId();
            $this->assertNotEmpty($orderId);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails(['order_id' => $orderId]));
            return;
        }

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
     * @return RefundRequest
     */
    private function createRefundRequestForSimpleRefund(): RefundRequest
    {
        return new RefundRequest(Money::EUR(10), new Description('Your refund description'));
    }
}
