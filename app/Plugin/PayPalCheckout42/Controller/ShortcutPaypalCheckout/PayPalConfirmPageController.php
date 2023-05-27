<?php

namespace Plugin\PayPalCheckout42\Controller\ShortcutPaypalCheckout;

use Eccube\Controller\AbstractShoppingController;
use Eccube\Form\Type\Shopping\OrderType;
use Eccube\Repository\TradeLawRepository;
use Eccube\Service\CartService;
use Eccube\Service\OrderHelper;
use Plugin\PayPalCheckout42\Service\Method\Acdc;
use Plugin\PayPalCheckout42\Service\Method\BankTransfer;;
use Plugin\PayPalCheckout42\Service\Method\CreditCard;
use Plugin\PayPalCheckout42\Service\Method\InlineGuest;
use Plugin\PayPalCheckout42\Service\PayPalService;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SmartShortcutConfirmPageController
 * @package Plugin\PayPalCheckout42\Controller
 */
class PayPalConfirmPageController extends AbstractShoppingController
{
    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var OrderHelper
     */
    protected $orderHelper;

    /**
     * @var PayPalService
     */
    protected $paypal;

    /**
     * @var TradeLawRepository
     */
    protected TradeLawRepository $tradeLawRepository;

    /**
     * @var ContainerInterface
     */
    protected $locator;

    /**
     * SmartShortcutConfirmPageController constructor.
     * @param CartService $cartService
     * @param OrderHelper $orderHelper
     * @param PayPalService $paypal
     * @param TradeLawRepository $tradeLawRepository
     * @param ContainerInterface $locator
     */
    public function __construct(
        CartService $cartService,
        OrderHelper $orderHelper,
        PayPalService $paypal,
        TradeLawRepository $tradeLawRepository,
        ContainerInterface $locator)
    {
        $this->paypal = $paypal;
        $this->cartService = $cartService;
        $this->orderHelper = $orderHelper;
        $this->tradeLawRepository = $tradeLawRepository;
        $this->locator = $locator;
    }

    /**
     * 動的にDIするにはサービスロケーターにクラスを追加する必要がある
     *
     * @return array|string[]
     */
    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            Acdc::class,
            BankTransfer::class,
            CreditCard::class,
            InlineGuest::class,
            // Subscription::class,
        ]);
    }

    /**
     * 注文確認画面を表示する.
     *
     * ここではPaymentMethod::verifyがコールされます.
     * PaymentMethod::verifyではクレジットカードの有効性チェック等, 注文手続きを進められるかどうかのチェック処理を行う事を想定しています.
     * PaymentMethod::verifyでエラーが発生した場合は, 注文手続き画面へリダイレクトします.
     *
     * @Route("/paypal_confirm", name="paypal_confirm", methods={"GET"})
     * @Template("Shopping/confirm.twig")
     */
    public function confirm(Request $request)
    {
        // ログイン状態のチェック.
        if ($this->orderHelper->isLoginRequired()) {
            log_info('[注文確認] 未ログインもしくはRememberMeログインのため, ログイン画面に遷移します.');

            return $this->redirectToRoute('shopping_login');
        }

        // 受注の存在チェック
        $preOrderId = $this->cartService->getPreOrderId();
        $Order = $this->orderHelper->getPurchaseProcessingOrder($preOrderId);
        if (!$Order) {
            log_info('[注文確認] 購入処理中の受注が存在しません.', [$preOrderId]);

            return $this->redirectToRoute('shopping_error');
        }

        $activeTradeLaws = $this->tradeLawRepository->findBy(['displayOrderScreen' => true], ['sortNo' => 'ASC']);
        $form = $this->createForm(OrderType::class, $Order);
        $form->handleRequest($request);

        log_info('[注文確認] 集計処理を開始します.', [$Order->getId()]);
        $response = $this->executePurchaseFlow($Order);
        $this->entityManager->flush();

        if ($response) {
            return $response;
        }

        log_info('[注文確認] PaymentMethod::verifyを実行します.', [$Order->getPayment()->getMethodClass()]);

        $paymentMethod = $this->locator->get($Order->getPayment()->getMethodClass());
        $paymentMethod->setOrder($Order);
        $paymentMethod->setFormType($form);
        $PaymentResult = $paymentMethod->verify();

        if ($PaymentResult) {
            if (!$PaymentResult->isSuccess()) {
                $this->entityManager->rollback();
                foreach ($PaymentResult->getErrors() as $error) {
                    $this->addError($error);
                }

                log_info('[注文確認] PaymentMethod::verifyのエラーのため, 注文手続き画面へ遷移します.', [$PaymentResult->getErrors()]);

                return $this->redirectToRoute('shopping');
            }

            $response = $PaymentResult->getResponse();
            if ($response && ($response->isRedirection() || $response->getContent())) {
                $this->entityManager->flush();

                log_info('[注文確認] PaymentMethod::verifyが指定したレスポンスを表示します.');

                return $response;
            }
        }

        $this->entityManager->flush();

        log_info('[注文確認] 注文確認画面を表示します.');

        return [
            'form' => $form->createView(),
            'Order' => $Order,
            'activeTradeLaws' => $activeTradeLaws,
        ];
    }
}
