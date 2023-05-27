<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:06              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Repository;use Doctrine\ORM\EntityRepository;class AmazonTradingRepository extends EntityRepository{public $config;public function setConfig(array $config){$this->config = $config;}}