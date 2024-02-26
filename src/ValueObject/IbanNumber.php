<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\ValueObject;

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
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
     * @return bool
     */
    public function validate(string $ibanNumber): bool
    {
        if (strlen($ibanNumber) < 8) {
            throw new InvalidArgumentException('Bank account "' . $ibanNumber . '" is invalid');
        }

        if (!preg_match('/^([a-z]{2})([0-9]{2})/', strtolower($ibanNumber))) {
            throw new InvalidArgumentException('Bank account "' . $ibanNumber . '" is invalid');
        }

        $this->validateWithIbanLibrary($ibanNumber);

        return true;
    }

    /**
     * @param string $ibanNumber
     * @throws InvalidArgumentException
     * @return bool
     */
    private function validateWithIbanLibrary(string $ibanNumber): bool
    {
        if (!class_exists(\Iban\Validation\Iban::class)) {
            return false;
        }

        if (!class_exists(\Iban\Validation\Validator::class)) {
            return false;
        }

        $iban = new \Iban\Validation\Iban($ibanNumber);
        $validator = new \Iban\Validation\Validator();

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
