<?php

namespace Plugin\PayPalCheckout42\Lib\PayPalHttp;

/**
 * Interface Injector
 * @package Plugin\PayPalCheckout42\Lib\PayPalHttp
 *
 * Interface that can be implemented to apply injectors to Http client.
 *
 * @see HttpClient
 */
interface Injector
{
    /**
     * @param $httpRequest HttpRequest
     */
    public function inject($httpRequest);
}
