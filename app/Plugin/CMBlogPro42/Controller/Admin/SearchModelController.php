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

namespace Plugin\CMBlogPro42\Controller\Admin;

use Eccube\Controller\AbstractController;
use Eccube\Repository\CategoryRepository;
use Eccube\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchModelController.
 */
class SearchModelController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository 
     */
    private $categoryRepository;

    /**
     * SearchModelController constructor.
     * 
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * search product modal.
     *
     * @param Request   $request
     * @param int       $page_no
     * @param PaginatorInterface $paginator
     *
     * @return array
     * @Route("/%eccube_admin_route%/plugin/blog/search/product", name="plugin_blog_search_product")
     * @Route("/%eccube_admin_route%/plugin/blog/search/product/page/{page_no}", requirements={"page_no" = "\d+"}, name="plugin_blog_search_product_page")
     * @Template("@CMBlogPro42/admin/blog/search_product.twig")
     */
    public function searchProduct(Request $request, PaginatorInterface $paginator, $page_no = null)
    {
        if (!$request->isXmlHttpRequest()) {
            return null;
        }

        $pageCount = $this->eccubeConfig['eccube_default_page_count'];
        $session = $this->session;
        if ('POST' === $request->getMethod()) {
            log_info('get search data with parameters ', ['id' => $request->get('id'), 'category_id' => $request->get('category_id')]);
            $page_no = 1;
            $searchData = [
                'id' => $request->get('id'),
            ];
            if ($categoryId = $request->get('category_id')) {
                $searchData['category_id'] = $categoryId;
            }
            $session->set('eccube.plugin.blog.product.search', $searchData);
            $session->set('eccube.plugin.blog.product.search.page_no', $page_no);
        } else {
            $searchData = (array) $session->get('eccube.plugin.blog.product.search');
            if (is_null($page_no)) {
                $page_no = intval($session->get('eccube.plugin.blog.product.search.page_no'));
            } else {
                $session->set('eccube.plugin.blog.product.search.page_no', $page_no);
            }
        }

        if (!empty($searchData['category_id'])) {
            $searchData['category_id'] = $this->categoryRepository->find($searchData['category_id']);
        }

        $qb = $this->productRepository->getQueryBuilderBySearchDataForAdmin($searchData);
        // 除外するproduct_idを設定する
        $existProductId = $request->get('exist_product_id');
        if (strlen($existProductId > 0)) {
            $qb->andWhere($qb->expr()->notin('p.id', ':existProductId'))
                ->setParameter('existProductId', explode(',', $existProductId));
        }

        /** @var \Knp\Component\Pager\Pagination\SlidingPagination $pagination */
        $pagination = $paginator->paginate(
            $qb,
            $page_no,
            $pageCount,
            ['wrap-queries' => true]
        );

        return [
            'pagination' => $pagination,
        ];
    }

}
