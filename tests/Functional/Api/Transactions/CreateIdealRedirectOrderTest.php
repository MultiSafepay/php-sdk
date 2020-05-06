<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\RedirectFixture as RequestOrderRedirectFixture;
use MultiSafepay\Tests\Fixtures\RequestOrder\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\TaxTableFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateIdealRedirectOrderTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateIdealRedirectOrderTest extends AbstractTestCase
{
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use RequestOrderRedirectFixture;
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
}
