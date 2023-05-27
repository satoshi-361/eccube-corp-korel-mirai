<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:06              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Repository;use Doctrine\ORM\EntityRepository;class AmazonOrderRepository extends EntityRepository{public $config;protected $app;public function setApplication($app){$this->app = $app;}public function setConfig(array $config){$this->config = $config;}public function getAmazonOrderByOrderDataForAdmin($Orders){goto Dgo78;Ys6L8:yVM7R:goto Zl4dK;Zl4dK:return $AmazonOrders;goto lzFQp;Dgo78:$AmazonOrders = [];goto mdEbN;mdEbN:foreach ($Orders as $Order) {goto EHH0X;PMgr2:$AmazonOrders[] = $AmazonOrder[0];goto qphkS;EHH0X:$AmazonOrder = $this->findby(['Order' => $Order]);goto dMWM2;n283Z:P26Kh:goto qusTH;qphkS:OsvO7:goto n283Z;dMWM2:if (empty($AmazonOrder)) {goto OsvO7;}goto PMgr2;qusTH:}goto Ys6L8;lzFQp:}}