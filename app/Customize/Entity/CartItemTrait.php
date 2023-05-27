<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
  * @EntityExtension("Eccube\Entity\CartItem")
 */
trait CartItemTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="property", type="string", length=250, nullable=true)
     */
    private $property;
    
    /**
     * Set property.
     *
     * @param string $property
     *
     * @return this
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property.
     *
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
}