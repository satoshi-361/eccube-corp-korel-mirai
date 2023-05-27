<?php

namespace Plugin\CMBlogPro42\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\CMBlogPro42\Entity\Config;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * ConfigRepository
 */
class ConfigRepository extends AbstractRepository
{
    /**
     * ConfigRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Config::class);
    }

    /**
     * @param int $id
     *
     * @return null|Config
     */
    public function get($id = 1)
    {
        return $this->find($id);
    }
}
