<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:06              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Repository;use Eccube\Repository\AbstractRepository;use Plugin\AmazonPayV2_42\Entity\PaymentStatus;use Doctrine\Persistence\ManagerRegistry;class PaymentStatusRepository extends AbstractRepository{public function __construct(ManagerRegistry $managerRegistry, $entityClass = PaymentStatus::class){parent::__construct($managerRegistry, $entityClass);}}