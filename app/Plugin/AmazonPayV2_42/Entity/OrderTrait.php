<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Entity;use Eccube\Annotation\EntityExtension;use Doctrine\ORM\Mapping as ORM;/**
 * @EntityExtension("Eccube\Entity\Order")
 */
trait OrderTrait{public function getAmazonPayV2SumAuthoriAmount(){goto e3p8U;G0ogd:foreach ($this->AmazonPayV2AmazonTradings as $AmazonTrading) {$sumAuthoriAmount += $AmazonTrading->getAuthoriAmount();wsYX8:}goto dVDv0;e3p8U:$sumAuthoriAmount = 0;goto G0ogd;dVDv0:O9wWt:goto Ra6Z_;Ra6Z_:return $sumAuthoriAmount;goto fgvMC;fgvMC:}public function getAmazonPayV2SumCaptureAmount(){goto AMxX9;QKvwJ:return $sumCaptureAmount;goto oZDud;ULkC7:Bk_vs:goto QKvwJ;FwJ_d:foreach ($this->AmazonPayV2AmazonTradings as $AmazonTrading) {$sumCaptureAmount += $AmazonTrading->getCaptureAmount();wr4ju:}goto ULkC7;AMxX9:$sumCaptureAmount = 0;goto FwJ_d;oZDud:}    /**
     * @var string
     * 
     * @ORM\Column(name="amazonpay_v2_charge_permission_id", type="string", length=255, nullable=true)
     */
private $amazonpay_v2_charge_permission_id;    /**
     * @var integer
     * 
     * @ORM\Column(name="amazonpay_v2_billable_amount", type="integer", nullable=true)
     */
private $amazonpay_v2_billable_amount;    /**
     * @var AmazonStatus
     * @ORM\ManyToOne(targetEntity="Plugin\AmazonPayV2_42\Entity\Master\AmazonStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="amazonpay_v2_amazon_status_id", referencedColumnName="id")
     * })
     */
private $AmazonPayV2AmazonStatus;    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Plugin\AmazonPayV2_42\Entity\AmazonTrading", mappedBy="Order", cascade={"persist", "remove"})
     */
private $AmazonPayV2AmazonTradings;    /**
     * @var string
     * @ORM\Column(name="amazonpay_v2_session_temp", type="text", length=36777215, nullable=true)
     */
private $amazonpay_v2_session_temp;public function setAmazonPayV2ChargePermissionId($AmazonPayV2ChargePermissionId){$this->amazonpay_v2_charge_permission_id = $AmazonPayV2ChargePermissionId;return $this;}public function getAmazonPayV2ChargePermissionId(){return $this->amazonpay_v2_charge_permission_id;}public function setAmazonPayV2BillableAmount($amazonpayV2BillableAmount){$this->amazonpay_v2_billable_amount = $amazonpayV2BillableAmount;return $this;}public function getAmazonPayV2BillableAmount(){return $this->amazonpay_v2_billable_amount;}public function setAmazonPayV2AmazonStatus(\Plugin\AmazonPayV2_42\Entity\Master\AmazonStatus $AmazonPayV2AmazonStatus){$this->AmazonPayV2AmazonStatus = $AmazonPayV2AmazonStatus;return $this;}public function getAmazonPayV2AmazonStatus(){return $this->AmazonPayV2AmazonStatus;}public function addAmazonPayV2AmazonTrading(\Plugin\AmazonPayV2_42\Entity\AmazonTrading $AmazonPayV2AmazonTrading){$this->AmazonPayV2AmazonTradings[] = $AmazonPayV2AmazonTrading;return $this;}public function clearAmazonPayV2AmazonTradings(){$this->AmazonPayV2AmazonTradings->clear();return $this;}public function getAmazonPayV2AmazonTradings(){return $this->AmazonPayV2AmazonTradings;}public function setAmazonPayV2SessionTemp($AmazonPayV2SessionTemp){$this->amazonpay_v2_session_temp = $AmazonPayV2SessionTemp;return $this;}public function getAmazonPayV2SessionTemp(){return $this->amazonpay_v2_session_temp;}}