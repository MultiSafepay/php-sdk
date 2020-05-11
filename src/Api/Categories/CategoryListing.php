<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Categories;

use MultiSafepay\Api\Categories\Category;

/**
 * Class CategoryListing
 * @package MultiSafepay\Api\Categories
 */
class CategoryListing
{
    /** @var array */
    private $categories;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $categories = [];
        if (!empty($data)) {
            foreach ($data as $categoryData) {
                $categories[] = new Category($categoryData);
            }
        }
        $this->categories = $categories;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}
