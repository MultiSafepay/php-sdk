<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Utils;

use Exception;

/**
 * Class FixtureLoader
 * @package MultiSafepay\Tests\Utils
 */
class FixtureLoader
{
    /**
     * @param string $fixtureId ID identifying a JSON file in the fixture-data/ folder
     * @return array
     * @throws Exception
     */
    public static function loadFixtureDataById(string $fixtureId): array
    {
        $file = __DIR__ . '/../fixture-data/' . $fixtureId . '.json';
        if (!file_exists($file)) {
            throw new Exception('Mock data file "' . $file . '" could not be found');
        }

        return json_decode(file_get_contents($file), true);
    }
}
