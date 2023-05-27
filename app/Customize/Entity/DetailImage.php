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
use Eccube\Entity\Member;
use Customize\Entity\ProductDetail;

if (!class_exists('\Customize\Entity\DetailImage')) {
    /**
     * DetailImage
     *
     * @ORM\Table(name="dtb_detail_image")
     * @ORM\InheritanceType("SINGLE_TABLE")
     * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
     * @ORM\HasLifecycleCallbacks()
     * @ORM\Entity(repositoryClass="Customize\Repository\DetailImageRepository")
     */
    class DetailImage extends \Eccube\Entity\AbstractEntity
    {
        /**
         * @return string
         */
        public function __toString()
        {
            return (string) $this->getFileName();
        }

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
         * @ORM\Column(name="file_name", type="string", length=255)
         */
        private $file_name;

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
         * @var \Customize\Entity\ProductDetail
         *
         * @ORM\ManyToOne(targetEntity="Customize\Entity\ProductDetail", inversedBy="DetailImage")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="product_detail_id", referencedColumnName="id")
         * })
         */
        private $ProductDetail;

        /**
         * @var \Eccube\Entity\Member
         *
         * @ORM\ManyToOne(targetEntity="Eccube\Entity\Member")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
         * })
         */
        private $Creator;

        /**
         * Get id.
         *
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set fileName.
         *
         * @param string $fileName
         *
         * @return this
         */
        public function setFileName($fileName)
        {
            $this->file_name = $fileName;

            return $this;
        }

        /**
         * Get fileName.
         *
         * @return string
         */
        public function getFileName()
        {
            return $this->file_name;
        }

        /**
         * Set sortNo.
         *
         * @param int $sortNo
         *
         * @return this
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

        /**
         * Set createDate.
         *
         * @param \DateTime $createDate
         *
         * @return this
         */
        public function setCreateDate($createDate)
        {
            $this->create_date = $createDate;

            return $this;
        }

        /**
         * Get createDate.
         *
         * @return \DateTime
         */
        public function getCreateDate()
        {
            return $this->create_date;
        }

        /**
         * Set product.
         *
         * @param \Customize\Entity\ProductDetail|null $productDetail
         *
         * @return this
         */
        public function setProductDetail(ProductDetail $productDetail = null)
        {
            $this->ProductDetail = $productDetail;

            return $this;
        }

        /**
         * Get product.
         *
         * @return \Customize\Entity\ProductDetail|null
         */
        public function getProductDetail()
        {
            return $this->ProductDetail;
        }

        /**
         * Set creator.
         *
         * @param \Eccube\Entity\Member|null $creator
         *
         * @return this
         */
        public function setCreator(Member $creator = null)
        {
            $this->Creator = $creator;

            return $this;
        }

        /**
         * Get creator.
         *
         * @return \Eccube\Entity\Member|null
         */
        public function getCreator()
        {
            return $this->Creator;
        }
    }
}
