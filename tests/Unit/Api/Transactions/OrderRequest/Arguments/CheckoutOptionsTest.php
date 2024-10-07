<?php declare(strict_types=1);
namespace MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments;

use MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\ShoppingCartFixture;
use MultiSafepay\Tests\Fixtures\OrderRequest\Arguments\TaxTableFixture;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerDetailsTest
 * @package MultiSafepay\Tests\Unit\Api\Transactions\OrderRequest\Arguments
 */
class CheckoutOptionsTest extends TestCase
{
    use ShoppingCartFixture;
    use TaxTableFixture;

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::generateFromShoppingCart
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::getData
     */
    public function testGenerateFromShoppingCart()
    {
        $shoppingCart = $this->createShoppingCartFixture();

        $checkoutOptions = new CheckoutOptions();
        $checkoutOptions->generateFromShoppingCart($shoppingCart);
        $data = $checkoutOptions->getData();
        $this->assertNotEmpty($data['tax_tables']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::addTaxTable
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::getData
     */
    public function testAddTaxTable()
    {
        $taxTable = $this->createTaxTableFixture();

        $checkoutOptions = new CheckoutOptions();
        $checkoutOptions->addTaxTable($taxTable);
        $data = $checkoutOptions->getData();
        $this->assertNotEmpty($data['tax_tables']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::generateFromShoppingCart
     */
    public function testGenerateFromShoppingCartWithSimilarTaxRates()
    {
        $shoppingCart = $this->createShoppingCartFixtureWithSimilarTaxRates();

        $checkoutOptions = new CheckoutOptions();
        $checkoutOptions->generateFromShoppingCart($shoppingCart);
        $data = $checkoutOptions->getData();
        $this->assertCount(2, $data['tax_tables']['alternate']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::addCartValidation
     */
    public function testAddCartValidation()
    {
        $checkoutOptions = new CheckoutOptions();
        $checkoutOptions->addCartValidation(true);
        $data = $checkoutOptions->getData();
        $this->assertTrue($data['validate_cart']);
    }

    /**
     * @covers \MultiSafepay\Api\Transactions\OrderRequest\Arguments\CheckoutOptions::addCartValidation
     */
    public function testNoAddCartValidation()
    {
        $checkoutOptions = new CheckoutOptions();
        $data = $checkoutOptions->getData();
        $this->assertFalse($data['validate_cart']);
    }
}
