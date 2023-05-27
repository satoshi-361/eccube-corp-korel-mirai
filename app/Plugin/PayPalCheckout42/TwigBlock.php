<?php

namespace Plugin\PayPalCheckout42;

use Eccube\Common\EccubeTwigBlock;

/**
 * Class TwigBlock
 * @package Plugin\PayPalCheckout42
 */
class TwigBlock implements EccubeTwigBlock
{
    /**
     * @return array
     */
    public static function getTwigBlock()
    {
        return [
            '@PayPalCheckout42/default/Block/paypal_logo.twig'
        ];
    }
}
