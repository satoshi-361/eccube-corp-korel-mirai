<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface EccubeAddressAccessible
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface EccubeAddressAccessible
{
    /**
     * @return array
     */
    public function getEccubeAddressFormat(): array;
}
