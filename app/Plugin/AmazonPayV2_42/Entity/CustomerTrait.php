<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Entity;use Eccube\Annotation\EntityExtension;use Doctrine\ORM\Mapping as ORM;/**
 * @EntityExtension("Eccube\Entity\Customer")
 */
trait CustomerTrait{    /**
     * @var string
     * 
     * @ORM\Column(name="v2_amazon_user_id", type="string", length=255, nullable=true)
     */
private $v2_amazon_user_id;public function setV2AmazonUserId($v2_amazon_user_id){$this->v2_amazon_user_id = $v2_amazon_user_id;return $this;}public function getV2AmazonUserId(){return $this->v2_amazon_user_id;}}