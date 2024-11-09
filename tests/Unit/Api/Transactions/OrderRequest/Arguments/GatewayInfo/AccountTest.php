<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments\GatewayInfo;

use Faker\Provider\Payment;
use MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account;
use MultiSafepay\ValueObject\IbanNumber;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::getData
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addAccountId
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addAccountHolderIban
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addAccountHolderName
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addEmanDate
     */
    public function testGetData()
    {
        $ibanNumber = Payment::iban('NL');
        $iban = new IbanNumber($ibanNumber);

        $account = new Account();
        $account->addAccountId($iban);
        $account->addAccountHolderIban($iban);
        $account->addAccountHolderName('John Doe');
        $account->addEmandate('id_xxxx');
        $data = $account->getData();
        $this->assertSame($iban->get(), $data['account_id']);
        $this->assertSame($iban->get(), $data['account_holder_iban']);
        $this->assertSame('John Doe', $data['account_holder_name']);
        $this->assertSame('id_xxxx', $data['emandate']);
    }

    /**
     * Test if value object variables that belong to the Account class can be set using their to AsString functions
     *
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addAccountIdAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addAccountHolderIbanAsString
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\GatewayInfo\Account::addEmanDate
     */
    public function testSettingValueObjectsUsingAsStringMethods()
    {
        $ibanNumber = Payment::iban('NL');

        $account = new Account();
        $account->addAccountIdAsString($ibanNumber);
        $account->addAccountHolderIbanAsString($ibanNumber);
        $data = $account->getData();
        $this->assertSame($ibanNumber, $data['account_id']);
        $this->assertSame($ibanNumber, $data['account_holder_iban']);
    }
}
