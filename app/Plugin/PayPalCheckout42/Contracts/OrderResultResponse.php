<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface OrderResultResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface OrderResultResponse
{
    /**
     * @return string
     */
    public function getOrderingId(): string;
}
