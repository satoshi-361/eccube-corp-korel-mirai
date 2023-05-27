<?php

namespace Plugin\PayPalCheckout42\Lib\PayPalCheckoutSdk\Core;

use Plugin\PayPalCheckout42\Lib\PayPalHttp\Environment;

abstract class PayPalEnvironment implements Environment
{
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function authorizationString()
    {
        return base64_encode($this->clientId . ":" . $this->clientSecret);
    }
}

