<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface PartnerReferralsResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface PartnerReferralsResponse
{
    /**
     * @return string
     */
    public function getActionUrl(): string;
}
