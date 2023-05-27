<?php

namespace Plugin\CMBlogPro42\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductStatus
 *
 * @ORM\Table(name="plg_blog_sort")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator_type", type="string", length=255)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Plugin\CMBlogPro42\Repository\BlogSortRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class BlogSort extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
    */

    private $id;
    

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
    */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", options={"unsigned":true})
     */
    private $sort_no;

    /**
     * 公開日
     *
     * @var integer
     */
    const PUBLIC_DATE_SORT = 1;

    /**
     * 作成日
     *
     * @var integer
     */
    const CREATE_DATE_SORT = 2;

    /**
     * 更新日
     *
     * @var integer
     */
    const UPDATE_DATE_SORT = 3;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return BlogSort;
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set sortNo.
     *
     * @param int $sortNo
     *
     * @return BlogImage
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
}
