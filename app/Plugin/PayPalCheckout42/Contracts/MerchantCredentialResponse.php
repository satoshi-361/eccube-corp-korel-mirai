<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface MerchantCredentialResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface MerchantCredentialResponse
{
    /**
     * @return string
     */
    public function getClientId(): string;
    public function getClientSecret(): string;
}
