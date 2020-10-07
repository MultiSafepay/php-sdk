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
}
