<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

use Iban\Validation\Iban;
use Iban\Validation\Validator;
use MultiSafepay\Exception\InvalidArgumentException;

/**
 * Class IbanNumber
 * @package MultiSafepay\ValueObject
 * phpcs:disable ObjectCalisthenics.Files.FunctionLength
 */
class IbanNumber
{
    /**
     * @var string
     */
    private $ibanNumber = '';

    /**
     * Country constructor.
     * @param string $ibanNumber
     */
    public function __construct(string $ibanNumber)
    {
        $this->validate($ibanNumber);
        $this->ibanNumber = $ibanNumber;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->ibanNumber;
    }

    /**
     * @param string $ibanNumber
     * @return bool
     */
    public function validate(string $ibanNumber): bool
    {
        $iban = new Iban($ibanNumber);
        $validator = new Validator();

        if (!$validator->validate($iban)) {
            $messages = [];
            foreach ($validator->getViolations() as $violation) {
                $messages[] = $violation;
            }

            $msg = 'Bank account "' . $ibanNumber . '" is invalid: ' . implode('; ', $messages);
            throw new InvalidArgumentException($msg);
        }

        return true;
    }
}
