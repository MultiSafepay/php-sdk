<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Tokens;

class TokenListing
{
    /**
     * @var Token[]
     */
    private $tokens;

    /**
     * TokenListing constructor.
     * @param array $tokens
     */
    public function __construct(array $tokens)
    {
        foreach ($tokens as $token) {
            $this->tokens[] = new Token($token);
        }
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
