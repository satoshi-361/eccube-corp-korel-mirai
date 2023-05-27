<?php

namespace Plugin\PayPalCheckout42\Lib\PayPalCheckoutSdk\Core;


use Plugin\PayPalCheckout42\Lib\PayPalHttp\Injector;

class GzipInjector implements Injector
{
    public function inject($httpRequest)
    {
        $httpRequest->headers["Accept-Encoding"] = "gzip";
    }
}
