<?php

namespace Plugin\PayPalCheckout42\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * Trait CustomerTrait
 * @package Plugin\PayPalCheckout42\Entity
 *
 * @EntityExtension("Eccube\Entity\Customer")
 */
trait CustomerTrait
{
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\PayPalCheckout42\Entity\SubscribingCustomer", mappedBy="Customer", cascade={"persist", "remove"})
     */
    private $SubscribingCustomers;
}
