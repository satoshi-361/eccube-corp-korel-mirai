<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
  * @EntityExtension("Eccube\Entity\Category")
 */
trait CategoryTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=250, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="en_name", type="string", length=250, nullable=true)
     */
    private $en_name;
    
    /**
     * Set image.
     *
     * @param string $image
     *
     * @return this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set en_name.
     *
     * @param string $enName
     *
     * @return this
     */
    public function setEnName($enName)
    {
        $this->en_name = $enName;

        return $this;
    }

    /**
     * Get en_name.
     *
     * @return string
     */
    public function getEnName()
    {
        return $this->en_name;
    }
}