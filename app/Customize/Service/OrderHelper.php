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

namespace Customize\Service;

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

use Eccube\Service\OrderHelper as BaseService;

class OrderHelper extends BaseService
{
    public function __construct(
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
        SessionInterface $session
    ) {
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
        $this->session = $session;

        parent::__construct( $container, $entityManager, $orderRepository, $orderItemTypeRepository, $orderStatusRepository, $deliveryRepository,
            $paymentRepository, $deviceTypeRepository, $prefRepository, $mobileDetector, $session );
    }

    /**
     * @param Collection|ArrayCollection|CartItem[] $CartItems
     *
     * @return OrderItem[]
     */
    protected function createOrderItemsFromCartItems($CartItems)
    {
        $ProductItemType = $this->orderItemTypeRepository->find(OrderItemType::PRODUCT);

        return array_map(function ($item) use ($ProductItemType) {
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
                ->setProperty($item->getProperty());

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
     * 購入処理中の受注を生成する.
     *
     * @param Customer $Customer
     * @param $CartItems
     * @param array $shipping
     *
     * @return Order
     */
    public function createPurchaseProcessingOrder1(Cart $Cart, Customer $Customer, $shipping)
    {
        $OrderStatus = $this->orderStatusRepository->find(OrderStatus::PROCESSING);
        $Order = new Order($OrderStatus);

        $preOrderId = $this->createPreOrderId();
        $Order->setPreOrderId($preOrderId);

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
            $Shipping = $this->createShipping($shipping);
            $Shipping->setOrder($Order);
            $this->addOrderItems($Order, $Shipping, $OrderItems);
            $this->setDefaultDelivery($Shipping);
            $this->entityManager->persist($Shipping);
            $Order->addShipping($Shipping);
        }

        $this->setDefaultPayment($Order);

        $this->entityManager->persist($Order);

        return $Order;
    }

    /**
     * @param Cart $Cart
     * @param Customer $Customer
     * @param array $shipping
     *
     * @return Order|null
     */
    public function initializeOrder1(Cart $Cart, Customer $Customer, $shipping)
    {
        // 購入処理中の受注情報を取得
        if ($Order = $this->getPurchaseProcessingOrder($Cart->getPreOrderId())) {
            return $Order;
        }

        // 受注情報を作成
        $Order = $this->createPurchaseProcessingOrder1($Cart, $Customer, $shipping);
        $Cart->setPreOrderId($Order->getPreOrderId());

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
     * @param array $shipping
     *
     * @return Shipping
     */
    protected function createShipping($shipping)
    {
        $Shipping = new Shipping();
        $Shipping
            ->setName01($shipping['name01'])
            ->setName02($shipping['name02'])
            ->setKana01($shipping['kana01'])
            ->setKana02($shipping['kana02'])
            ->setPhoneNumber($shipping['phone_number'])
            ->setPostalCode($shipping['postal_code'])
            ->setPref($shipping['pref'])
            ->setAddr01($shipping['addr01'])
            ->setAddr02($shipping['addr02']);

        return $Shipping;
    }
}
