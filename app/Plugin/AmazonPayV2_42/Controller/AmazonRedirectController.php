<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.3   |
    |              on 2022-12-15 15:50:07              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
namespace Plugin\AmazonPayV2_42\Controller;use Eccube\Controller\AbstractController;use Eccube\Repository\CustomerRepository;use Eccube\Repository\ClassCategoryRepository;use Eccube\Repository\ProductRepository;use Eccube\Repository\ProductClassRepository;use Eccube\Common\EccubeConfig;use Eccube\Service\CartService;use Eccube\Service\OrderHelper;use Eccube\Service\PurchaseFlow\PurchaseContext;use Eccube\Service\PurchaseFlow\PurchaseFlow;use Plugin\AmazonPayV2_42\Repository\ConfigRepository;use Plugin\AmazonPayV2_42\Service\AmazonOrderHelper;use Plugin\AmazonPayV2_42\Service\AmazonRequestService;use Plugin\AmazonPayV2_42\Service\AmazonIPNService;use Symfony\Component\Routing\Annotation\Route;use Symfony\Component\HttpFoundation\ParameterBag;use Symfony\Component\HttpFoundation\Request;use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;class AmazonRedirectController extends AbstractController{private $sessionAmazonProfileKey = 'amazon_pay_v2.profile';private $sessionAmazonCheckoutSessionIdKey = 'amazon_pay_v2.checkout_session_id';private $sessionIsShippingRefresh = 'amazon_pay_v2.is_shipping_refresh';private $sessionAmazonLoginStateKey = 'amazon_pay_v2.amazon_login_state';protected $cartService;protected $configRepository;protected $amazonRequestService;protected $amazonIPNService;public function __construct(PurchaseFlow $cartPurchaseFlow, OrderHelper $orderHelper, CartService $cartService, CustomerRepository $customerRepository, ClassCategoryRepository $classCategoryRepository, ProductRepository $productRepository, ProductClassRepository $productClassRepository, ConfigRepository $configRepository, AmazonOrderHelper $amazonOrderHelper, AmazonRequestService $amazonRequestService, AmazonIPNService $amazonIPNService, ParameterBag $parameterBag, EccubeConfig $eccubeConfig, TokenStorageInterface $tokenStorage){goto TVu29;TVu29:$this->purchaseFlow = $cartPurchaseFlow;goto izVqK;pQoiu:$this->cartService = $cartService;goto YuYfc;fNeCs:$this->amazonOrderHelper = $amazonOrderHelper;goto eyr5P;MRLXh:$this->classCategoryRepository = $classCategoryRepository;goto tftwP;q25Mc:$this->amazonIPNService = $amazonIPNService;goto kGgHu;UKdST:$this->Config = $configRepository->get();goto QPlaf;xJqJN:$this->eccubeConfig = $eccubeConfig;goto jFVdd;GZBTT:$this->productClassRepository = $productClassRepository;goto h3jFX;YuYfc:$this->customerRepository = $customerRepository;goto MRLXh;izVqK:$this->orderHelper = $orderHelper;goto pQoiu;jFVdd:$this->tokenStorage = $tokenStorage;goto UKdST;kGgHu:$this->parameterBag = $parameterBag;goto xJqJN;h3jFX:$this->configRepository = $configRepository;goto fNeCs;tftwP:$this->productRepository = $productRepository;goto GZBTT;eyr5P:$this->amazonRequestService = $amazonRequestService;goto q25Mc;QPlaf:}    /**
     * @Route("/amazon_checkout_review", name="amazon_checkout_review")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
public function amazonCheckoutReview(Request $request){goto l2538;dnjha:if (!$revise_flg) {goto ySNqo;}goto TggDA;G2y4z:$kana02 = $Customer->getKana02();goto EdVeI;nmdBY:logs('amazon_pay_v2')->info('AmazonRedirect::index end.');goto Mp2Ff;DEvqo:if (empty($arrFixName)) {goto JtqUO;}goto uiQp1;Mp2Ff:return $this->redirectToRoute('amazon_pay_shopping', []);goto Bgxpx;CjydY:$cartKey = $request->get('cart');goto wF9pn;ZlRIU:foreach ($this->cartService->getCarts() as $Cart) {$this->purchaseFlow->validate($Cart, new PurchaseContext($Cart, $Customer[0]));ySSJ8:}goto lfs_u;NAtZi:DM1w7:goto dnjha;YojbU:$this->session->set($this->sessionAmazonProfileKey, serialize($buyer));goto wEXkN;QJxzS:$revise_flg = true;goto hQb3B;ead1X:B1f1H:goto YojbU;l2538:logs('amazon_pay_v2')->info('AmazonRedirect::amazonCheckoutReview start.');goto j3Qbh;wF9pn:$this->cartService->setPrimary($cartKey);goto HNJ16;dBNkD:$this->cartService->mergeFromPersistedCart();goto ZlRIU;lTRYv:$this->tokenStorage->setToken($token);goto CAqD1;CAqD1:$request->getSession()->migrate(true);goto dBNkD;pJYOR:$this->cartService->save();goto DJkNJ;jMdNH:ySNqo:goto ead1X;R1ojq:WZjL6:goto NAtZi;jUF2T:$revise_flg = false;goto EChr0;wEXkN:$this->session->set($this->sessionAmazonCheckoutSessionIdKey, $request->get('amazonCheckoutSessionId'));goto wCkWT;wCkWT:$this->session->set($this->sessionIsShippingRefresh, true);goto nmdBY;hQb3B:logs('amazon_pay_v2')->info('*** 会員情報 フリガナ補正 *** customer_id = ' . $Customer->getId());goto R1ojq;TggDA:$this->entityManager->persist($Customer);goto zlU6w;EdVeI:if (!((empty($kana01) || $kana01 === '　') && (empty($kana02) || $kana02 === '　'))) {goto DM1w7;}goto qlrjl;t_Jpp:if (!($this->isGranted('IS_AUTHENTICATED_FULLY') && $this->Config->getOrderCorrect() == $this->eccubeConfig['amazon_pay_v2']['toggle']['on'])) {goto B1f1H;}goto gNoIV;NIyJg:JtqUO:goto jwYj1;qlrjl:$arrFixKana = $this->amazonOrderHelper->reviseKana($Customer->getName01(), $Customer->getName02(), $Customer->getEmail());goto HDEu_;uiQp1:$Customer->setName01($arrFixName['name01'])->setName02($arrFixName['name02']);goto l3BOn;HDEu_:if (empty($arrFixKana)) {goto WZjL6;}goto X2tL4;AvlTO:$kana01 = $Customer->getKana01();goto G2y4z;lfs_u:iVuVb:goto pJYOR;Us3iA:if (!(!$this->isGranted('ROLE_USER') && $this->Config->getAutoLogin() == $this->eccubeConfig['amazon_pay_v2']['toggle']['on'] && ($Customer = $this->customerRepository->getNonWithdrawingCustomers(['v2_amazon_user_id' => $buyer->buyerId])))) {goto lxnzG;}goto N0HOU;zlU6w:$this->entityManager->flush();goto jMdNH;QyXlR:if (!(empty($name02) || $name02 == '　')) {goto UlULe;}goto WNW6Y;oZDXf:logs('amazon_pay_v2')->info('*** 会員情報 名前補正 *** customer_id = ' . $Customer->getId());goto NIyJg;DJkNJ:lxnzG:goto t_Jpp;EChr0:$name02 = $Customer->getName02();goto QyXlR;HNJ16:$this->cartService->save();goto Us3iA;j3Qbh:try {$checkoutSession = $this->amazonRequestService->getCheckoutSession($request->get('amazonCheckoutSessionId'));$buyer = $checkoutSession->buyer;} catch (\Exception $e) {return $this->redirectToRoute('shopping_error');}goto CjydY;X2tL4:$Customer->setKana01($arrFixKana['kana01'])->setKana02($arrFixKana['kana02']);goto QJxzS;N0HOU:$token = new UsernamePasswordToken($Customer[0], null, 'customer', ['ROLE_USER']);goto lTRYv;gNoIV:$Customer = $this->getUser();goto jUF2T;l3BOn:$revise_flg = true;goto oZDXf;WNW6Y:$arrFixName = $this->amazonOrderHelper->reviseName($Customer->getName01());goto DEvqo;jwYj1:UlULe:goto AvlTO;Bgxpx:}    /**
     * @Route("/amazon_instant_payment_notifications", name="instant_payment_notifications")
     */
public function instantPaymentNotifications(Request $request){goto rb6Lk;AH5hO:if (isset($content['Type']) && $content['Type'] == 'Notification') {goto zFwpu;}goto oPTMn;wXMez:logs('amazon_pay_v2')->info('AmazonRedirect::instantPaymentNotifications end.');goto FCEzl;m7pkS:$content = json_decode($json, true);goto AH5hO;FCEzl:return new Response();goto jChpz;DHldL:zFwpu:goto PVqmL;oPTMn:throw new \Exception('IPN Type Error.');goto bR8As;ulOa3:$this->amazonIPNService->mainProcess($arrParam);goto G_BjP;RsUtP:$json = $request->getContent();goto m7pkS;G_BjP:FHia1:goto wXMez;rb6Lk:logs('amazon_pay_v2')->info('AmazonRedirect::instantPaymentNotifications start.');goto RsUtP;bR8As:goto FHia1;goto DHldL;PVqmL:$arrParam = json_decode($content['Message'], true);goto ulOa3;jChpz:}    /**
     * @Route("/mypage/login_with_amazon", name="login_with_amazon")
     */
public function loginWithAmazon(Request $request){goto dcUsj;U_Z0w:$route = 'homepage';goto uyZIk;c3t16:logs('amazon_pay_v2')->info('AmazonRedirect::loginWithAmazon end.');goto VGKHa;dcUsj:logs('amazon_pay_v2')->info('AmazonRedirect::loginWithAmazon start.');goto U_Z0w;OTrLr:throw new AccessDeniedHttpException('不正なアクセスです。');goto EHzLu;uyZIk:$buyerToken = $request->get('buyerToken');goto ipuE6;VGKHa:return $this->redirectToRoute($route);goto ZIGrL;EHzLu:lzuGR:goto JXNcm;JXNcm:if (!($state !== $sessionState)) {goto z3kCW;}goto gDX0s;gDX0s:$this->addError('amazon_pay_v2.front.error', 'amazon_pay_v2');goto e9raR;ipuE6:$state = $request->get('state');goto aS2WL;sQ7b8:$this->session->remove($this->sessionAmazonLoginStateKey);goto bdpee;jg0Rp:z3kCW:goto sQ7b8;AFXfb:return $this->redirectToRoute($route);goto jg0Rp;aS2WL:$sessionState = $this->session->get($this->sessionAmazonLoginStateKey);goto KVOdp;KVOdp:if (!(!isset($buyerToken) || !isset($state))) {goto lzuGR;}goto OTrLr;bdpee:try {goto InNFo;u6ucx:$route = 'mypage_login';goto xnqEF;lo2s2:$isLogin = $this->amazonRequestService->loginWithBuyerId($request, $buyerId);goto nFgme;cGdTg:$this->addError('amazon_pay_v2.front_mypage_fail_to_login', 'amazon_pay_v2');goto u6ucx;xnqEF:a8BGA:goto XV0pY;XV0pY:nW5ZB:goto tDBa8;JalGU:$buyerId = $buyer->buyerId;goto lo2s2;InNFo:if ($this->isGranted('ROLE_USER')) {goto nW5ZB;}goto Bzp1z;Bzp1z:$buyer = $this->amazonRequestService->getBuyer($request->get('buyerToken'));goto JalGU;nFgme:if ($isLogin) {goto a8BGA;}goto cGdTg;tDBa8:} catch (\Exception $e) {goto U3R6W;wioId:$this->addError('amazon_pay_v2.front.error', 'amazon_pay_v2');goto uokiN;uokiN:$route = 'mypage_login';goto PW9Dt;U3R6W:logs('amazon_pay_v2')->info($e->getMessage());goto wioId;PW9Dt:}goto c3t16;e9raR:$route = 'mypage_login';goto AFXfb;ZIGrL:}}