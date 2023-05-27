<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:06              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Repository;use Eccube\Common\EccubeConfig;use Eccube\Repository\AbstractRepository;use Plugin\AmazonPayV2_42\Entity\Config;use Doctrine\Persistence\ManagerRegistry;class ConfigRepository extends AbstractRepository{public function __construct(EccubeConfig $eccubeConfig, ManagerRegistry $managerRegistry, $entityClass = Config::class){parent::__construct($managerRegistry, $entityClass);$this->eccubeConfig = $eccubeConfig;}public function get($setting = false){goto RBbC0;Ib5QE:$Config->setPrivateKeyPath($this->eccubeConfig['amazon_pay_v2']['test_account']['private_key_path']);goto tHMXK;RBbC0:$Config = $this->find(1);goto b2BaE;b2BaE:if (!($setting === false && $Config->getAmazonAccountMode() == $this->eccubeConfig['amazon_pay_v2']['account_mode']['shared'])) {goto W7Mq2;}goto mjb7c;Eut3V:$Config->setPublicKeyId($this->eccubeConfig['amazon_pay_v2']['test_account']['public_key_id']);goto Ib5QE;tHMXK:$Config->setClientId($Config->getTestClientId());goto y0WtM;mjb7c:$Config->setSellerId($this->eccubeConfig['amazon_pay_v2']['test_account']['seller_id']);goto Eut3V;rxB3j:return $Config;goto zMlg2;y0WtM:W7Mq2:goto rxB3j;zMlg2:}}