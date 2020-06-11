<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Api\Transactions\UpdateRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateUpdateTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateUpdateTest extends AbstractTestCase
{
    /**
     * Test to see if update could be sent but replies with API error
     * @throws ClientExceptionInterface
     */
    public function testIfUpdateWorksButFailsInApi()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Invalid transaction ID');
        $updateRequest = new UpdateRequest();
        $updateRequest->addId('foobar');
        $updateRequest->addStatus('shipped');
        $this->getApi()->getTransactionManager()->update('foobar', $updateRequest);
    }
}
