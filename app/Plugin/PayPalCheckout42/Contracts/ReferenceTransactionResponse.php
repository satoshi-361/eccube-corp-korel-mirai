<?php

namespace Plugin\PayPalCheckout42\Contracts;

/**
 * Interface ReferenceTransactionResponse
 * @package Plugin\PayPalCheckout42\Contracts
 */
interface ReferenceTransactionResponse
{
    /**
     * @return string
     */
    public function getBillingAgreementId(): string;
}
