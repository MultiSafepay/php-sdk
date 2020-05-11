<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Categories\Category;
use MultiSafepay\Api\Categories\CategoryListing;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CategoryManager
 * @package MultiSafepay\Api
 */
class CategoryManager extends AbstractManager
{
    /**
     * @return Category[]
     * @throws ClientExceptionInterface
     */
    public function getCategories(): array
    {
        $response = $this->client->createGetRequest('categories');
        return (new CategoryListing($response->getResponseData()))->getCategories();
    }
}
