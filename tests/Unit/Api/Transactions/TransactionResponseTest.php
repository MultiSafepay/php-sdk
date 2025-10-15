<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions;

use Exception;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\Api\Transactions\TransactionResponse\Costs;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails\CardAuthenticationDetails;
use MultiSafepay\Api\Transactions\TransactionResponse\PaymentDetails\CardAuthenticationResult;
use MultiSafepay\Tests\Utils\FixtureLoader;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionResponseTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class TransactionResponseTest extends TestCase
{
    /**
     * Test if the TransactionResponse can be created from fixture data
     *
     * @throws Exception
     */
    public function testGetTransactionResponse()
    {
        $data = FixtureLoader::loadFixtureDataById('credit-card-order');

        $transactionResponse = new TransactionResponse($data['data']);

        $this->assertEquals('1753953275109182', $transactionResponse->getTransactionId());
        $this->assertEquals('apitool_9290375', $transactionResponse->getOrderId());
        $this->assertEquals('2025-07-31T11:14:35', $transactionResponse->getCreated());
        $this->assertEquals('2025-07-31T11:58:26', $transactionResponse->getModified());
        $this->assertEquals('EUR', $transactionResponse->getCurrency());
        $this->assertEquals(1000, $transactionResponse->getAmount());
        $this->assertEquals('product description', $transactionResponse->getDescription());

        // Status properties
        $this->assertEquals('completed', $transactionResponse->getStatus());
        $this->assertEquals('completed', $transactionResponse->getFinancialStatus());
        $this->assertEquals('1000', $transactionResponse->getReasonCode());
        $this->assertEquals('', $transactionResponse->getReason());

        // Custom variables
        $this->assertEquals('', $transactionResponse->getVar1());
        $this->assertEquals('', $transactionResponse->getVar2());
        $this->assertEquals('', $transactionResponse->getVar3());

        // Amounts
        $this->assertEquals(0, $transactionResponse->getAmountRefunded());

        // FastCheckout
        $this->assertEquals('NO', $transactionResponse->getFastCheckout());
        $this->assertFalse($transactionResponse->isFastCheckout());

        // Money objects
        $money = $transactionResponse->getMoney();
        $this->assertEquals(1000, $money->getAmount());
        $this->assertEquals('EUR', $money->getCurrency());

        $moneyRefunded = $transactionResponse->getMoneyRefunded();
        $this->assertEquals(0, $moneyRefunded->getAmount());

        // Payment Details
        $paymentDetails = $transactionResponse->getPaymentDetails();
        $this->assertInstanceOf(PaymentDetails::class, $paymentDetails);

        // Basic payment details
        $this->assertEquals('998163177297134120', $paymentDetails->getRecurringId());
        $this->assertEquals('VISA', $paymentDetails->getType());
        $this->assertEquals('', $paymentDetails->getAccountId());
        $this->assertEquals('Test Holder Name', $paymentDetails->getAccountHolderName());
        $this->assertEquals('234205872', $paymentDetails->getExternalTransactionId());

        // Account details (IBAN/BIC - empty for card payments)
        $this->assertEquals('', $paymentDetails->getAccountIban());
        $this->assertEquals('', $paymentDetails->getAccountBic());
        $this->assertEquals('', $paymentDetails->getIssuerId());

        // Card details
        $this->assertEquals('1111', $paymentDetails->getLast4());
        $this->assertEquals('3012', $paymentDetails->getCardExpiryDate());
        $this->assertEquals('UNKNOWN', $paymentDetails->getCardEntryMode());
        $this->assertEquals('M', $paymentDetails->getCardVerificationResult());

        // Authorization and response codes
        $this->assertEquals('00', $paymentDetails->getResponseCode());
        $this->assertEquals('876543', $paymentDetails->getAuthorizationCode());

        // Card acceptor details (empty in this case)
        $this->assertEquals('', $paymentDetails->getCardAcceptorId());
        $this->assertEquals('', $paymentDetails->getCardAcceptorLocation());
        $this->assertEquals('', $paymentDetails->getCardAcceptorName());

        // Recurring details (empty in this case)
        $this->assertEquals('', $paymentDetails->getRecurringFlow());
        $this->assertEquals('', $paymentDetails->getRecurringModel());

        // Other details
        $this->assertEquals('', $paymentDetails->getMcc());
        $this->assertEquals('', $paymentDetails->getSchemeReferenceId());

        // Capture details (empty in this case)
        $this->assertEquals('', $paymentDetails->getCapture());
        $this->assertEquals('', $paymentDetails->getCaptureExpiry());
        $this->assertEquals(0, $paymentDetails->getCaptureRemain());

        // Card authentication objects
        $cardAuthDetails = $paymentDetails->getCardAuthenticationDetails();
        $this->assertInstanceOf(CardAuthenticationDetails::class, $cardAuthDetails);

        $cardAuthResult = $paymentDetails->getCardAuthenticationResult();
        $this->assertInstanceOf(CardAuthenticationResult::class, $cardAuthResult);

        // Costs
        $costs = $transactionResponse->getCosts();
        $this->assertInstanceOf(Costs::class, $costs);

        // Payment Methods
        $paymentMethods = $transactionResponse->getPaymentMethods();
        $this->assertIsArray($paymentMethods);
        $this->assertCount(1, $paymentMethods);

        // Related Transactions
        $relatedTransactions = $transactionResponse->getRelatedTransactions();
        $this->assertIsArray($relatedTransactions);

        // Customer data
        $customerArray = $transactionResponse->getCustomerAsArray();
        $this->assertIsArray($customerArray);
        $this->assertEquals('example@multisafepay.com', $customerArray['email']);
        $this->assertEquals('Testperson-nl', $customerArray['first_name']);
        $this->assertEquals('Approved', $customerArray['last_name']);

        // Gateway ID
        $this->assertEquals('VISA', $transactionResponse->getGatewayId());
    }
}
