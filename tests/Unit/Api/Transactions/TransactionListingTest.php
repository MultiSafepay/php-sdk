<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Unit\Api\Transactions;

use MultiSafepay\Api\Categories\CategoryListing;
use MultiSafepay\Api\Transactions\TransactionListing;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionListingTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions
 */
class TransactionListingTest extends TestCase
{
    /**
     * Test normal initialization
     */
    public function testGetTransactions()
    {
        $transactionListing = new TransactionListing([['transaction_id' => '999']]);
        $transactions = $transactionListing->getTransactions();
        $this->assertCount(1, $transactions);

        $transaction = array_shift($transactions);
        $this->assertEquals('999', $transaction->getTransactionId());
    }
}
