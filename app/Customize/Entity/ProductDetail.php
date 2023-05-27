<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Eccube\Entity\Product;

/**
 * Block
 *
 * @ORM\Table(name="dtb_product_detail")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Customize\Repository\ProductDetailRepository")
 * @UniqueEntity(fields={"page_path"}, message="商品詳細履歴テーブル")
 */
class ProductDetail extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail", type="text", nullable=true)
     */
    private $detail;
    
    /**
     * @var \Eccube\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product", inversedBy="ProductDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $Product;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Customize\Entity\DetailImage", mappedBy="ProductDetail", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "sort_no"="ASC"
     * })
     */
    private $DetailImage;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", options={"unsigned":true})
     */
    private $sort_no;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetimetz")
     */
    private $create_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetimetz")
     */
    private $update_date;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->DetailImage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set detail.
     *
     * @param string $detail
     *
     * @return this
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail.
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set product.
     *
     * @param \Eccube\Entity\Product|null $product
     *
     * @return this
     */
    public function setProduct(Product $product = null)
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

    /**
     * Add detailImage.
     *
     * @param \Customize\Entity\DetailImage $detailImage
     *
     * @return this
     */
    public function addDetailImage(DetailImage $detailImage)
    {
        $this->DetailImage[] = $detailImage;

        return $this;
    }

    /**
     * Remove detailImage.
     *
     * @param \Customize\Entity\DetailImage $detailImage
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDetailImage(DetailImage $detailImage)
    {
        return $this->DetailImage->removeElement($detailImage);
    }

    /**
     * Get detailImage.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetailImage()
    {
        return $this->DetailImage;
    }

    /**
     * Set sortNo.
     *
     * @param int $sortNo
     *
     * @return ProductImage
     */
    public function setSortNo($sortNo)
    {
        $this->sort_no = $sortNo;

        return $this;
    }

    /**
     * Get sortNo.
     *
     * @return int
     */
    public function getSortNo()
    {
        return $this->sort_no;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(\DateTimeInterface $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }
}
