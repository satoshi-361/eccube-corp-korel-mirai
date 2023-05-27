<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Entity\Master;use Doctrine\ORM\Mapping as ORM;use Eccube\Entity\Master\AbstractMasterEntity;/**
 * AmazonStatus
 *
 * @ORM\Table(name="plg_amazon_pay_v2_status")
 * @ORM\Entity(repositoryClass="Plugin\AmazonPayV2_42\Repository\Master\AmazonStatusRepository")
 */
class AmazonStatus extends AbstractMasterEntity{const AUTHORI = 1;const CAPTURE = 2;const CANCEL = 3;}