<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api;

use MultiSafepay\Api\Terminals\TerminalListing;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Class TerminalManager
 *
 * @package MultiSafepay\Api
 */
class TerminalManager extends AbstractManager
{
    private const ALLOWED_OPTIONS = [
        'page' => '',
        'limit' => '',
    ];

    /**
     * List POS terminals filtered by a terminal group id.
     *
     * Authentication for this endpoint requires a Merchant Account API Key.
     *
     * @param string $terminalGroupId
     * @param array $options
     * @return TerminalListing
     * @throws ClientExceptionInterface|ApiException
     */
    public function getTerminalsByGroup(string $terminalGroupId, array $options = []): TerminalListing
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);

        $endpoint = 'json/terminal-groups/' . $terminalGroupId . '/terminals';
        $context = ['terminal_group_id' => $terminalGroupId];

        $response = $this->client->createGetRequest($endpoint, $options, $context);

        return new TerminalListing($response->getResponseData(), $response->getPager());
    }

    /**
     * List all POS terminals bound to a MultiSafepay account.
     *
     * Authentication for this endpoint requires a Merchant Account API Key.
     *
     * @param array $options
     * @return TerminalListing
     * @throws ClientExceptionInterface|ApiException
     */
    public function getTerminals(array $options = []): TerminalListing
    {
        $options = array_intersect_key($options, self::ALLOWED_OPTIONS);
        $response = $this->client->createGetRequest('json/terminals', $options);

        return new TerminalListing($response->getResponseData(), $response->getPager());
    }
}
