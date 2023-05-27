<?php

namespace Plugin\CMBlogPro42\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\CMBlogPro42\Entity\BlogProduct;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * BlogProductRepository
 */
class BlogProductRepository extends AbstractRepository
{
    /**
     * BlogProductRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogProduct::class);
    }

}
