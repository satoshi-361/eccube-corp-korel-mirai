<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
  * @EntityExtension("Eccube\Entity\Customer")
 */
trait CustomerTrait
{    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Customize\Entity\BrowsedProduct", mappedBy="Customer", cascade={"persist","remove"})
     */
    private $BrowsedProducts;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Customize\Entity\BrowsedBlog", mappedBy="Customer", cascade={"persist","remove"})
     */
    private $BrowsedBlogs;

    /**
     * Add BrowsedProduct.
     *
     * @param \Customize\Entity\BrowsedProduct $BrowsedProduct
     *
     * @return this
     */
    public function addBrowsedProduct(BrowsedProduct $BrowsedProduct)
    {
        $this->checkBrowsedProductsInit();

        $this->BrowsedProducts[] = $BrowsedProduct;

        return $this;
    }

    /**
     * Remove BrowsedProduct.
     *
     * @param \Customize\Entity\BrowsedProduct $BrowsedProduct
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBrowsedProduct(BrowsedProduct $BrowsedProduct)
    {
        $this->checkBrowsedProductsInit();
        return $this->BrowsedProducts->removeElement($BrowsedProduct);
    }

    /**
     * Get BrowsedProducts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrowsedProducts()
    {
        $this->checkBrowsedProductsInit();
        return $this->BrowsedProducts;
    }

    private function checkBrowsedProductsInit ()
    {
        if (!$this->BrowsedProducts) {
            $this->BrowsedProducts = new \Doctrine\Common\Collections\ArrayCollection();
        }
    }

    /**
     * Add browsedBlog.
     *
     * @param \Customize\Entity\BrowsedBlog $browsedBlog
     *
     * @return this
     */
    public function addBrowsedBlog(BrowsedBlog $browsedBlog)
    {
        $this->checkBrowsedBlogsInit();

        $this->BrowsedBlogs[] = $browsedBlog;

        return $this;
    }

    /**
     * Remove browsedBlog.
     *
     * @param \Customize\Entity\BrowsedBlog $browsedBlog
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBrowsedBlog(BrowsedBlog $browsedBlog)
    {
        $this->checkBrowsedBlogsInit();
        return $this->BrowsedBlogs->removeElement($browsedBlog);
    }

    /**
     * Get BrowsedBlogs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrowsedBlogs()
    {
        $this->checkBrowsedBlogsInit();
        return $this->BrowsedBlogs;
    }

    private function checkBrowsedBlogsInit ()
    {
        if (!$this->BrowsedBlogs) {
            $this->BrowsedBlogs = new \Doctrine\Common\Collections\ArrayCollection();
        }
    }
}