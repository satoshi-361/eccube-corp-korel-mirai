<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Controller;

use Eccube\Entity\BaseInfo;
use Eccube\Entity\ProductClass;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\ProductClassRepository;
use Eccube\Service\CartService;
use Eccube\Service\OrderHelper;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Service\PurchaseFlow\PurchaseFlowResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Repository\PageRepository;

use Detection\MobileDetect;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\CartItem;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\Master\OrderItemType;
use Eccube\Entity\Master\TaxDisplayType;
use Eccube\Entity\Master\TaxType;
use Eccube\Entity\Master\RoundingType;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\Shipping;
use Eccube\Repository\DeliveryRepository;
use Eccube\Repository\Master\DeviceTypeRepository;
use Eccube\Repository\Master\OrderItemTypeRepository;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Repository\Master\PrefRepository;
use Eccube\Repository\OrderRepository;
use Eccube\Repository\PaymentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Eccube\Repository\Master\RoundingTypeRepository;
use Eccube\Repository\Master\TaxTypeRepository;
use Eccube\Repository\Master\TaxDisplayTypeRepository;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Customize\Form\Type\Cart\CartType;
use Eccube\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Eccube\Repository\CustomerRepository;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\Master\CustomerStatusRepository;

use Plugin\EccubePaymentLite42\Service\GmoEpsilonRequestService;
use Plugin\EccubePaymentLite42\Service\GmoEpsilonUrlService;
use Customize\Service\CreditService;
use Eccube\Service\MailService;
use Eccube\Repository\DeliveryFeeRepository;
use Eccube\Entity\ItemHolderInterface;
use Eccube\Service\Payment\PaymentDispatcher;
use Eccube\Service\Payment\PaymentMethodInterface;
use Symfony\Component\HttpFoundation\Response;
use Eccube\Exception\ShoppingException;

class CartController extends AbstractController
{
    /**
     * @var string 非会員情報を保持するセッションのキー
     */
    public const SESSION_FRONT_SHOPPING_ORDER = 'eccube.front.shopping.order';

    /**
     * @var ProductClassRepository
     */
    protected $productClassRepository;

    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var PurchaseFlow
     */
    protected $purchaseFlow;

    /**
     * @var BaseInfo
     */
    protected $baseInfo;

    /**
     * @var PageRepository
     */
    private $pageRepository;
    
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var PrefRepository
     */
    protected $prefRepository;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var OrderItemTypeRepository
     */
    protected $orderItemTypeRepository;

    /**
     * @var OrderStatusRepository
     */
    protected $orderStatusRepository;

    /**
     * @var DeliveryRepository
     */
    protected $deliveryRepository;

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * @var DeviceTypeRepository
     */
    protected $deviceTypeRepository;

    /**
     * @var MobileDetector
     */
    protected $mobileDetector;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var RoundingTypeRepository
     */
    protected $roundingTypeRepository;

    /**
     * @var TaxTypeRepository
     */
    protected $taxTypeRepository;

    /**
     * @var TaxDisplayTypeRepository
     */
    protected $taxDisplayTypeRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var CustomerStatusRepository
     */
    protected $customerStatusRepository;
    
    /**
     * @var GmoEpsilonUrlService
     */
    private $gmoEpsilonUrlService;
    
    /**
     * @var CreditService
     */
    private $creditService;
    
    /**
     * @var GmoEpsilonRequestService
     */
    private $gmoEpsilonRequestService;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var DeliveryFeeRepository
     */
    protected $deliveryFeeRepository;

    /**
     * @var OrderHelper
     */
    protected $orderHelper;

    /**
     * CartController constructor.
     *
     * @param ProductClassRepository $productClassRepository
     * @param CartService $cartService
     * @param PurchaseFlow $cartPurchaseFlow
     * @param BaseInfoRepository $baseInfoRepository
     * @param PageRepository $pageRepository
     * @param EncoderFactoryInterface $encoderFactory
     * @param CustomerRepository $customerRepository
     * @param CustomerStatusRepository $customerStatusRepository
     * @param TokenStorageInterface $tokenStorage
     * @param DeliveryFeeRepository $deliveryFeeRepository
     */
    public function __construct(
        ProductClassRepository $productClassRepository,
        CartService $cartService,
        PurchaseFlow $cartPurchaseFlow,
        BaseInfoRepository $baseInfoRepository,
        PageRepository $pageRepository,
        ContainerInterface $container,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        OrderItemTypeRepository $orderItemTypeRepository,
        OrderStatusRepository $orderStatusRepository,
        DeliveryRepository $deliveryRepository,
        PaymentRepository $paymentRepository,
        DeviceTypeRepository $deviceTypeRepository,
        PrefRepository $prefRepository,
        MobileDetect $mobileDetector,
        RoundingTypeRepository $roundingTypeRepository,
        TaxTypeRepository $taxTypeRepository,
        TaxDisplayTypeRepository $taxDisplayTypeRepository,
        EncoderFactoryInterface $encoderFactory,
        CustomerRepository $customerRepository,
        CustomerStatusRepository $customerStatusRepository,
        TokenStorageInterface $tokenStorage,
        GmoEpsilonUrlService $gmoEpsilonUrlService,
        GmoEpsilonRequestService $gmoEpsilonRequestService,
        SessionInterface $session,
        CreditService $creditService,
        MailService $mailService,
        DeliveryFeeRepository $deliveryFeeRepository,
        OrderHelper $orderHelper
    ) {
        $this->productClassRepository = $productClassRepository;
        $this->cartService = $cartService;
        $this->purchaseFlow = $cartPurchaseFlow;
        $this->baseInfo = $baseInfoRepository->get();
        $this->pageRepository = $pageRepository;
        $this->container = $container;
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->orderItemTypeRepository = $orderItemTypeRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->paymentRepository = $paymentRepository;
        $this->deviceTypeRepository = $deviceTypeRepository;
        $this->entityManager = $entityManager;
        $this->prefRepository = $prefRepository;
        $this->mobileDetector = $mobileDetector;
        $this->roundingTypeRepository = $roundingTypeRepository;
        $this->taxTypeRepository = $taxTypeRepository;
        $this->taxDisplayTypeRepository = $taxDisplayTypeRepository;
        $this->encoderFactory = $encoderFactory;
        $this->customerRepository = $customerRepository;
        $this->customerStatusRepository = $customerStatusRepository;
        $this->session = $session;
        $this->gmoEpsilonUrlService = $gmoEpsilonUrlService;
        $this->gmoEpsilonRequestService = $gmoEpsilonRequestService;
        $this->creditService = $creditService;
        $this->tokenStorage = $tokenStorage;
        $this->mailService = $mailService;
        $this->deliveryFeeRepository = $deliveryFeeRepository;
        $this->orderHelper = $orderHelper;
    }

    /**
     * カート画面.
     *
     * @Route("/cart1", name="cart1", methods={"GET", "POST"})
     * @Route("/cart1", name="cart1_confirm", methods={"GET", "POST"})
     * @Template("Cart/index.twig")
     */
    public function index(Request $request)
    {
        // カートを取得して明細の正規化を実行
        $Carts = $this->cartService->getCarts();
        $this->execPurchaseFlow($Carts);

        // TODO itemHolderから取得できるように
        $least = [];
        $quantity = [];
        $isDeliveryFree = [];
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($Carts as $Cart) {
            $quantity[$Cart->getCartKey()] = 0;
            $isDeliveryFree[$Cart->getCartKey()] = false;

            if ($this->baseInfo->getDeliveryFreeQuantity()) {
                if ($this->baseInfo->getDeliveryFreeQuantity() > $Cart->getQuantity()) {
                    $quantity[$Cart->getCartKey()] = $this->baseInfo->getDeliveryFreeQuantity() - $Cart->getQuantity();
                } else {
                    $isDeliveryFree[$Cart->getCartKey()] = true;
                }
            }

            if ($this->baseInfo->getDeliveryFreeAmount()) {
                if (!$isDeliveryFree[$Cart->getCartKey()] && $this->baseInfo->getDeliveryFreeAmount() <= $Cart->getTotalPrice()) {
                    $isDeliveryFree[$Cart->getCartKey()] = true;
                } else {
                    $least[$Cart->getCartKey()] = $this->baseInfo->getDeliveryFreeAmount() - $Cart->getTotalPrice();
                }
            }

            $totalPrice += $Cart->getTotalPrice();
            $totalQuantity += $Cart->getQuantity();
        }

        // カートが分割された時のセッション情報を削除
        $request->getSession()->remove(OrderHelper::SESSION_CART_DIVIDE_FLAG);

        $builder = $this->formFactory->createBuilder(CartType::class);

        if ($this->isGranted('ROLE_USER')) {
            /** @var Customer $user */
            $user = $this->getUser();
            $builder->setData(
                [
                    'customer' => $user,
                    'shipping_address' => 0,
                ]
            );
        }

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            switch ($request->get('mode')) {
                case 'confirm':
                    return $this->render('Cart/confirm.twig', [
                        'form' => $form->createView(),
                        'Page' => $this->pageRepository->getPageByRoute('cart_confirm'),
                        'totalPrice' => $totalPrice,
                        'totalQuantity' => $totalQuantity,
                        // 空のカートを削除し取得し直す
                        'Carts' => $this->cartService->getCarts(true),
                        'least' => $least,
                        'quantity' => $quantity,
                        'is_delivery_free' => $isDeliveryFree,
                        'url_token_js' => $this->gmoEpsilonUrlService->getUrl('token'),
                        'token' => $form['credit']['token']->getData(),
                    ]);

                case 'complete':
                    $Customer = $form['customer']->getData();
                    // すでに会員登録されている場合
                    $flagShippingFree = false;

                    if ($flagShippingFree = ( !$Customer->getId() && $form['is_member']->getData() )) {
                        // 新規会員登録する
                        $encoder = $this->encoderFactory->getEncoder($Customer);
                        $salt = $encoder->createSalt();
                        $password = $encoder->encodePassword($Customer->getPlainPassword(), $salt);
                        $secretKey = $this->customerRepository->getUniqueSecretKey();
                        $CustomerStatus = $this->customerStatusRepository->find(CustomerStatus::REGULAR);
    
                        $Customer
                            ->setStatus($CustomerStatus)
                            ->setSalt($salt)
                            ->setPassword($password)
                            ->setSecretKey($secretKey)
                            ->setPoint(0);
    
                        $this->entityManager->persist($Customer);
                        $this->entityManager->flush();
    
                        // 本会員登録してログイン状態にする
                        $token = new UsernamePasswordToken($Customer, 'customer', ['ROLE_USER']);
                        $this->tokenStorage->setToken($token);
                        $request->getSession()->migrate(true);
                    } else if ( $Customer->getId() ) {
                        $flagShippingFree = true;
                    }

                    $data = $form->getData();
                    $Cart = $this->cartService->getCart();
                    $Order = $this->orderHelper->initializeOrder($Cart, $Customer);
                    $this->entityManager->flush();
                    
                    $Payment = $this->setDefaultPayment($Order);
                    $PaymentMethod = $this->container->get($Payment->getMethodClass());

                    // 集計処理.
                    log_info('[注文手続] 集計処理を開始します.', [$Order->getId()]);
                    $flowResult = $this->executePurchaseFlow($Order);
                    $this->entityManager->flush();

                    try {
                        /*
                        * 決済実行(前処理)
                        */
                        log_info('[注文処理] PaymentMethod::applyを実行します.');
                        if ($response = $this->executeApply($PaymentMethod)) {
                            return $response;
                        }

                        /*
                        * 決済実行
                        *
                        * PaymentMethod::checkoutでは決済処理が行われ, 正常に処理出来た場合はPurchaseFlow::commitがコールされます.
                        */
                        log_info('[注文処理] PaymentMethod::checkoutを実行します.');
                        if ($response = $this->executeCheckout($PaymentMethod)) {
                            return $response;
                        }

                        $this->entityManager->flush();

                        log_info('[注文処理] 注文処理が完了しました.', [$Order->getId()]);
                    } catch (ShoppingException $e) {
                        log_error('[注文処理] 購入エラーが発生しました.', [$e->getMessage()]);
        
                        $this->entityManager->rollback();
        
                        $this->addError($e->getMessage());
        
                        return $this->redirectToRoute('shopping_error');
                    } catch (\Exception $e) {
                        log_error('[注文処理] 予期しないエラーが発生しました.', [$e->getMessage()]);
        
                        // $this->entityManager->rollback(); FIXME ユニットテストで There is no active transaction エラーになってしまう
        
                        $this->addError('front.shopping.system_error');
        
                        return $this->redirectToRoute('shopping_error');
                    }

                    // カート削除
                    log_info('[注文処理] カートをクリアします.', [$Order->getId()]);
                    $this->cartService->clear();

                    // 受注IDをセッションにセット
                    $this->session->set(OrderHelper::SESSION_ORDER_ID, $Order->getId());

                    // メール送信
                    log_info('[注文処理] 注文メールの送信を行います.', [$Order->getId()]);
                    $this->mailService->sendOrderMail($Order);
                    $this->entityManager->flush();

                    log_info('[注文処理] 注文処理が完了しました. 購入完了画面へ遷移します.', [$Order->getId()]);

                    return $this->redirect($this->generateUrl('cart_complete'));



                    $Order = $this->createNewOrder( $this->cartService->getCart(), $data, $flagShippingFree );
                    $this->purchaseFlow->validate($Order, new PurchaseContext(clone $Order, $Order->getCustomer()));

                    $response = $this->creditService->apply($Order, $request->request->get('token'));

                    if ( is_object($response) && get_class($response) == \Eccube\Service\Payment\PaymentDispatcher::class ) {
                        return $response->getResponse()->send();
                    }
                    
                    $this->cartService->clear();
                    $this->mailService->sendOrderMail($Order);

                    $OrderStatus = $this->orderStatusRepository->find(OrderStatus::NEW);
                    $Order->setOrderStatus($OrderStatus);
                    $Order->setPaymentDate(new \DateTime());
                    $Order->setOrderDate(new \DateTime());

                    $this->entityManager->flush();

                    return $this->redirect($this->generateUrl('cart_complete'));
            }
        }

        return [
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            // 空のカートを削除し取得し直す
            'Carts' => $this->cartService->getCarts(true),
            'least' => $least,
            'quantity' => $quantity,
            'is_delivery_free' => $isDeliveryFree,
            'form' => $form->createView(),
            'url_token_js' => $this->gmoEpsilonUrlService->getUrl('token'),
        ];
    }

    /**
     * ショッピング完了画面.
     *
     * @Route("/cart1/complete", name="cart1_complete", methods={"GET"})
     * @Template("Cart/complete.twig")
     */
    public function complete()
    {
        $Order = $this->session->get($this::SESSION_FRONT_SHOPPING_ORDER);
        $this->session->remove($this::SESSION_FRONT_SHOPPING_ORDER);

        return [
            'Order' => $Order,
        ];
    }

    /**
     * @param $Carts
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|null
     */
    protected function execPurchaseFlow($Carts)
    {
        /** @var PurchaseFlowResult[] $flowResults */
        $flowResults = array_map(function ($Cart) {
            $purchaseContext = new PurchaseContext($Cart, $this->getUser());

            return $this->purchaseFlow->validate($Cart, $purchaseContext);
        }, $Carts);

        // 復旧不可のエラーが発生した場合はカートをクリアして再描画
        $hasError = false;
        foreach ($flowResults as $result) {
            if ($result->hasError()) {
                $hasError = true;
                foreach ($result->getErrors() as $error) {
                    $this->addRequestError($error->getMessage());
                }
            }
        }
        if ($hasError) {
            $this->cartService->clear();

            return $this->redirectToRoute('cart');
        }

        $this->cartService->save();

        foreach ($flowResults as $index => $result) {
            foreach ($result->getWarning() as $warning) {
                if ($Carts[$index]->getItems()->count() > 0) {
                    $cart_key = $Carts[$index]->getCartKey();
                    $this->addRequestError($warning->getMessage(), "front.cart.${cart_key}");
                } else {
                    // キーが存在しない場合はグローバルにエラーを表示する
                    $this->addRequestError($warning->getMessage());
                }
            }
        }

        return null;
    }

    /**
     * カート明細の加算/減算/削除を行う.
     *
     * - 加算
     *      - 明細の個数を1増やす
     * - 減算
     *      - 明細の個数を1減らす
     *      - 個数が0になる場合は、明細を削除する
     * - 削除
     *      - 明細を削除する
     *
     * @Route(
     *     path="/cart/{operation}/{productClassId}/{pageName}",
     *     name="cart_handle_item",
     *     methods={"PUT"},
     *     requirements={
     *          "operation": "up|down|remove",
     *          "productClassId": "\d+",
     *          "pageName": "cart|cart_confirm"
     *     }
     * )
     */
    public function handleCartItem($operation, $productClassId, $pageName)
    {
        log_info('カート明細操作開始', ['operation' => $operation, 'product_class_id' => $productClassId, 'path' => $pageName]);

        $this->isTokenValid();

        /** @var ProductClass $ProductClass */
        $ProductClass = $this->productClassRepository->find($productClassId);

        if (is_null($ProductClass)) {
            log_info('商品が存在しないため、カート画面へredirect', ['operation' => $operation, 'product_class_id' => $productClassId, 'path' => $pageName]);

            return $this->redirectToRoute($pageName);
        }

        // 明細の増減・削除
        switch ($operation) {
            case 'up':
                $this->cartService->addProduct($ProductClass, 1);
                break;
            case 'down':
                $this->cartService->addProduct($ProductClass, -1);
                break;
            case 'remove':
                $this->cartService->removeProduct($ProductClass);
                break;
        }

        // カートを取得して明細の正規化を実行
        $Carts = $this->cartService->getCarts();
        $this->execPurchaseFlow($Carts);

        log_info('カート演算処理終了', ['operation' => $operation, 'product_class_id' => $productClassId, 'path' => $pageName]);

        return $this->redirectToRoute($pageName);
    }

    /**
     * カートをロック状態に設定し、購入確認画面へ遷移する.
     *
     * @Route("/cart/buystep/{cart_key}", name="cart_buystep", requirements={"cart_key" = "[a-zA-Z0-9]+[_][\x20-\x7E]+"}, methods={"GET"})
     */
    public function buystep(Request $request, $cart_key)
    {
        $Carts = $this->cartService->getCart();
        if (!is_object($Carts)) {
            return $this->redirectToRoute('cart');
        }
        // FRONT_CART_BUYSTEP_INITIALIZE
        $event = new EventArgs(
            [],
            $request
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_CART_BUYSTEP_INITIALIZE);

        $this->cartService->setPrimary($cart_key);
        $this->cartService->save();

        // FRONT_CART_BUYSTEP_COMPLETE
        $event = new EventArgs(
            [],
            $request
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_CART_BUYSTEP_COMPLETE);

        if ($event->hasResponse()) {
            return $event->getResponse();
        }

        return $this->redirectToRoute('shopping');
    }

    protected function createNewOrder( $Cart, $data, $flagShippingFree = true ) {
        $Customer = $data['customer'];
        $shippingCustomer = $data['shipping'];

        $OrderStatus = $this->orderStatusRepository->find(OrderStatus::NEW);
        $Order = new Order($OrderStatus);

        // 顧客情報の設定
        $this->setCustomer($Order, $Customer);

        $DeviceType = $this->deviceTypeRepository->find($this->mobileDetector->isMobile() ? DeviceType::DEVICE_TYPE_MB : DeviceType::DEVICE_TYPE_PC);
        $Order->setDeviceType($DeviceType);

        // 明細情報の設定
        $OrderItems = $this->createOrderItemsFromCartItems($Cart->getCartItems());
        $OrderItemsGroupBySaleType = array_reduce($OrderItems, function ($result, $item) {
            /* @var OrderItem $item */
            $saleTypeId = $item->getProductClass()->getSaleType()->getId();
            $result[$saleTypeId][] = $item;

            return $result;
        }, []);

        foreach ($OrderItemsGroupBySaleType as $OrderItems) {
            $Shipping = $this->createShippingFromCustomer($shippingCustomer);
            $Shipping->setOrder($Order);
            $this->addOrderItems($Order, $Shipping, $OrderItems);
            $this->setDefaultDelivery($Shipping);
            $this->entityManager->persist($Shipping);
            $Order->addShipping($Shipping);
        }

        $this->addDeliveryOrderItem($Order, $Shipping, $flagShippingFree = true);
        $this->setDefaultPayment($Order);
        $this->purchaseFlow->validate($Order, new PurchaseContext(clone $Order, $Order->getCustomer()));

        $this->entityManager->persist($Order);
        $this->entityManager->flush();
        
        $this->session->set($this::SESSION_FRONT_SHOPPING_ORDER, $Order);
        return $Order;
    }
    
    protected function setCustomer(Order $Order, Customer $Customer)
    {
        if ($Customer->getId()) {
            $Order->setCustomer($Customer);
        }

        $Order->copyProperties(
            $Customer,
            [
                'id',
                'create_date',
                'update_date',
                'del_flg',
            ]
        );
    }

    /**
     * @param Collection|ArrayCollection|CartItem[] $CartItems
     *
     * @return OrderItem[]
     */
    protected function createOrderItemsFromCartItems($CartItems)
    {
        $ProductItemType = $this->orderItemTypeRepository->find(OrderItemType::PRODUCT);
        $RoundingType = $this->roundingTypeRepository->find(RoundingType::ROUND);
        $TaxType = $this->taxTypeRepository->find(TaxType::TAXATION);
        $TaxDisplay = $this->taxDisplayTypeRepository->find(TaxDisplayType::INCLUDED);

        return array_map(function ($item) use ($ProductItemType, $RoundingType, $TaxType, $TaxDisplay) {
            /* @var $item CartItem */
            /* @var $ProductClass \Eccube\Entity\ProductClass */
            $ProductClass = $item->getProductClass();
            /* @var $Product \Eccube\Entity\Product */
            $Product = $ProductClass->getProduct();

            $OrderItem = new OrderItem();
            $OrderItem
                ->setProduct($Product)
                ->setProductClass($ProductClass)
                ->setProductName($Product->getName())
                ->setProductCode($ProductClass->getCode())
                ->setPrice($ProductClass->getPrice02())
                ->setQuantity($item->getQuantity())
                ->setOrderItemType($ProductItemType)
                ->setProperty($item->getProperty())
                ->setRoundingType($RoundingType)
                ->setTaxType($TaxType)
                ->setTaxDisplayType($TaxDisplay);

            $ClassCategory1 = $ProductClass->getClassCategory1();
            if (!is_null($ClassCategory1)) {
                $OrderItem->setClasscategoryName1($ClassCategory1->getName());
                $OrderItem->setClassName1($ClassCategory1->getClassName()->getName());
            }
            $ClassCategory2 = $ProductClass->getClassCategory2();
            if (!is_null($ClassCategory2)) {
                $OrderItem->setClasscategoryName2($ClassCategory2->getName());
                $OrderItem->setClassName2($ClassCategory2->getClassName()->getName());
            }

            return $OrderItem;
        }, $CartItems instanceof Collection ? $CartItems->toArray() : $CartItems);
    }

    /**
     * @param Customer $Customer
     *
     * @return Shipping
     */
    protected function createShippingFromCustomer($array)
    {
        $Shipping = new Shipping();
        $Shipping
            ->setName01($array['name01'])
            ->setName02($array['name02'])
            ->setKana01($array['kana01'])
            ->setKana02($array['kana02'])
            ->setPhoneNumber($array['phone_number'])
            ->setPostalCode($array['postal_code'])
            ->setPref($array['pref'])
            ->setAddr01($array['addr01'])
            ->setAddr02($array['addr02']);

        return $Shipping;
    }

    /**
     * @param Shipping $Shipping
     */
    protected function setDefaultDelivery(Shipping $Shipping)
    {
        // 配送商品に含まれる販売種別を抽出.
        $OrderItems = $Shipping->getOrderItems();
        $SaleTypes = [];
        /** @var OrderItem $OrderItem */
        foreach ($OrderItems as $OrderItem) {
            $ProductClass = $OrderItem->getProductClass();
            $SaleType = $ProductClass->getSaleType();
            $SaleTypes[$SaleType->getId()] = $SaleType;
        }

        // 販売種別に紐づく配送業者を取得.
        $Deliveries = $this->deliveryRepository->getDeliveries($SaleTypes);

        // 初期の配送業者を設定
        $Delivery = current($Deliveries);
        $Shipping->setDelivery($Delivery);
        $Shipping->setShippingDeliveryName($Delivery->getName());
    }

    /**
     * @param Order $Order
     */
    protected function setDefaultPayment(Order $Order)
    {
        $OrderItems = $Order->getOrderItems();

        // 受注明細に含まれる販売種別を抽出.
        $SaleTypes = [];
        /** @var OrderItem $OrderItem */
        foreach ($OrderItems as $OrderItem) {
            $ProductClass = $OrderItem->getProductClass();
            if (is_null($ProductClass)) {
                // 商品明細のみ対象とする. 送料明細等はスキップする.
                continue;
            }
            $SaleType = $ProductClass->getSaleType();
            $SaleTypes[$SaleType->getId()] = $SaleType;
        }

        // 販売種別に紐づく配送業者を抽出
        $Deliveries = $this->deliveryRepository->getDeliveries($SaleTypes);

        // 利用可能な支払い方法を抽出.
        // ここでは支払総額が決まっていないため、利用条件に合致しないものも選択対象になる場合がある
        $Payments = $this->paymentRepository->findAllowedPayments($Deliveries, true);

        // 初期の支払い方法を設定.
        $Payment = current($Payments);
        if ($Payment) {
            $Order->setPayment($Payment);
            $Order->setPaymentMethod($Payment->getMethod());

            return $Payment;
        }
    }

    /**
     * @param Order $Order
     * @param Shipping $Shipping
     * @param array $OrderItems
     */
    protected function addOrderItems(Order $Order, Shipping $Shipping, array $OrderItems)
    {
        foreach ($OrderItems as $OrderItem) {
            $Shipping->addOrderItem($OrderItem);
            $Order->addOrderItem($OrderItem);
            $OrderItem->setOrder($Order);
            $OrderItem->setShipping($Shipping);
        }
    }

    /**
     * @param Order $Order
     * @param Shipping $Shipping
     * @param array $OrderItems
     */
    protected function addDeliveryOrderItem(Order $Order, Shipping $Shipping, $flagShippingFree = true)
    {
        $DeliveryFeeType = $this->entityManager
            ->find(OrderItemType::class, OrderItemType::DELIVERY_FEE);
        $TaxInclude = $this->entityManager
            ->find(TaxDisplayType::class, TaxDisplayType::INCLUDED);
        $Taxation = $this->entityManager
            ->find(TaxType::class, TaxType::TAXATION);
        $RoundingType = $this->roundingTypeRepository->find(RoundingType::ROUND);

        /** @var DeliveryFee|null $DeliveryFee */
        $DeliveryFee = $this->deliveryFeeRepository->findOneBy([
            'Delivery' => $Shipping->getDelivery(),
            'Pref' => $Shipping->getPref(),
        ]);
        $fee = is_object($DeliveryFee) & !$flagShippingFree ? $DeliveryFee->getFee() : 0;

        $OrderItem = new OrderItem();
        $OrderItem->setProductName($DeliveryFeeType->getName())
            ->setPrice($fee)
            ->setQuantity(1)
            ->setOrderItemType($DeliveryFeeType)
            ->setShipping($Shipping)
            ->setOrder($Order)
            ->setRoundingType($RoundingType)
            ->setTaxDisplayType($TaxInclude)
            ->setTaxType($Taxation)
            ->setProcessorName(DeliveryFeePreprocessor::class);

        $Order->addItem($OrderItem);
        $Shipping->addOrderItem($OrderItem);
    }

    /**
     * @param ItemHolderInterface $itemHolder
     * @param bool $returnResponse レスポンスを返すかどうか. falseの場合はPurchaseFlowResultを返す.
     *
     * @return PurchaseFlowResult|RedirectResponse|null
     */
    protected function executePurchaseFlow(ItemHolderInterface $itemHolder, $returnResponse = true)
    {
        /** @var PurchaseFlowResult $flowResult */
        $flowResult = $this->purchaseFlow->validate($itemHolder, new PurchaseContext(clone $itemHolder, $itemHolder->getCustomer()));
        foreach ($flowResult->getWarning() as $warning) {
            $this->addWarning($warning->getMessage());
        }
        foreach ($flowResult->getErrors() as $error) {
            $this->addError($error->getMessage());
        }

        if (!$returnResponse) {
            return $flowResult;
        }

        if ($flowResult->hasError()) {
            log_info('Errorが発生したため購入エラー画面へ遷移します.', [$flowResult->getErrors()]);

            return $this->redirectToRoute('shopping_error');
        }

        if ($flowResult->hasWarning()) {
            log_info('Warningが発生したため注文手続き画面へ遷移します.', [$flowResult->getWarning()]);

            return $this->redirectToRoute('shopping');
        }

        return null;
    }

    /**
     * PaymentMethod::applyを実行する.
     *
     * @param PaymentMethodInterface $paymentMethod
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function executeApply(PaymentMethodInterface $paymentMethod)
    {
        $dispatcher = $paymentMethod->apply(); // 決済処理中.

        // リンク式決済のように他のサイトへ遷移する場合などは, dispatcherに処理を移譲する.
        if ($dispatcher instanceof PaymentDispatcher) {
            $response = $dispatcher->getResponse();
            $this->entityManager->flush();

            // dispatcherがresponseを保持している場合はresponseを返す
            if ($response instanceof Response && ($response->isRedirection() || $response->isSuccessful())) {
                log_info('[注文処理] PaymentMethod::applyが指定したレスポンスを表示します.');

                return $response;
            }

            // forwardすることも可能.
            if ($dispatcher->isForward()) {
                log_info('[注文処理] PaymentMethod::applyによりForwardします.',
                    [$dispatcher->getRoute(), $dispatcher->getPathParameters(), $dispatcher->getQueryParameters()]);

                return $this->forwardToRoute($dispatcher->getRoute(), $dispatcher->getPathParameters(),
                    $dispatcher->getQueryParameters());
            } else {
                log_info('[注文処理] PaymentMethod::applyによりリダイレクトします.',
                    [$dispatcher->getRoute(), $dispatcher->getPathParameters(), $dispatcher->getQueryParameters()]);

                return $this->redirectToRoute($dispatcher->getRoute(),
                    array_merge($dispatcher->getPathParameters(), $dispatcher->getQueryParameters()));
            }
        }
    }

    /**
     * PaymentMethod::checkoutを実行する.
     *
     * @param PaymentMethodInterface $paymentMethod
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     */
    protected function executeCheckout(PaymentMethodInterface $paymentMethod)
    {
        $PaymentResult = $paymentMethod->checkout();
        $response = $PaymentResult->getResponse();
        // PaymentResultがresponseを保持している場合はresponseを返す
        if ($response instanceof Response && ($response->isRedirection() || $response->isSuccessful())) {
            $this->entityManager->flush();
            log_info('[注文処理] PaymentMethod::checkoutが指定したレスポンスを表示します.');

            return $response;
        }

        // エラー時はロールバックして購入エラーとする.
        if (!$PaymentResult->isSuccess()) {
            $this->entityManager->rollback();
            foreach ($PaymentResult->getErrors() as $error) {
                $this->addError($error);
            }

            log_info('[注文処理] PaymentMethod::checkoutのエラーのため, 購入エラー画面へ遷移します.', [$PaymentResult->getErrors()]);

            return $this->redirectToRoute('shopping_error');
        }

        return null;
    }
}
