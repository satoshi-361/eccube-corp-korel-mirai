<?php

namespace Plugin\PayPalCheckout42\Contracts;

use Plugin\PayPalCheckout42\Entity\PaymentToken;

/**
 * Interface GeneratePaymentTokenResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface GeneratePaymentTokenResponse
{
    /**
     * @return PaymentToken[]
     */
    public function getPaymentTokens(): array;
}
