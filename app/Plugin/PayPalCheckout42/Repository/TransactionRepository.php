<?php

namespace Plugin\PayPalCheckout42\Repository;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Eccube\Entity\Order;
use Eccube\Repository\AbstractRepository;
use Plugin\PayPalCheckout42\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TransactionRepository
 * @package Plugin\PayPalCheckout42\Repository
 */
class TransactionRepository extends AbstractRepository
{
    /**
     * TransactionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param Order $order
     * @param $response
     * @return Transaction
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveSuccessfulTransaction(Order $order, $response): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::create($order, $response);
        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush($transaction);
        return $transaction;
    }

    /**
     * @return mixed
     */
    public function findTransactions()
    {
        $query = $this->createQueryBuilder('t')->getQuery();
        $results = $query->getResult();
        return $results;
    }

    /**
     * @param int $id
     */
    public function findByOrderId(int $id)
    {
        $ovbject = $this->find($id);

        return $ovbject;
    }
}
