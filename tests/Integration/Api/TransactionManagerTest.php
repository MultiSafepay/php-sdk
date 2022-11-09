<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Integration\Api;

use MultiSafepay\Api\TransactionManager;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\Description;
use MultiSafepay\Api\Transactions\RefundRequest;
use MultiSafepay\Api\Transactions\Transaction;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\DirectFixture as RequestOrderDirectFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as RequestOrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Integration\MockClient;
use MultiSafepay\ValueObject\Money;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class TransactionManagerTest extends TestCase
{
    use GenericOrderRequestFixture;
    use RequestOrderDirectFixture;
    use RequestOrderRedirectFixture;
    use PaymentOptionsFixture;
    use CustomerDetailsFixture;
    use AddressFixture;
    use DescriptionFixture;
    use PluginDetailsFixture;
    use CountryFixture;
    use PhoneNumberFixture;
    use SecondChanceFixture;
    use GoogleAnalyticsFixture;

    /**
     * Test the creation of a transaction
     * @throws ClientExceptionInterface
     */
    public function testCreateTransaction(): void
    {
        $requestRedirectOrder = $this->createIdealOrderRedirectRequestFixture();
        $orderData = $requestRedirectOrder->getData();

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse(
            [
                'order_id' => $orderData['order_id'],
                'payment_url' => 'https://testpayv2.multisafepay.com/',
            ]
        );

        $transactionManager = new TransactionManager($mockClient);
        $transaction = $transactionManager->create($requestRedirectOrder);

        $this->assertEquals($orderData['order_id'], $transaction->getOrderId());

        $paymentLink = $transaction->getPaymentUrl();
        $this->assertStringStartsWith('https://testpayv2.multisafepay.com/', $paymentLink);
    }

    /**
     * Test if we can collect the payment data
     * @throws ClientExceptionInterface
     */
    public function testGetTransactionWithValidApiKey(): void
    {
        $orderId = (string)time();

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse(
            [
                'order_id' => $orderId,
                'status' => Transaction::COMPLETED,
                'transaction_id' => 4051823,
                'refund_id' => 405223823,
                'amount' => 9743,
            ]
        );

        $transactionManager = new TransactionManager($mockClient);
        $transaction = $transactionManager->get($orderId);

        $this->assertEmpty($transaction->getPaymentUrl());
        $this->assertSame('completed', $transaction->getData()['status']);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testRefund(): void
    {
        $fakeOrderId = (string)time();
        $fakeTransactionId = 4051824;
        $fakeRefundId = 4059285;

        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse(
            [
                'order_id' => $fakeOrderId,
                'status' => Transaction::COMPLETED,
                'transaction_id' => $fakeTransactionId,
                'currency' => 'EUR',
                'amount' => 10000,
            ]
        );

        $transactionManager = new TransactionManager($mockClient);
        $transaction = $transactionManager->get($fakeOrderId);

        $mockClient->mockResponse(
            [
                'refund_id' => $fakeRefundId,
                'transaction_id' => $fakeTransactionId,
            ]
        );

        $refundRequest = (new RefundRequest())
            ->addMoney(new Money(21, 'EUR'))
            ->addDescription(Description::fromText('Give me my money back'));
        $refundResponse = $transactionManager->refund($transaction, $refundRequest);
        $refundData = $refundResponse->getResponseData();

        $this->assertArrayHasKey('refund_id', $refundData, var_export($refundData, true));
        $this->assertEquals($fakeRefundId, $refundData['refund_id'], var_export($refundData, true));
        $this->assertEquals($fakeTransactionId, $transaction->getData()['transaction_id']);
        $this->assertEquals($fakeTransactionId, $refundData['transaction_id']);
    }

    /**
     * Test the return of an Exception when an invalid order Id is being used.
     *
     * @throws ClientExceptionInterface
     */
    public function testGetTransactionWithInvalidOrderId(): void
    {
        $mockClient = MockClient::getInstance();
        $mockClient->mockResponse([], false, 1006, 'Invalid transaction ID');
        $transactionManager = new TransactionManager($mockClient);

        $this->expectException(ApiException::class);
        $this->expectExceptionCode(1006);
        $this->expectExceptionMessage('Invalid transaction ID');
        $transactionManager->get('42');
    }
}
