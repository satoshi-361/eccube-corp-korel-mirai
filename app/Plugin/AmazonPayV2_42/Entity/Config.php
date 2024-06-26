<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Entity;use Doctrine\ORM\Mapping as ORM;use Eccube\Entity\AbstractEntity;/**
 * Config
 *
 * @ORM\Table(name="plg_amazon_pay_v2_config")
 * @ORM\Entity(repositoryClass="Plugin\AmazonPayV2_42\Repository\ConfigRepository")
 */
class Config extends AbstractEntity{    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
private $id;    /**
     * @ORM\Column(name="amazon_account_mode", type="integer", nullable=true)
     */
private $amazon_account_mode;    /**
     * @var integer
     *
     * @ORM\Column(name="env", type="integer")
     */
private $env;    /**
     * @var string
     *
     * @ORM\Column(name="seller_id", type="string", length=255, nullable=true)
     */
private $seller_id;    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=255, nullable=true)
     */
private $client_id;    /**
     * @var string
     *
     * @ORM\Column(name="test_client_id", type="string", length=255, nullable=true)
     */
private $test_client_id;    /**
     * @var string
     *
     * @ORM\Column(name="prod_key", type="string", length=255, nullable=true)
     */
private $prod_key;    /**
     * @var string
     *
     * @ORM\Column(name="public_key_id", type="string", length=255, nullable=true)
     */
private $public_key_id;    /**
     * @var string
     *
     * @ORM\Column(name="private_key_path", type="string", length=255, nullable=true)
     */
private $private_key_path;    /**
     * @var integer
     *
     * @ORM\Column(name="sale", type="integer")
     */
private $sale;    /**
     * @var boolean
     *
     * @ORM\Column(name="use_confirm_page", type="boolean", options={"default":false})
     */
private $use_confirm_page;    /**
     * @var boolean
     *
     * @ORM\Column(name="auto_login", type="boolean", options={"default":false})
     */
private $auto_login;    /**
     * @var boolean
     *
     * @ORM\Column(name="login_required", type="boolean", options={"default":false})
     */
private $login_required;    /**
     * @var boolean
     *
     * @ORM\Column(name="order_correct", type="boolean", options={"default":false})
     */
private $order_correct;    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_notices", type="text", nullable=true)
     */
private $mail_notices;    /**
     * @var boolean
     *
     * @ORM\Column(name="use_cart_button", type="boolean", options={"default":true})
     */
private $use_cart_button;    /**
     * @var string
     *
     * @ORM\Column(name="cart_button_color", type="string", length=255, nullable=true, options={"default":"Gold"})
     */
private $cart_button_color;    /**
     * @var string
     *
     * @ORM\Column(name="cart_button_place", type="string", length=255, nullable=true, options={"default":1})
     */
private $cart_button_place;    /**
     * @var boolean
     *
     * @ORM\Column(name="use_mypage_login_button", type="boolean", options={"default":false})
     */
private $use_mypage_login_button;    /**
     * @var string
     *
     * @ORM\Column(name="mypage_login_button_color", type="string", length=255, nullable=true, options={"default":"Gold"})
     */
private $mypage_login_button_color;    /**
     * @var string
     *
     * @ORM\Column(name="mypage_login_button_place", type="string", length=255, nullable=true, options={"default":1})
     */
private $mypage_login_button_place;    /**
     * @var boolean
     *
     * @ORM\Column(name="use_amazon_banner_on_top", type="boolean", options={"default":true})
     */
private $use_amazon_banner_on_top = true;    /**
     * @var boolean
     *
     * @ORM\Column(name="use_amazon_banner_on_cart", type="boolean", options={"default":true})
     */
private $use_amazon_banner_on_cart = true;    /**
     * @var AmazonBanner
     * 
     * @ORM\Column(name="amazon_banner_id_on_top", type="integer")
     */
private $amazon_banner_size_on_top;    /**
     * @var AmazonBanner
     * 
     * @ORM\Column(name="amazon_banner_id_on_cart", type="integer")
     */
private $amazon_banner_size_on_cart;    /**
     * Amazon特典告知バナー（トップページ）の配置方法（自動／手動）
     *
     * @var string
     * 
     * @ORM\Column(name="amazon_banner_place_on_top", type="string", length=255, nullable=true, options={"default":1})
     */
private $amazon_banner_place_on_top = 1;    /**
     * Amazon特典告知バナー（カート画面）の配置方法（自動／手動）
     *
     * @var string
     * 
     * @ORM\Column(name="amazon_banner_place_on_cart", type="string", length=255, nullable=true, options={"default":1})
     */
private $amazon_banner_place_on_cart = 1;public function __construct(){}public function getId(){return $this->id;}public function getAmazonAccountMode(){return $this->amazon_account_mode;}public function setAmazonAccountMode($amazon_account_mode = null){$this->amazon_account_mode = $amazon_account_mode;return $this;}public function getEnv(){return $this->env;}public function setEnv($env){$this->env = $env;return $this;}public function getSellerId(){return $this->seller_id;}public function setSellerId($seller_id){$this->seller_id = $seller_id;return $this;}public function getPublicKeyId(){return $this->public_key_id;}public function setPublicKeyId($public_key_id){$this->public_key_id = $public_key_id;return $this;}public function getPrivateKeyPath(){return $this->private_key_path;}public function setPrivateKeyPath($private_key_path){$this->private_key_path = $private_key_path;return $this;}public function getClientId(){return $this->client_id;}public function setClientId($client_id){$this->client_id = $client_id;return $this;}public function getTestClientId(){return $this->test_client_id;}public function setTestClientId($test_client_id){$this->test_client_id = $test_client_id;return $this;}public function getProdKey(){return $this->prod_key;}public function setProdKey($prod_key){$this->prod_key = $prod_key;return $this;}public function getSale(){return $this->sale;}public function setSale($sale){$this->sale = $sale;return $this;}public function getAutoLogin(){return $this->auto_login;}public function setAutoLogin($auto_login){$this->auto_login = $auto_login;return $this;}public function getLoginRequired(){return $this->login_required;}public function setLoginRequired($login_required){$this->login_required = $login_required;return $this;}public function getOrderCorrect(){return $this->order_correct;}public function setOrderCorrect($order_correct){$this->order_correct = $order_correct;return $this;}public function getMailNotices(){return $this->mail_notices;}public function setMailNotices($mail_notices){$this->mail_notices = $mail_notices;return $this;}public function getUseConfirmPage(){return $this->use_confirm_page;}public function setUseConfirmPage($use_confirm_page){$this->use_confirm_page = $use_confirm_page;return $this;}public function getUseCartButton(){return $this->use_cart_button;}public function setUseCartButton($use_cart_button){$this->use_cart_button = $use_cart_button;return $this;}public function getCartButtonColor(){return $this->cart_button_color;}public function setCartButtonColor($cart_button_color){$this->cart_button_color = $cart_button_color;return $this;}public function getCartButtonPlace(){return $this->cart_button_place;}public function setCartButtonPlace($cart_button_place){$this->cart_button_place = $cart_button_place;return $this;}public function getUseMypageLoginButton(){return $this->use_mypage_login_button;}public function setUseMypageLoginButton($use_mypage_login_button){$this->use_mypage_login_button = $use_mypage_login_button;return $this;}public function getMypageLoginButtonColor(){return $this->mypage_login_button_color;}public function setMypageLoginButtonColor($mypage_login_button_color){$this->mypage_login_button_color = $mypage_login_button_color;return $this;}public function getMypageLoginButtonPlace(){return $this->mypage_login_button_place;}public function setMypageLoginButtonPlace($mypage_login_button_place){$this->mypage_login_button_place = $mypage_login_button_place;return $this;}public function getUseAmazonBannerOnTop(){return isset($this->use_amazon_banner_on_top) ? $this->use_amazon_banner_on_top : true;}public function setUseAmazonBannerOnTop($use_amazon_banner_on_top){$this->use_amazon_banner_on_top = $use_amazon_banner_on_top;return $this;}public function getUseAmazonBannerOnCart(){return isset($this->use_amazon_banner_on_cart) ? $this->use_amazon_banner_on_cart : true;}public function setUseAmazonBannerOnCart($use_amazon_banner_on_cart){$this->use_amazon_banner_on_cart = $use_amazon_banner_on_cart;return $this;}public function getAmazonBannerSizeOnTop(){return $this->amazon_banner_size_on_top;}public function setAmazonBannerSizeOnTop($amazon_banner_size_on_top){$this->amazon_banner_size_on_top = $amazon_banner_size_on_top;return $this;}public function getAmazonBannerSizeOnCart(){return $this->amazon_banner_size_on_cart;}public function setAmazonBannerSizeOnCart($amazon_banner_size_on_cart){$this->amazon_banner_size_on_cart = $amazon_banner_size_on_cart;return $this;}public function getAmazonBannerPlaceOnTop(){goto SL948;SL948:if (isset($this->amazon_banner_place_on_top)) {goto VBJBT;}goto lHB04;lHB04:return 1;goto o487T;BiJvS:return $this->amazon_banner_place_on_top;goto o8w7c;o487T:VBJBT:goto BiJvS;o8w7c:}public function setAmazonBannerPlaceOnTop(string $amazon_banner_place_on_top){$this->amazon_banner_place_on_top = $amazon_banner_place_on_top;return $this;}public function getAmazonBannerPlaceOnCart(){goto zTVxB;wjl0Y:return 1;goto v2Tse;zTVxB:if (isset($this->amazon_banner_place_on_cart)) {goto hluha;}goto wjl0Y;IyVyM:return $this->amazon_banner_place_on_cart;goto H2aUz;v2Tse:hluha:goto IyVyM;H2aUz:}public function setAmazonBannerPlaceOnCart(string $amazon_banner_place_on_cart){$this->amazon_banner_place_on_cart = $amazon_banner_place_on_cart;return $this;}}