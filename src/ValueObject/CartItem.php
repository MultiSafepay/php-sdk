<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use MultiSafepay\Api\Base\DataObject;
use MultiSafepay\Exception\InvalidArgumentException;
use MultiSafepay\Util\MoneyFormatter;

/**
 * Class CartItem
 * @package MultiSafepay\ValueObject
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class CartItem extends DataObject
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Money
     */
    protected $unitPrice;

    /**
     * @var float
     */
    protected $taxRate;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $merchantItemId;

    /**
     * @var string
     */
    protected $taxTableSelector;

    /**
     * @var Weight
     */
    protected $weight;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var UnitPrice
     */
    private $unitPriceValue;

    /**
     * @param array $data
     * @return CartItem
     * @throws InvalidArgumentException
     */
    public static function fromData(array $data): CartItem
    {
        $item = (new self())
            ->addName((string)$data['name'])
            ->addUnitPrice(new Money((float)$data['unit_price'] * 100, (string)$data['currency']))
            ->addQuantity((int)$data['quantity'])
            ->addMerchantItemId((string)$data['merchant_item_id'])
            ->addTaxTableSelector((string)$data['tax_table_selector'])
            ->addDescription((string)$data['description']);

        if (!empty($data['weight']['unit']) && !empty($data['weight']['value'])) {
            $weight = new Weight($data['weight']['unit'], $data['weight']['value']);
            $item->addWeight($weight);
        }
        return $item;
    }

    /**
     * @param string $name
     * @return CartItem
     */
    public function addName(string $name): CartItem
    {
        $this->name = strip_tags($name);
        return $this;
    }

    /**
     * @param UnitPrice $unitPrice
     * @param float|null $taxRate
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addUnitPriceValue(UnitPrice $unitPrice, ?float $taxRate = null): CartItem
    {
        $this->unitPriceValue = $unitPrice;

        if ($taxRate !== null) {
            $this->addTaxRate($taxRate);
        }

        return $this;
    }

    /**
     * @deprecated since version 5.15.0, will be removed in version 7.0.0.
     * Replaced by addUnitPriceValue
     *
     * @param Money $unitPrice
     * @param float|null $taxRate
     * @return CartItem
     * @throws InvalidArgumentException
     */
    public function addUnitPrice(Money $unitPrice, float $taxRate = null): CartItem
    {
        $this->unitPrice = $unitPrice;
        if ($taxRate !== null) {
            $this->addTaxRate($taxRate);
        }

        return $this;
    }

    /**
     * @param float $taxRate
     * @return CartItem
     * @throws InvalidArgumentException
     */
    public function addTaxRate(float $taxRate): CartItem
    {
        if ($taxRate < 0) {
            throw new InvalidArgumentException('Tax rate can not be less than 0');
        }

        $this->taxRate = $taxRate;
        if (!$this->taxTableSelector) {
            $this->taxTableSelector = (string)$taxRate;
        }
        return $this;
    }

    /**
     * @param $quantity
     * @return CartItem
     */
    public function addQuantity($quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param string $merchantItemId
     * @return CartItem
     */
    public function addMerchantItemId(string $merchantItemId): CartItem
    {
        $this->merchantItemId = $merchantItemId;
        return $this;
    }

    /**
     * @param string $taxTableSelector
     * @return CartItem
     */
    public function addTaxTableSelector(string $taxTableSelector): CartItem
    {
        $this->taxTableSelector = $taxTableSelector;
        return $this;
    }

    /**
     * @param Weight $weight
     * @return CartItem
     */
    public function addWeight(Weight $weight): CartItem
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @param string $description
     * @return CartItem
     */
    public function addDescription(string $description): CartItem
    {
        $this->description = strip_tags($description);
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return array_merge(
            [
                'name' => $this->name ?? null,
                'description' => $this->description ?? '',
                'unit_price' => $this->getUnitPriceValue(),
                'currency' => $this->unitPrice ? $this->unitPrice->getCurrency() : '',
                'quantity' => $this->quantity ?? 0,
                'merchant_item_id' => !empty($this->getMerchantItemId()) ? $this->getMerchantItemId() : '',
                'tax_table_selector' => $this->taxTableSelector ?? '',
                'weight' => [
                    'unit' => $this->weight ? strtoupper($this->weight->getUnit()) : null,
                    'value' => $this->weight ? $this->weight->getQuantity() : null,
                ],
            ],
            $this->data
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    /**
     * @return float
     */
    public function getUnitPriceValue(): float
    {
        if ($this->unitPrice) {
            return $this->unitPrice->getAmount() / 100;
        }

        return $this->unitPriceValue->get() ?? 0.0;
    }

    /**
     * @return bool
     */
    public function hasTaxRate(): bool
    {
        return is_float($this->taxRate);
    }

    /**
     * @return float
     */
    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getMerchantItemId(): string
    {
        return $this->merchantItemId;
    }

    /**
     * @return string
     */
    public function getTaxTableSelector(): string
    {
        return $this->taxTableSelector;
    }

    /**
     * @return Weight
     */
    public function getWeight(): Weight
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
