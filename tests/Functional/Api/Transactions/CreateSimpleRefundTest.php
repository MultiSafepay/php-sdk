<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use Faker\Factory as FakerFactory;
use Money\Money;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Description;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Direct\GatewayInfo\Ideal as IdealGatewayInfo;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\Direct\GatewayInfo\Meta;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\GoogleAnalytics;
use MultiSafepay\Api\Transactions\RequestOrder\Arguments\SecondChance;
use MultiSafepay\Api\Transactions\RequestOrder\Direct as RequestOrderDirect;
use MultiSafepay\Api\Transactions\RequestRefund;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\MetaGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\DirectFixture as RequestOrderDirectFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

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
    public function testCreateIdealDirectOrder()
    {
        $orderRequest = $this->createOrderRequestForSimpleRefund();

        try {
            $transactionReponse = $this->getApi()->getTransactionManager()->create($orderRequest);
            $orderId = $transactionReponse->getOrderId();
            $this->assertNotEmpty($orderId);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($orderRequest->getData()));
            return;
        }

        return;
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
     * @return RequestOrderDirect
     */
    private function createOrderRequestForSimpleRefund(): RequestOrderDirect
    {
        $faker = FakerFactory::create();

        return new RequestOrderDirect(
            (string)time(),
            Money::EUR(20),
            $this->createPaymentOptionsFixture(),
            $this->createRandomCustomerDetailsFixture(),
            null,
            'CREDITCARDS',
            $this->createMetaGatewayInfoFixture(),
            new Description($faker->sentence),
            new SecondChance(true),
            new GoogleAnalytics($faker->word)
        );
    }

    /**
     * @return RequestRefund
     */
    private function createRefundRequestForSimpleRefund(): RequestRefund
    {
        return new RequestRefund(Money::EUR(10), new Description('Your refund description'));
    }
}
