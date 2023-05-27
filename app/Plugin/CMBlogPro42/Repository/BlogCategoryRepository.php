<?php

namespace Plugin\CMBlogPro42\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\CMBlogPro42\Entity\BlogCategory;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * BlogCategoryRepository
 */
class BlogCategoryRepository extends AbstractRepository
{
    /**
     * BlogCategoryRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogCategory::class);
    }

}
