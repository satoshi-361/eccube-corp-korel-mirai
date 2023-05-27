<?php

namespace Plugin\PayPalCheckout42\Contracts;

use Plugin\PayPalCheckout42\Entity\PaymentToken;

/**
 * Interface ShowOrderDetailsResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface ShowOrderDetailsResponse
{
    /**
     * @return string
     */
    public function getLiabilityShift(): string;

    /**
     * @return string
     */
    public function getEnrollmentStatus(): string;

    /**
     * @return string
     */
    public function getAuthenticationStatus(): string;

    /**
     * @return bool
     */
    public function isOk(): bool;
}
