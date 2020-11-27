<?php declare(strict_types=1);

namespace MultiSafepay\Tests\Functional\Api\Transactions;

use MultiSafepay\Api\Transactions\OrderRequest;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Tests\Fixtures\Api\Gateways\GatewayFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\CustomerDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\DescriptionFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\GoogleAnalyticsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\IdealGatewayInfoFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PaymentOptionsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\PluginDetailsFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\SecondChanceFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\GenericOrderRequestFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\AddressFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\CountryFixture;
use MultiSafepay\Tests\Fixtures\ValueObject\PhoneNumberFixture;
use MultiSafepay\Tests\Functional\AbstractTestCase;
use MultiSafepay\ValueObject\Money;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CreateDirectOrderWithWrongCurrencyTest
 * @package MultiSafepay\Tests\Functional\Api\Transactions
 */
class CreateDirectOrderWithWrongCurrencyTest extends AbstractTestCase
{
    use GenericOrderRequestFixture;
    use CustomerDetailsFixture;
    use PaymentOptionsFixture;
    use PluginDetailsFixture;
    use GoogleAnalyticsFixture;
    use AddressFixture;
    use IdealGatewayInfoFixture;
    use DescriptionFixture;
    use SecondChanceFixture;
    use PhoneNumberFixture;
    use CountryFixture;

    /**
     * @param string $currencyCode
     * @throws ClientExceptionInterface
     * @dataProvider getInvalidCountryCodes
     */
    public function testCreateDirectOrderWithWrongCurrencyCode(string $currencyCode): void
    {
        $this->expectException(ApiException::class);
        $orderRequest = $this->createOrderRequest($currencyCode);
        $this->getClient()->createPostRequest('orders', $orderRequest);
    }

    /**
     * @return array|string[]
     */
    public function getInvalidCountryCodes(): array
    {
        return [
            ['FOOBAR'],
            ['AMD'],
            ['AZN'],
            ['CDF'],
        ];
    }

    /**
     * @param string $currencyCode
     * @return OrderRequest
     */
    private function createOrderRequest(string $currencyCode): OrderRequest
    {
        return $this->createGenericOrderRequestFixture()
            ->addType('direct')
            ->addMoney(new Money(20, $currencyCode))
            ->addGatewayCode(GatewayFixture::IDEAL)
            ->addGatewayInfo($this->createRandomIdealGatewayInfoFixture($this->getApi()))
            ->addPaymentOptions($this->createPaymentOptionsFixture());
    }
}
