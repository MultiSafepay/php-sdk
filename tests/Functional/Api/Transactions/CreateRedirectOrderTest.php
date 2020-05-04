<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\AddressFixture;
use MultiSafepay\Tests\Fixtures\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\TaxTableFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateRedirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateRedirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use OrderRedirectFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use TaxTableFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateIdealRedirectOrder()
    {
        $requestOrder = $this->createIdealOrderRedirectRequestFixture();

        try {
            $response = $this->getClient()->createPostRequest('orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($requestOrder->getData()));
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreatePayafterRedirectOrder()
    {
        $requestOrder = $this->createPayafterOrderRedirectRequestFixture();

        try {
            $response = $this->getClient()->createPostRequest('orders', $requestOrder);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($requestOrder->getData()));
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }
}