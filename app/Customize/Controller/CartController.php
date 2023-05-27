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
use Eccube\Entity\Cart;
use Eccube\Entity\CartItem;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\Master\OrderItemType;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\Shipping;
use Eccube\EventListener\SecurityListener;
use Eccube\Repository\DeliveryRepository;
use Eccube\Repository\Master\DeviceTypeRepository;
use Eccube\Repository\Master\OrderItemTypeRepository;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Repository\Master\PrefRepository;
use Eccube\Repository\OrderRepository;
use Eccube\Repository\PaymentRepository;
use Eccube\Util\StringUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Eccube\Repository\Master\RoundingTypeRepository;
use Eccube\Repository\Master\TaxTypeRepository;
use Eccube\Repository\Master\TaxDisplayTypeRepository;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Customize\Form\Type\Cart\CartType;
use Doctrine\ORM\Query\Expr\Func;
use Eccube\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Eccube\Repository\CustomerRepository;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\Master\CustomerStatusRepository;

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
        SessionInterface $session
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
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * カート画面.
     *
     * @Route("/cart", name="cart", methods={"GET", "POST"})
     * @Route("/cart", name="cart_confirm", methods={"GET", "POST"})
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
                    'shipping' => $user,
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
                    ]);

                case 'complete':
                    $Customer = $form['customer']->getData();

                    if ( ! $Customer->getId() && $form['is_member']->getData() ) {
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
                    }

                    $data = $form->getData();
                    $cart_key = $request->request->all();
                    // dd($data, $cart_key);
                    
                    $Order = $this->createNewOrder( $this->cartService->getCart(), $data );
                    $this->purchaseFlow->validate($Order, new PurchaseContext(clone $Order, $Order->getCustomer()));

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
        ];
    }

    /**
     * ショッピング完了画面.
     *
     * @Route("/cart/complete", name="cart_complete", methods={"GET"})
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

    protected function createNewOrder( $Cart, $data ) {
        $Customer = $data['customer'];

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
            $Shipping = $this->createShippingFromCustomer($Customer);
            $Shipping->setOrder($Order);
            $this->addOrderItems($Order, $Shipping, $OrderItems);
            $this->setDefaultDelivery($Shipping);
            $this->entityManager->persist($Shipping);
            $Order->addShipping($Shipping);
        }

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
        $RoundingType = $this->roundingTypeRepository->find(1);
        $TaxType = $this->taxTypeRepository->find(1);
        $TaxDisplay = $this->taxDisplayTypeRepository->find(1);

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
    protected function createShippingFromCustomer(Customer $Customer)
    {
        $Shipping = new Shipping();
        $Shipping
            ->setName01($Customer->getName01())
            ->setName02($Customer->getName02())
            ->setKana01($Customer->getKana01())
            ->setKana02($Customer->getKana02())
            ->setCompanyName($Customer->getCompanyName())
            ->setPhoneNumber($Customer->getPhoneNumber())
            ->setPostalCode($Customer->getPostalCode())
            ->setPref($Customer->getPref())
            ->setAddr01($Customer->getAddr01())
            ->setAddr02($Customer->getAddr02());

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
}
