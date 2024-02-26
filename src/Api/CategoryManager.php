<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Categories\Category;
use MultiSafepay\Api\Categories\CategoryListing;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidDataInitializationException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class CategoryManager
 * @package MultiSafepay\Api
 */
class CategoryManager extends AbstractManager
{
    /**
     * @return Category[]
     * @throws ClientExceptionInterface|InvalidDataInitializationException|ApiException
     */
    public function getCategories(): array
    {
        $response = $this->client->createGetRequest('json/categories');
        return (new CategoryListing($response->getResponseData()))->getCategories();
    }
}
