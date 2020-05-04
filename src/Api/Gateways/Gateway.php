<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Api\Gateways;

use MultiSafepay\Exception\InvalidDataInitializationException;

class Gateway
{
    /**
     * Available gateway codes
     */
    const AFTERPAY = 'AFTERPAY';
    const BANKTRANS = 'BANKTRANS';
    const CREDITCARD = 'CREDITCARD';
    const DIRECTBANK = 'DIRECTBANK';
    const DIRDEB = 'DIRDEB';
    const EINVOICE = 'EINVOICE';
    const EPS = 'EPS';
    const FASHIONCHQ = 'FASHIONCHQ';
    const FASHIONGFT = 'FASHIONGFT';
    const GIROPAY = 'GIROPAY';
    const IDEAL = 'IDEAL';
    const IDEALQR = 'IDEALQR';
    const KLARNA = 'KLARNA';
    const MAESTRO = 'MAESTRO';
    const MASTERCARD = 'MASTERCARD';
    const MISTERCASH = 'MISTERCASH';
    const PAYAFTER = 'PAYAFTER';
    const SANTANDER = 'SANTANDER';
    const TRUSTLY = 'TRUSTLY';
    const VISA = 'VISA';
    const VVVBON = 'VVVBON';

    /**
     * @var array
     */
    private $data;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->data['id'];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->data['description'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->data['type'] ?? '';
    }

    /**
     * @param array $data
     * @return bool
     */
    private function validate(array $data): bool
    {
        if (empty($data['id']) || empty($data['description'])) {
            throw new InvalidDataInitializationException('No ID or description');
        }

        if (!in_array($data['id'], self::getAvailableGateways())) {
            throw new InvalidDataInitializationException('ID "' . $data['id'] . '" is not a known gateway code');
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getAvailableGateways(): array
    {
        return [
            self::AFTERPAY,
            self::BANKTRANS,
            self::CREDITCARD,
            self::DIRDEB,
            self::DIRECTBANK,
            self::EINVOICE,
            self::EPS,
            self::FASHIONCHQ,
            self::FASHIONGFT,
            self::GIROPAY,
            self::IDEAL,
            self::IDEALQR,
            self::MASTERCARD,
            self::MAESTRO,
            self::MISTERCASH,
            self::PAYAFTER,
            self::SANTANDER,
            self::TRUSTLY,
            self::VISA,
            self::VVVBON,
        ];
    }
}
