<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use Faker\Provider\Payment;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard;
use MultiSafepay\ValueObject\Creditcard\CardNumber;
use MultiSafepay\ValueObject\Creditcard\Cvc;
use MultiSafepay\ValueObject\Date;
use PHPUnit\Framework\TestCase;

class CreditcardTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCardExpiryDate
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCardHolderName
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCardNumber
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCvc
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addFlexible3d
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addTermUrl
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::getData
     */
    public function testGetData()
    {
        $creditcardNumber = Payment::creditCardNumber('MasterCard');

        $creditcard = new Creditcard();
        $creditcard->addCardExpiryDate(new Date('2001-01-01'));
        $creditcard->addCardHolderName('John Doe');
        $creditcard->addCardNumber(new CardNumber($creditcardNumber));
        $creditcard->addCvc(new Cvc('111'));
        $creditcard->addFlexible3d(true);
        $creditcard->addTermUrl('http://example.org/');
        $data = $creditcard->getData();
        $this->assertSame('0101', $data['card_expiry_date']);
        $this->assertSame('John Doe', $data['card_holder_name']);
        $this->assertSame($creditcardNumber, $data['card_number']);
        $this->assertSame('111', $data['cvc']);
        $this->assertSame(true, $data['flexible_3d']);
        $this->assertSame('http://example.org/', $data['term_url']);
    }

    /**
     * Test if value object variables that belong to the Creditcard class can be set using their to AsString functions
     *
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCardExpiryDateAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCardNumberAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Creditcard::addCvcAsString
     */
    public function testSettingValueObjectsUsingAsStringMethods()
    {
        $creditcardNumber = Payment::creditCardNumber('MasterCard');

        $creditcard = new Creditcard();
        $creditcard->addCardExpiryDateAsString('2001-01-01');
        $creditcard->addCardNumberAsString($creditcardNumber);
        $creditcard->addCvcAsString('111');

        $data = $creditcard->getData();
        $this->assertSame('0101', $data['card_expiry_date']);
        $this->assertSame($creditcardNumber, $data['card_number']);
        $this->assertSame('111', $data['cvc']);
    }
}
