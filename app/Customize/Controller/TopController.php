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
}
