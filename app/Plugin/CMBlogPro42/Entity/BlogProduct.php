<?php

namespace Plugin\CMBlogPro42\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogProduct
 *
 * @ORM\Table(name="plg_blog_blog_product")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Plugin\CMBlogPro42\Repository\BlogProductRepository")
 */
class BlogProduct
{
    /** ymk
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Plugin\CMBlogPro42\Entity\Blog
     *
     * @ORM\ManyToOne(targetEntity="Plugin\CMBlogPro42\Entity\Blog", inversedBy="BlogProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     * })
     */
    private $Blog;

    /**
     * @var \Eccube\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product", inversedBy="BlogProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $Product;

    /** ymk
     * Get id.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set blog.
     *
     * @param \Plugin\CMBlogPro42\Entity\Blog|null $blog
     *
     * @return BlogProduct
     */
    public function setBlog(\Plugin\CMBlogPro42\Entity\Blog $blog = null)
    {
        $this->Blog = $blog;

        return $this;
    }

    /**
     * Get blog.
     *
     * @return \Plugin\CMBlogPro42\Entity\Blog|null
     */
    public function getBlog()
    {
        return $this->Blog;
    }

    /**
     * Set product.
     *
     * @param \Eccube\Entity\Product|null $product
     *
     * @return BlogProduct
     */
    public function setProduct(\Eccube\Entity\Product $product = null)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Eccube\Entity\Product|null
     */
    public function getProduct()
    {
        return $this->Product;
    }
}
