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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Customize\Service\ProductHelper;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Eccube\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TopController extends AbstractController
{
    /**
     * @var ProductHelper
     */
    protected $productHelper;

    /**
     * TopController constructor.
     */
    public function __construct(
        ProductHelper $productHelper
    ) {
        $this->productHelper = $productHelper;
    }

    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @Template("index.twig")
     */
    public function index()
    {
        return [
            'earpick_list' => $this->productHelper->getRanks( 9 ),
            'bodycare_list' => $this->productHelper->getRanks( 5 ),
            'beauty_list' => $this->productHelper->getRanks( 13 ),
            'tableware_list' => $this->productHelper->getRanks( 20 ),
            'kitchentools_list' => $this->productHelper->getRanks( 15 ),
            'other_list' => $this->productHelper->getRanks( 26 ),
        ];
    }

    /**
     * マニュアル一覧画面.
     *
     * @Route("/manual/list", name="manual_list", methods={"GET"})
     * @Template("Manual/list.twig")
     */
    public function manualList(Request $request)
    {
        return [
            'ProductCategoryRepository' => $this->entityManager->getRepository(\Eccube\Entity\ProductCategory::class),
            'CategoryRepository' => $this->entityManager->getRepository(\Eccube\Entity\Category::class),
        ];
    }

    /**
     * マニュアル詳細画面.
     *
     * @Route("/manual/detail/{id}", name="manual_detail", methods={"GET"}, requirements={"id" = "\d+"})
     * @Template("Manual/detail.twig")
     * @ParamConverter("Product", options={"repository_method" = "findWithSortedClassCategories"})
     *
     * @param Request $request
     * @param Product $Product
     *
     * @return array
     */
    public function detail(Request $request, Product $Product)
    {
        $BlogProductRepository = $this->entityManager->getRepository(\Plugin\CMBlogPro42\Entity\BlogProduct::class);

        $BlogProduct = $BlogProductRepository->findOneBy(['Product' => $Product]);
        if ( empty($BlogProduct) ) {
            return $this->redirectToRoute('manual_list');
        }

        return [
            'Blog' => $BlogProduct->getBlog(),
        ];
    }
}
