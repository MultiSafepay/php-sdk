<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject\Customer;

/**
 * Class AddressParser
 *
 * @package MultiSafepay\ValueObject\Customer
 */
class AddressParser
{
    /**
     * Parses and splits up an address in street and house number
     *
     * @param string $address1
     * @param string $address2
     * @return string[]
     */
    public function parse(string $address1, string $address2 = ''): array
    {
        // Remove whitespaces from the beginning and end
        $fullAddress = trim("$address1 $address2");

        // Turn multiple whitespaces into one single whitespace
        $fullAddress = preg_replace('/[[:blank:]]+/', ' ', $fullAddress);

        // Split the address into 3 groups: street, apartment and extension
        $pattern = '/(.+?)\s?([\d]+[\S]*)((\s?[A-z])*?)$/';
        preg_match($pattern, $fullAddress, $matches);

        if (!$matches) {
            return [$fullAddress, ''];
        }

        return $this->extractStreetAndApartment(
            $matches[1] ?? '',
            $matches[2] ?? '',
            $matches[3] ?? ''
        );
    }

    /**
     * Extract the street and apartment from the matched RegEx results
     *
     * When the address starts with a number, it is most likely that $group1 and $group2 are the house number and
     * extension. We therefore check if $group1 and $group2 are numeric, if so, we can assume that $group3
     * will be the street and return $group1 and $group2 together as the apartment.
     * If $group1 or $group2 contains more than just numbers, we can assume $group1 is the street and $group2 and
     * $group3 are the house number and extension. We therefore return $group1 as the street and return $group2 and
     * $group3 together as the apartment.
     *
     * @param string $group1
     * @param string $group2
     * @param string $group3
     * @return array
     */
    public function extractStreetAndApartment(string $group1, string $group2, string $group3): array
    {
        if (is_numeric($group1) && is_numeric($group2)) {
            return [trim($group3), trim($group1 . $group2)];
        }

        return [trim($group1), trim($group2 . $group3)];
    }
}
