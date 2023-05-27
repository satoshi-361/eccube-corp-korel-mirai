<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface GenerateClientTokenResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface GenerateClientTokenResponse
{
    /**
     * @return string
     */
    public function getClientToken(): string;
}
