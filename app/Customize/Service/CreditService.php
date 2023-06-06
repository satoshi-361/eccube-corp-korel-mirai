<?php

namespace Customize\Service;

use Eccube\Common\EccubeConfig;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Order;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Service\Payment\PaymentDispatcher;
use Eccube\Service\Payment\PaymentMethodInterface;
use Eccube\Service\Payment\PaymentResult;
use Eccube\Service\PointHelper;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Plugin\EccubePaymentLite42\Entity\Config;
use Plugin\EccubePaymentLite42\Repository\ConfigRepository;
use Plugin\EccubePaymentLite42\Service\AccessBlockProcessService;
use Plugin\EccubePaymentLite42\Service\ChangeRegularStatusToRePaymentService;
use Plugin\EccubePaymentLite42\Service\CreateSystemErrorResponseService;
use Plugin\EccubePaymentLite42\Service\CreditCardPaymentWithTokenService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonRequest\RequestReceiveOrder3Service;
use Plugin\EccubePaymentLite42\Service\IpBlackListService;
use Plugin\EccubePaymentLite42\Service\SaveGmoEpsilonCreditCardExpirationService;
use Plugin\EccubePaymentLite42\Service\UpdateGmoEpsilonOrderService;
use Plugin\EccubePaymentLite42\Service\UpdateNextShippingDateFromRePaymentService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CreditService
{
    /**
     * @var SaveGmoEpsilonCreditCardExpirationService
     */
    private $saveGmoEpsilonCreditCardExpirationService;
    /**
     * @var IpBlackListService
     */
    private $ipBlackListService;
    /**
     * @var CreditCardPaymentWithTokenService
     */
    private $creditCardPaymentWithTokenService;
    /**
     * @var AccessBlockProcessService
     */
    private $accessBlockProcessService;
    /**
     * @var Order
     */
    protected $Order;
    /**
     * @var FormInterface
     */
    protected $form;
    /**
     * @var ConfigRepository
     */
    private $configRepository;
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;
    /**
     * @var RequestReceiveOrder3Service
     */
    private $requestReceiveOrder3Service;
    /**
     * @var CreateSystemErrorResponseService
     */
    private $createSystemErrorResponseService;
    /**
     * @var OrderStatusRepository
     */
    private $orderStatusRepository;
    /**
     * @var PurchaseFlow
     */
    private $purchaseFlow;
    /**
     * @var UpdateGmoEpsilonOrderService
     */
    private $updateGmoEpsilonOrderService;
    /**
     * @var ChangeRegularStatusToRePaymentService
     */
    private $changeRegularStatusToRePaymentService;
    /**
     * @var UpdateNextShippingDateFromRePaymentService
     */
    private $updateNextShippingDateFromRePaymentService;
    /**
     * @var PointHelper
     */
    protected $pointHelper;

    public function __construct(
        EccubeConfig $eccubeConfig,
        SaveGmoEpsilonCreditCardExpirationService $saveGmoEpsilonCreditCardExpirationService,
        IpBlackListService $ipBlackListService,
        CreditCardPaymentWithTokenService $creditCardPaymentWithTokenService,
        AccessBlockProcessService $accessBlockProcessService,
        ConfigRepository $configRepository,
        RequestReceiveOrder3Service $requestReceiveOrder3Service,
        CreateSystemErrorResponseService $createSystemErrorResponseService,
        OrderStatusRepository $orderStatusRepository,
        PurchaseFlow $shoppingPurchaseFlow,
        UpdateGmoEpsilonOrderService $updateGmoEpsilonOrderService,
        ChangeRegularStatusToRePaymentService $changeRegularStatusToRePaymentService,
        UpdateNextShippingDateFromRePaymentService $updateNextShippingDateFromRePaymentService,
        PointHelper $pointHelper
    ) {
        $this->eccubeConfig = $eccubeConfig;
        $this->saveGmoEpsilonCreditCardExpirationService = $saveGmoEpsilonCreditCardExpirationService;
        $this->ipBlackListService = $ipBlackListService;
        $this->creditCardPaymentWithTokenService = $creditCardPaymentWithTokenService;
        $this->accessBlockProcessService = $accessBlockProcessService;
        $this->configRepository = $configRepository;
        $this->requestReceiveOrder3Service = $requestReceiveOrder3Service;
        $this->createSystemErrorResponseService = $createSystemErrorResponseService;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->purchaseFlow = $shoppingPurchaseFlow;
        $this->updateGmoEpsilonOrderService = $updateGmoEpsilonOrderService;
        $this->changeRegularStatusToRePaymentService = $changeRegularStatusToRePaymentService;
        $this->updateNextShippingDateFromRePaymentService = $updateNextShippingDateFromRePaymentService;
        $this->pointHelper = $pointHelper;
    }

    /**
     * チェックするレスポンスパラメータのキーを取得
     */
    public function getCheckParameter(): array
    {
        return [
            'trans_code',
            'user_id',
            'result',
            'order_number',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function apply($Order, $token)
    {
        logs('gmo_epsilon')->info('受注ID: '.$Order->getId().'Credit payment process start.');
        $dispatcher = $this->accessBlockProcessService->check();
        // レスポンスがセットされている場合は処理を終了
        if ($dispatcher->getResponse()) {
            return $dispatcher;
        }
        $dispatcher = $this->ipBlackListService->handle();
        // レスポンスがセットされている場合は処理を終了し購入エラー画面を表示
        if ($dispatcher->getResponse()) {
            return $dispatcher;
        }
        /** @var Config $Config */
        $Config = $this->configRepository->find(1);
        // if customer use point =>  rollback point of customer
        if ($Order->getUsePoint() > 0) {
            // 利用したポイントをユーザに戻す.
            $this->pointHelper->rollback($Order, $Order->getUsePoint());
        }

        return $this->creditCardPaymentWithTokenService->handle(
            $token,
            $this->eccubeConfig['gmo_epsilon']['st_code']['credit'],
            $dispatcher,
            $Order
        );
    }
}
