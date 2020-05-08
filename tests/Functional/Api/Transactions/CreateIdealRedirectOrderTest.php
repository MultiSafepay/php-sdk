<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\RedirectFixture as OrderRequestRedirectFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
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
    use OrderRequestRedirectFixture;
    use AddressFixture;
    use ShoppingCartFixture;
    use TaxTableFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use PluginDetailsFixture;

    /**
     * @throws ClientExceptionInterface
     */
    public function testCreateIdealRedirectOrder()
    {
        $orderRequest = $this->createIdealOrderRedirectRequestFixture();

        try {
            $response = $this->getClient()->createPostRequest('orders', $orderRequest);
        } catch (ApiException $apiException) {
            $this->assertTrue(false, $apiException->getDetails($orderRequest->getData()));
            return;
        }

        $data = $response->getResponseData();
        $this->assertIsNumeric($data['order_id']);
        $this->assertNotEmpty($data['payment_url']);
    }
}
