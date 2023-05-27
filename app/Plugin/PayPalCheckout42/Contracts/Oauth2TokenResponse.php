<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface Oauth2TokenResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface Oauth2TokenResponse
{
    /**
     * @return string
     */
    public function getAccessToken(): string;
}
