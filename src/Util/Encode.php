<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Util;

/**
 * Class Encode
 * @package MultiSafepay\Util
 */
class Encode
{
    /**
     * Encodes a string for use in a URL according to RFC 3986,
     * while preserving any existing valid URL-encoded sequences.
     *
     * @param string $string
     * @return string
     */
    public static function encode(string $string): string
    {
        // Split the string by '%' to inspect potential encoding sequences
        $parts = explode('%', $string);
        $encoded = array_shift($parts);

        // Encode the first part (everything before the first %)
        $encoded = rawurlencode($encoded);

        foreach ($parts as $part) {
            // If the part is shorter than 2 characters, it can't be a valid hex code
            // So we treat the preceding '%' as a literal that needs encoding (%25)
            if (strlen($part) < 2) {
                $encoded .= '%25' . rawurlencode($part);
                continue;
            }

            // Extract the potential hex code (first 2 chars)
            $hex = substr($part, 0, 2);
            $rest = substr($part, 2);

            // Check if it is a valid hex sequence used in URL encoding
            if (!ctype_xdigit($hex)) {
                // Not a valid hex code, so the '%' was literal
                $encoded .= '%25' . rawurlencode($part);
                continue;
            }

            // It looks like a valid encoded sequence (e.g. "20" from "%20")
            // Append it back as-is ("%20") and encode the rest of the string
            $encoded .= '%' . $hex . rawurlencode($rest);
        }

        return $encoded;
    }
}
