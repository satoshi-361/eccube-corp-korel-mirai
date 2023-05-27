<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;
use Customize\Entity\ProductDetail;

/**
  * @EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Customize\Entity\ProductDetail", mappedBy="Product", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "sort_no"="ASC"
     * })
     */
    private $ProductDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="one_word", type="string", length=250, nullable=true)
     */
    private $one_word;
    
    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=500, nullable=true)
     */
    private $color;
    
    /**
     * @var string
     *
     * @ORM\Column(name="usage0", type="string", length=500, nullable=true)
     */
    private $usage0;
    
    /**
     * @var string
     *
     * @ORM\Column(name="catch_copy", type="string", length=500, nullable=true)
     */
    private $catch_copy;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title0", type="string", length=255, nullable=true)
     */
    private $title0;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title1", type="string", length=500, nullable=true)
     */
    private $title1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail1", type="text", nullable=true)
     */
    private $detail1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail_image1", type="string", length=150, nullable=true)
     */
    private $detail_image1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title2", type="string", length=500, nullable=true)
     */
    private $title2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail2", type="text", nullable=true)
     */
    private $detail2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail_image2", type="string", length=150, nullable=true)
     */
    private $detail_image2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title3", type="string", length=500, nullable=true)
     */
    private $title3;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail3", type="text", nullable=true)
     */
    private $detail3;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail_image3", type="string", length=150, nullable=true)
     */
    private $detail_image3;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title4", type="string", length=500, nullable=true)
     */
    private $title4;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail4", type="text", nullable=true)
     */
    private $detail4;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail_image4", type="string", length=150, nullable=true)
     */
    private $detail_image4;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title5", type="string", length=500, nullable=true)
     */
    private $title5;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail5", type="text", nullable=true)
     */
    private $detail5;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title6", type="string", length=500, nullable=true)
     */
    private $title6;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail6", type="text", nullable=true)
     */
    private $detail6;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title7", type="string", length=500, nullable=true)
     */
    private $title7;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail7", type="text", nullable=true)
     */
    private $detail7;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title8", type="string", length=500, nullable=true)
     */
    private $title8;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail8", type="text", nullable=true)
     */
    private $detail8;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title9", type="string", length=500, nullable=true)
     */
    private $title9;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail9", type="text", nullable=true)
     */
    private $detail9;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title10", type="string", length=500, nullable=true)
     */
    private $title10;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail10", type="text", nullable=true)
     */
    private $detail10;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_name", type="string", length=500, nullable=true)
     */
    private $property_name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_color", type="string", length=500, nullable=true)
     */
    private $property_color;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_size", type="string", length=500, nullable=true)
     */
    private $property_size;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_heatproof", type="string", length=100, nullable=true)
     */
    private $property_heatproof;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_material", type="string", length=500, nullable=true)
     */
    private $property_material;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_country", type="string", length=500, nullable=true)
     */
    private $property_country;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_usage", type="string", length=500, nullable=true)
     */
    private $property_usage;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_jan", type="string", length=500, nullable=true)
     */
    private $property_jan;
    
    /**
     * @var string
     *
     * @ORM\Column(name="property_note", type="string", length=500, nullable=true)
     */
    private $property_note;
    
    /**
     * @var string
     *
     * @ORM\Column(name="existing_site", type="string", length=500, nullable=true)
     */
    private $existing_site;

    /**
     * @var string
     *
     * @ORM\Column(name="reference_video", type="string", length=250, nullable=true)
     */
    private $reference_video;

    /**
     * @var string
     *
     * @ORM\Column(name="manual", type="string", length=250, nullable=true)
     */
    private $manual;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Customize\Entity\BrowsedProduct", mappedBy="Product", cascade={"persist","remove"})
     */
    private $BrowsedProducts;
    
    /**
     * Set one_word.
     *
     * @param string $one_word
     *
     * @return this
     */
    public function setOneWord($one_word = null)
    {
        $this->one_word = $one_word;

        return $this;
    }

    /**
     * Get one_word.
     *
     * @return string
     */
    public function getOneWord()
    {
        return $this->one_word;
    }
    
    /**
     * Set color.
     *
     * @param string $color
     *
     * @return this
     */
    public function setColor($color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * Set usage0.
     *
     * @param string $usage0
     *
     * @return this
     */
    public function setUsage0($usage0 = null)
    {
        $this->usage0 = $usage0;

        return $this;
    }

    /**
     * Get usausage0ge.
     *
     * @return string
     */
    public function getUsage0()
    {
        return $this->usage0;
    }
    
    /**
     * Set catch_copy.
     *
     * @param string $catch_copy
     *
     * @return this
     */
    public function setCatchCopy($catch_copy = null)
    {
        $this->catch_copy = $catch_copy;

        return $this;
    }

    /**
     * Get catch_copy.
     *
     * @return string
     */
    public function getCatchCopy()
    {
        return $this->catch_copy;
    }
    
    /**
     * Set title0.
     *
     * @param string $title0
     *
     * @return this
     */
    public function setTitle0($title0 = null)
    {
        $this->title0 = $title0;

        return $this;
    }

    /**
     * Get title0.
     *
     * @return string
     */
    public function getTitle0()
    {
        return $this->title0;
    }
    
    /**
     * Set title1.
     *
     * @param string $title1
     *
     * @return this
     */
    public function setTitle1($title1 = null)
    {
        $this->title1 = $title1;

        return $this;
    }

    /**
     * Get title1.
     *
     * @return string
     */
    public function getTitle1()
    {
        return $this->title1;
    }
    
    /**
     * Set detail1.
     *
     * @param string $detail1
     *
     * @return this
     */
    public function setDetail1($detail1 = null)
    {
        $this->detail1 = $detail1;

        return $this;
    }

    /**
     * Get detail1.
     *
     * @return string
     */
    public function getDetail1()
    {
        return $this->detail1;
    }
    
    /**
     * Set title2.
     *
     * @param string $title2
     *
     * @return this
     */
    public function setTitle2($title2 = null)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2.
     *
     * @return string
     */
    public function getTitle2()
    {
        return $this->title2;
    }
    
    /**
     * Set detail2.
     *
     * @param string $detail2
     *
     * @return this
     */
    public function setDetail2($detail2 = null)
    {
        $this->detail2 = $detail2;

        return $this;
    }

    /**
     * Get detail2.
     *
     * @return string
     */
    public function getDetail2()
    {
        return $this->detail2;
    }
    
    /**
     * Set title3.
     *
     * @param string $title3
     *
     * @return this
     */
    public function setTitle3($title3 = null)
    {
        $this->title3 = $title3;

        return $this;
    }

    /**
     * Get title3.
     *
     * @return string
     */
    public function getTitle3()
    {
        return $this->title3;
    }
    
    /**
     * Set detail3.
     *
     * @param string $detail3
     *
     * @return this
     */
    public function setDetail3($detail3 = null)
    {
        $this->detail3 = $detail3;

        return $this;
    }

    /**
     * Get detail3.
     *
     * @return string
     */
    public function getDetail3()
    {
        return $this->detail3;
    }
    
    /**
     * Set title4.
     *
     * @param string $title4
     *
     * @return this
     */
    public function setTitle4($title4 = null)
    {
        $this->title4 = $title4;

        return $this;
    }

    /**
     * Get title4.
     *
     * @return string
     */
    public function getTitle4()
    {
        return $this->title4;
    }
    
    /**
     * Set detail4.
     *
     * @param string $detail4
     *
     * @return this
     */
    public function setDetail4($detail4 = null)
    {
        $this->detail4 = $detail4;

        return $this;
    }

    /**
     * Get detail4.
     *
     * @return string
     */
    public function getDetail4()
    {
        return $this->detail4;
    }
    
    /**
     * Set title5.
     *
     * @param string $title5
     *
     * @return this
     */
    public function setTitle5($title5 = null)
    {
        $this->title5 = $title5;

        return $this;
    }

    /**
     * Get title5.
     *
     * @return string
     */
    public function getTitle5()
    {
        return $this->title5;
    }
    
    /**
     * Set detail5.
     *
     * @param string $detail5
     *
     * @return this
     */
    public function setDetail5($detail5 = null)
    {
        $this->detail5 = $detail5;

        return $this;
    }

    /**
     * Get detail5.
     *
     * @return string
     */
    public function getDetail5()
    {
        return $this->detail5;
    }
    
    /**
     * Set title6.
     *
     * @param string $title6
     *
     * @return this
     */
    public function setTitle6($title6 = null)
    {
        $this->title6 = $title6;

        return $this;
    }

    /**
     * Get title6.
     *
     * @return string
     */
    public function getTitle6()
    {
        return $this->title6;
    }
    
    /**
     * Set detail6.
     *
     * @param string $detail6
     *
     * @return this
     */
    public function setDetail6($detail6 = null)
    {
        $this->detail6 = $detail6;

        return $this;
    }

    /**
     * Get detail6.
     *
     * @return string
     */
    public function getDetail6()
    {
        return $this->detail6;
    }
    
    /**
     * Set title7.
     *
     * @param string $title7
     *
     * @return this
     */
    public function setTitle7($title7 = null)
    {
        $this->title7 = $title7;

        return $this;
    }

    /**
     * Get title7.
     *
     * @return string
     */
    public function getTitle7()
    {
        return $this->title7;
    }
    
    /**
     * Set detail7.
     *
     * @param string $detail7
     *
     * @return this
     */
    public function setDetail7($detail7 = null)
    {
        $this->detail7 = $detail7;

        return $this;
    }

    /**
     * Get detail7.
     *
     * @return string
     */
    public function getDetail7()
    {
        return $this->detail7;
    }
    
    /**
     * Set title8.
     *
     * @param string $title8
     *
     * @return this
     */
    public function setTitle8($title8 = null)
    {
        $this->title8 = $title8;

        return $this;
    }

    /**
     * Get title8.
     *
     * @return string
     */
    public function getTitle8()
    {
        return $this->title8;
    }
    
    /**
     * Set detail8.
     *
     * @param string $detail8
     *
     * @return this
     */
    public function setDetail8($detail8 = null)
    {
        $this->detail8 = $detail8;

        return $this;
    }

    /**
     * Get detail8.
     *
     * @return string
     */
    public function getDetail8()
    {
        return $this->detail8;
    }
    
    /**
     * Set title9.
     *
     * @param string $title9
     *
     * @return this
     */
    public function setTitle9($title9 = null)
    {
        $this->title9 = $title9;

        return $this;
    }

    /**
     * Get title9.
     *
     * @return string
     */
    public function getTitle9()
    {
        return $this->title9;
    }
    
    /**
     * Set detail9.
     *
     * @param string $detail9
     *
     * @return this
     */
    public function setDetail9($detail9 = null)
    {
        $this->detail9 = $detail9;

        return $this;
    }

    /**
     * Get detail9.
     *
     * @return string
     */
    public function getDetail9()
    {
        return $this->detail9;
    }
    
    /**
     * Set title10.
     *
     * @param string $title10
     *
     * @return this
     */
    public function setTitle10($title10 = null)
    {
        $this->title10 = $title10;

        return $this;
    }

    /**
     * Get title10.
     *
     * @return string
     */
    public function getTitle10()
    {
        return $this->title10;
    }
    
    /**
     * Set detail10.
     *
     * @param string $detail10
     *
     * @return this
     */
    public function setDetail10($detail10 = null)
    {
        $this->detail10 = $detail10;

        return $this;
    }

    /**
     * Get detail10.
     *
     * @return string
     */
    public function getDetail10()
    {
        return $this->detail10;
    }
    
    /**
     * Set property_name.
     *
     * @param string $property_name
     *
     * @return this
     */
    public function setPropertyName($property_name = null)
    {
        $this->property_name = $property_name;

        return $this;
    }

    /**
     * Get property_name.
     *
     * @return string
     */
    public function getPropertyName()
    {
        return $this->property_name;
    }
    
    /**
     * Set property_color.
     *
     * @param string $property_color
     *
     * @return this
     */
    public function setPropertyColor($property_color = null)
    {
        $this->property_color = $property_color;

        return $this;
    }

    /**
     * Get property_color.
     *
     * @return string
     */
    public function getPropertyColor()
    {
        return $this->property_color;
    }
    
    /**
     * Set property_size.
     *
     * @param string $property_size
     *
     * @return this
     */
    public function setPropertySize($property_size = null)
    {
        $this->property_size = $property_size;

        return $this;
    }

    /**
     * Get property_size.
     *
     * @return string
     */
    public function getPropertySize()
    {
        return $this->property_size;
    }
    
    /**
     * Set property_heatproof.
     *
     * @param string $property_heatproof
     *
     * @return this
     */
    public function setPropertyHeatproof($property_heatproof = null)
    {
        $this->property_heatproof = $property_heatproof;

        return $this;
    }

    /**
     * Get property_heatproof.
     *
     * @return string
     */
    public function getPropertyHeatproof()
    {
        return $this->property_heatproof;
    }
    
    /**
     * Set property_material.
     *
     * @param string $property_material
     *
     * @return this
     */
    public function setPropertyMaterial($property_material = null)
    {
        $this->property_material = $property_material;

        return $this;
    }

    /**
     * Get property_material.
     *
     * @return string
     */
    public function getPropertyMaterial()
    {
        return $this->property_material;
    }
    
    /**
     * Set property_country.
     *
     * @param string $property_country
     *
     * @return this
     */
    public function setPropertyCountry($property_country = null)
    {
        $this->property_country = $property_country;

        return $this;
    }

    /**
     * Get property_country.
     *
     * @return string
     */
    public function getPropertyCountry()
    {
        return $this->property_country;
    }
    
    /**
     * Set property_usage.
     *
     * @param string $property_usage
     *
     * @return this
     */
    public function setPropertyUsage($property_usage = null)
    {
        $this->property_usage = $property_usage;

        return $this;
    }

    /**
     * Get property_usage.
     *
     * @return string
     */
    public function getPropertyUsage()
    {
        return $this->property_usage;
    }
    
    /**
     * Set property_jan.
     *
     * @param string $property_jan
     *
     * @return this
     */
    public function setPropertyJan($property_jan = null)
    {
        $this->property_jan = $property_jan;

        return $this;
    }

    /**
     * Get property_jan.
     *
     * @return string
     */
    public function getPropertyJan()
    {
        return $this->property_jan;
    }
    
    /**
     * Set property_note.
     *
     * @param string $property_note
     *
     * @return this
     */
    public function setPropertyNote($property_note = null)
    {
        $this->property_note = $property_note;

        return $this;
    }

    /**
     * Get property_note.
     *
     * @return string
     */
    public function getPropertyNote()
    {
        return $this->property_note;
    }
    
    /**
     * Set existing_site.
     *
     * @param string $existing_site
     *
     * @return this
     */
    public function setExistingSite($existing_site = null)
    {
        $this->existing_site = $existing_site;

        return $this;
    }

    /**
     * Get existing_site.
     *
     * @return string
     */
    public function getExistingSite()
    {
        return $this->existing_site;
    }
    
    /**
     * Set reference_video.
     *
     * @param string $reference_video
     *
     * @return this
     */
    public function setReferenceVideo($reference_video = null)
    {
        $this->reference_video = $reference_video;

        return $this;
    }

    /**
     * Get reference_video.
     *
     * @return string
     */
    public function getReferenceVideo()
    {
        return $this->reference_video;
    }
    
    /**
     * Set manual.
     *
     * @param string $manual
     *
     * @return this
     */
    public function setManual($manual = null)
    {
        $this->manual = $manual;

        return $this;
    }

    /**
     * Get manual.
     *
     * @return string
     */
    public function getManual()
    {
        return $this->manual;
    }
    
    /**
     * Set detail_image1.
     *
     * @param string $detail_image1
     *
     * @return this
     */
    public function setDetailImage1($detail_image1 = null)
    {
        $this->detail_image1 = $detail_image1;

        return $this;
    }

    /**
     * Get detail_image1.
     *
     * @return string
     */
    public function getDetailImage1()
    {
        return $this->detail_image1;
    }
    
    /**
     * Set detail_image2.
     *
     * @param string $detail_image2
     *
     * @return this
     */
    public function setDetailImage2($detail_image2 = null)
    {
        $this->detail_image2 = $detail_image2;

        return $this;
    }

    /**
     * Get detail_image2.
     *
     * @return string
     */
    public function getDetailImage2()
    {
        return $this->detail_image2;
    }
    
    /**
     * Set detail_image3.
     *
     * @param string $detail_image3
     *
     * @return this
     */
    public function setDetailImage3($detail_image3 = null)
    {
        $this->detail_image3 = $detail_image3;

        return $this;
    }

    /**
     * Get detail_image3.
     *
     * @return string
     */
    public function getDetailImage3()
    {
        return $this->detail_image3;
    }
    
    /**
     * Set detail_image4.
     *
     * @param string $detail_image4
     *
     * @return this
     */
    public function setDetailImage4($detail_image4 = null)
    {
        $this->detail_image4 = $detail_image4;

        return $this;
    }

    /**
     * Get detail_image4.
     *
     * @return string
     */
    public function getDetailImage4()
    {
        return $this->detail_image4;
    }

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
     * Add BrowsedProduct.
     *
     * @param \Customize\Entity\ProductDetail $ProductDetail
     *
     * @return this
     */
    public function addProductDetail(ProductDetail $ProductDetail)
    {
        $this->checkProductDetailsInit();

        $this->ProductDetails[] = $ProductDetail;

        return $this;
    }

    /**
     * Remove ProductDetail.
     *
     * @param \Customize\Entity\ProductDetail $ProductDetail
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProductDetail(ProductDetail $ProductDetail)
    {
        $this->checkProductDetailsInit();
        return $this->ProductDetails->removeElement($ProductDetail);
    }

    /**
     * Get ProductDetails.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductDetails()
    {
        $this->checkProductDetailsInit();
        return $this->ProductDetails;
    }

    private function checkProductDetailsInit ()
    {
        if (!$this->ProductDetails) {
            $this->ProductDetails = new \Doctrine\Common\Collections\ArrayCollection();
        }
    }
}