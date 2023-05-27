<?php

namespace Plugin\PayPalCheckout42\Lib\PayPalHttp;

/**
 * Interface Environment
 * @package Plugin\PayPalCheckout42\Lib\PayPalHttp
 *
 * Describes a domain that hosts a REST API, against which an HttpClient will make requests.
 * @see HttpClient
 */
interface Environment
{
    /**
     * @return string
     */
    public function baseUrl();
}
