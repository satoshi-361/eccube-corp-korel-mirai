<?php
namespace Plugin\JsysAsi\Repository;

use Doctrine\Persistence\ManagerRegistry as RegistryInterface;
use Eccube\Repository\AbstractRepository;
use Plugin\JsysAsi\Entity\JsysAsiLoginHistoryStatus;

/**
 * ログイン履歴ステータスマスタRepository
 * @author manabe
 *
 */
class JsysAsiLoginHistoryStatusRepository extends AbstractRepository
{
    /**
     * JsysAsiLoginHistoryStatusRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JsysAsiLoginHistoryStatus::class);
    }

}
