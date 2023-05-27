<?php

namespace Plugin\PayPalCheckout42\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * Trait OrderTrait
 * @package Plugin\PayPalCheckout42\Entity
 *
 * @EntityExtension("Eccube\Entity\Order")
 */
trait OrderTrait
{
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\PayPalCheckout42\Entity\Transaction", mappedBy="Order", cascade={"persist", "remove"})
     */
    private $Transaction;

    private $yamatoOrderPayment;

    private $yamatoOrderStatus;

    /**
     * @param Transaction|null $transaction
     * @return $this
     */
    public function setTransaction(Transaction $transaction = null): self
    {
        $this->Transaction = $transaction;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTransaction()
    {
        return $this->Transaction;
    }
}
