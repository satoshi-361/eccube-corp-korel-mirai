<?php

namespace Plugin\CMBlogPro42\Controller\Admin;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Eccube\Common\Constant;

use Eccube\Controller\AbstractController;
use Eccube\Form\Type\Admin\SearchProductType;
use Plugin\CMBlogPro42\Entity\Blog;
use Plugin\CMBlogPro42\Entity\BlogImage;
use Plugin\CMBlogPro42\Entity\BlogCategory;
use Plugin\CMBlogPro42\Entity\BlogProduct;
use Plugin\CMBlogPro42\Entity\BlogStatus;
use Plugin\CMBlogPro42\Form\Type\Admin\BlogType;
use Plugin\CMBlogPro42\Form\Type\Admin\SearchBlogType;
use Plugin\CMBlogPro42\Repository\BlogRepository;
use Plugin\CMBlogPro42\Repository\BlogStatusRepository;
use Plugin\CMBlogPro42\Repository\BlogImageRepository;
use Plugin\CMBlogPro42\Repository\CategoryRepository;
use Plugin\CMBlogPro42\Repository\ConfigRepository;

use Eccube\Repository\Master\PageMaxRepository;
use Plugin\CMBlogPro42\Repository\ProductRepository;

use Eccube\Util\CacheUtil;
use Eccube\Util\FormUtil;

use Knp\Component\Pager\PaginatorInterface;
use Plugin\CMBlogPro42\Repository\BlogProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class BlogController extends AbstractController
{
    const USERDATAPATH = 'html/user_data/';

    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * @var BlogStatusRepository
     */
    protected $blogStatusRepository;

    /**
     * @var BlogImageRepository
     */
    protected $blogImageRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @var BlogProductRepository 
     */
    protected $blogProductRepository;


    /**
     * BlogController constructor.
     *
     * @param BlogRepository $blogRepository
     * @param BlogStatusRepository $blogStatusRepository
     * @param BlogImageRepository $blogImageRepository
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @param PageMaxRepository $pageMaxRepository
     * 
     * @param ConfigRepository $configRepository
     * @param BlogProductRepository $blogProductRepository
     */
    public function __construct(
        BlogRepository $blogRepository,
        BlogStatusRepository $blogStatusRepository,
        BlogImageRepository $blogImageRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        PageMaxRepository $pageMaxRepository,
        ConfigRepository $configRepository,
        BlogProductRepository $blogProductRepository
    )
    {
        $this->blogRepository = $blogRepository;
        $this->blogStatusRepository = $blogStatusRepository;
        $this->blogImageRepository = $blogImageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->pageMaxRepository = $pageMaxRepository;
        $this->configRepository = $configRepository;
        $this->blogProductRepository = $blogProductRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/cm_blog/blog/image/add", name="cm_blog_admin_blog_image_add", methods={"POST"})
     */
    public function addImage(Request $request)
    {
 
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException();
        }

        $images = $request->files->get('CMBlogPro_admin_blog');

        $allowExtensions = ['gif', 'jpg', 'jpeg', 'png'];
        $files = [];
        if (count($images) > 0) {
            foreach ($images as $img) {
                foreach ($img as $image) {
                    //ファイルフォーマット検証
                    $mimeType = $image->getMimeType();
                    if (0 !== strpos($mimeType, 'image')) {
                        throw new UnsupportedMediaTypeHttpException();
                    }

                    // 拡張子
                    $extension = $image->getClientOriginalExtension();
                    if (!in_array(strtolower($extension), $allowExtensions)) {
                        throw new UnsupportedMediaTypeHttpException();
                    }

                    $filename = date('mdHis').uniqid('_').'.'.$extension;
                    //$fullNamePath =  $this->eccubeConfig['eccube_user_data_route'] .'/'. $filename;

                    $image->move($this->eccubeConfig['eccube_temp_image_dir'], $filename);
                    //$image->move($this->eccubeConfig['eccube_temp_image_dir'], $fullNamePath);
                    $files[] = $filename;
                }
            }
        }

        // $event = new EventArgs(
        //     [
        //         'images' => $images,
        //         'files' => $files,
        //     ],
        //     $request
        // );
        // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_PRODUCT_ADD_IMAGE_COMPLETE, $event);
        //$files = $event->getArgument('files');

        return $this->json(['files' => $files], 200);
    }

    /**
     * @Route("/%eccube_admin_route%/cm_blog/blog/upload", name="cm_blog_admin_blog_upload", methods={"POST"})
     */
    public function uploadBlogImage(Request $request)
    {
        try {
            // File Route.
            $fileRoute = $this->eccubeConfig['eccube_save_image_dir'];

            reset ($_FILES);
            $temp = current($_FILES);

            if (is_uploaded_file($temp["tmp_name"])){

                if (preg_match("/([^wsd\-_~,;:[]().])|([.]{2,})/", $temp["name"])) {
                    throw new UnsupportedMediaTypeHttpException();
                }

                $extension = pathinfo($temp["name"], PATHINFO_EXTENSION);
                $fileName  = date('mdHis').uniqid('_').'.'.$extension;
                $fullNamePath = $fileRoute .'/'. $fileName;
                
                if (!in_array(strtolower($extension), array('gif', 'jpg', 'jpeg', 'png'))) {
                    throw new UnsupportedMediaTypeHttpException();
                }
                move_uploaded_file($temp["tmp_name"], $fullNamePath);
                
                return $this->json([
                    'uploaded' => 1,
                    'filename' => $fileName,
                    'location' => $fileName,
                ]);
            } else {
                throw new \Exception("ファイルアップロードに失敗しました");
            }
        } catch (\Exception $exception) {

            return $this->json([
                'uploaded' => 0,
                'error' => array(
                    'message' => $exception->getMessage(),
                )
            ]);
        }
    }

    /**
     * BlogCategory作成
     *
     * @param \Plugin\CMBlogPro42\Entity\Blog $blog
     * @param \Plugin\CMBlogPro42\Entity\Category $category
     *
     * @return \Plugin\CMBlogPro42\Entity\BlogCategory
     */
    private function createBlogCategory($blog, $category)
    {
        $blogCategory = new BlogCategory();
        $blogCategory->setBlog($blog);
        $blogCategory->setBlogId($blog->getId());
        $blogCategory->setCategory($category);
        $blogCategory->setCategoryId($category->getId());

        return $blogCategory;
    }

    /**
     * ブログ一覧
     *
     * @Route("/%eccube_admin_route%/cm_blog/blog", name="cm_blog_admin_blog")
     * @Route("/%eccube_admin_route%/cm_blog/blog/{page_no}", requirements={"page_no" = "\d+"}, name="cm_blog_admin_blog_page", methods={"GET", "POST"})
     * @Template("@CMBlogPro42/admin/blog/index.twig")
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null)
    {

        $builder = $this->formFactory
            ->createBuilder(SearchBlogType::class);

        // $event = new EventArgs(
        //     [
        //         'builder' => $builder,
        //     ],
        //     $request
        // );
        // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_PRODUCT_INDEX_INITIALIZE, $event);

        $searchForm = $builder->getForm();

          /**
         * ページの表示件数は, 以下の順に優先される.
         * - リクエストパラメータ
         * - セッション
         * - デフォルト値
         * また, セッションに保存する際は mtb_page_maxと照合し, 一致した場合のみ保存する.
         **/
        $page_count = $this->session->get('eccube.plg.admin.blog.search.page_count',
            $this->eccubeConfig->get('eccube_default_page_count'));

        $page_count_param = (int) $request->get('page_count');
        $pageMaxis = $this->pageMaxRepository->findAll();

        if ($page_count_param) {
            foreach ($pageMaxis as $pageMax) {
                if ($page_count_param == $pageMax->getName()) {
                    $page_count = $pageMax->getName();
                    $this->session->set('eccube.plg.admin.blog.search.page_count', $page_count);
                    break;
                }
            }
        }

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);

            if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                /**
                 * 検索が実行された場合は, セッションに検索条件を保存する.
                 * ページ番号は最初のページ番号に初期化する.
                 */
                $page_no = 1;
                $searchData = $searchForm->getData();

                // 検索条件, ページ番号をセッションに保持.
                $this->session->set('eccube.plg.admin.blog.search', FormUtil::getViewData($searchForm));
                $this->session->set('eccube.plg.admin.blog.search.page_no', $page_no);
            } else {
                // 検索エラーの際は, 詳細検索枠を開いてエラー表示する.
                return [
                    'searchForm' => $searchForm->createView(),
                    'pagination' => [],
                    'pageMaxis' => $pageMaxis,
                    'page_no' => $page_no,
                    'page_count' => $page_count,
                    'has_errors' => true,
                ];
            }
        } else {
            if (null !== $page_no || $request->get('resume')) {
                /*
                 * ページ送りの場合または、他画面から戻ってきた場合は, セッションから検索条件を復旧する.
                 */
                if ($page_no) {
                    // ページ送りで遷移した場合.
                    $this->session->set('eccube.plg.admin.blog.search.page_no', (int) $page_no);
                } else {
                    // 他画面から遷移した場合.
                    $page_no = $this->session->get('eccube.plg.admin.blog.search.page_no', 1);
                }
                $viewData = $this->session->get('eccube.plg.admin.blog.search', []);
                $searchData = FormUtil::submitAndGetData($searchForm, $viewData);
            } else {
                /**
                 * 初期表示の場合.
                 */
                $page_no = 1;
                // submit default value
                $viewData = FormUtil::getViewData($searchForm);
                $searchData = FormUtil::submitAndGetData($searchForm, $viewData);

                // セッション中の検索条件, ページ番号を初期化.
                $this->session->set('eccube.plg.admin.blog.search', $viewData);
                $this->session->set('eccube.plg.admin.blog.search.page_no', $page_no);
            }
        }

        // // Temporary settings
        // $ChoicedCategoryIds = array();
        // if (isset($search['search_blog'])) {
        //     $searchData = $search['search_blog'];
        // }
        // if (isset($search['categories'])) {
        //     $ChoicedCategoryIds = $searchData['categories'];
        // }

        $qb = $this->blogRepository->getQueryBuilderBySearchDataAdmin($searchData);

        // $event = new EventArgs(
        //     [
        //         'qb' => $qb,
        //         'searchData' => $searchData,
        //     ],
        //     $request
        // );

        // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_PRODUCT_INDEX_SEARCH, $event);

        $pagination = $paginator->paginate(
            $qb,
            $page_no,
            $page_count
        );

        return [
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_no' => $page_no,
            'page_count' => $page_count,
            'has_errors' => false,
            'Categories' => $this->categoryRepository->getList(array()),
            //'ChoicedCategoryIds' => $ChoicedCategoryIds, // temporary
        ];
    }

    /**
     * BlogCategory作成
     *
     * @param \Plugin\CMBlogPro42\Entity\Blog $blog
     *
     * @return array
     */
    private function setChoicedCategoryIds($blog) {
        $ChoicedCategoryIds = [];
        $categories = $blog->getBlogCategories();

        if ($categories)
            foreach ($blog->getBlogCategories() as $category)
                array_push($ChoicedCategoryIds, $category->getCategoryId());

        return $ChoicedCategoryIds;
    }

    /**
     * ブログ編集 ymk changes
     *
     * @Route("/%eccube_admin_route%/cm_blog/blog/new", name="cm_blog_admin_blog_create")
     * @Route("/%eccube_admin_route%/cm_blog/blog/{id}/edit", requirements={"id" = "\d+"}, name="cm_blog_admin_blog_edit")
     * @Template("@CMBlogPro42/admin/blog/edit.twig")
     */
    public function edit(Request $request, RouterInterface $router, CacheUtil $cacheUtil, $id = null)
    {

        if (is_null($id)) {
            $Blog = new Blog();
            $BlogStatus = $this->blogStatusRepository->find(BlogStatus::DISPLAY_HIDE);
            $Blog->setStatus($BlogStatus);
        } else {
            $Blog = $this->blogRepository->find($id);
            if (!$Blog) {
                throw new NotFoundHttpException();
            }
        }

        $builder = $this->formFactory->createBuilder(BlogType::class, $Blog);

        $form = $builder->getForm();

        // ファイルの登録
        $images = [];
        $BlogImages = $Blog->getBlogImage();
        foreach ($BlogImages as $BlogImage) {
            $images[] = $BlogImage->getFileName();
        }
        $form['images']->setData($images);

        $categories = [];
        $BlogCategories = $Blog->getBlogCategories();
        foreach ($BlogCategories as $BlogCategory) {
            /* @var $BlogCategory \Plugin\CMBlogPro42\Entity\BlogCategory */
            $categories[] = $BlogCategory->getCategory();
        }
        $form['Category']->setData($categories);

        $blogProducts = [];
        $products = $Blog->getBlogProduct();
        foreach ($products as $bProduct) {
            $blogProducts[] = clone $bProduct;
        }
        $form['BlogProduct']->setData($blogProducts);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                log_info('ブログ記事登録開始', [$id]);
                /**  @var \Plugin\CMBlogPro42\Entity\Blog $Blog */
                $Blog = $form->getData();

                // カテゴリの登録
                // 一度クリア
                foreach ($Blog->getBlogCategories() as $BlogCategory) {
                    $Blog->removeBlogCategory($BlogCategory);
                    $this->entityManager->remove($BlogCategory);
                    $this->entityManager->flush($BlogCategory);
                }
                $this->entityManager->persist($Blog);
                $this->entityManager->flush();

                $count = 1;
                $Categories = $form->get('Category')->getData();
                $categoriesIdList = [];
                foreach ($Categories as $Category) {
                    if (!isset($categoriesIdList[$Category->getId()])) {
                        $BlogCategory = $this->createBlogCategory($Blog, $Category, $count);
                        $this->entityManager->persist($BlogCategory);
                        $count++;
                        /* @var $Blog \Plugin\CMBlogPro42\Entity\Blog */
                        $Blog->addBlogCategory($BlogCategory);
                        //$categoriesIdList[$ParentCategory->getId()] = true;
                    }
                }

                $BlogProducts = $this->blogProductRepository->findBy(['Blog' => $Blog]);
                foreach ($BlogProducts as $BlogProduct) {
                    $Blog->removeBlogProduct($BlogProduct);
                    $this->entityManager->remove($BlogProduct);
                    $this->entityManager->flush($BlogProduct);
                }

                $BTs = $form->get('BlogProduct')->getData();
                /** @var BlogProduct $BT */
                foreach ($BTs as $BT) {
                    $BT->setBlog($Blog);
                    $this->entityManager->persist($BT);
                    $Blog->addBlogProduct($BT);
                }

                // 画像の登録
                $add_images = $form->get('add_images')->getData();
                foreach ($add_images as $add_image) {
                    $BlogImage = new \Plugin\CMBlogPro42\Entity\BlogImage();
                    $BlogImage
                        ->setFileName($add_image)
                        ->setBlog($Blog)
                        ->setSortNo(1);
                    $Blog->addBlogImage($BlogImage);
                    $this->entityManager->persist($BlogImage);

                    // 移動
                    $file = new File($this->eccubeConfig['eccube_temp_image_dir'].'/'. $add_image);
                    $file->move($this->eccubeConfig['eccube_save_image_dir']);
                    //$file->move($this->eccubeConfig['eccube_user_data_route'].'/cm_blog/images/');
                }

                // 画像の削除
                $delete_images = $form->get('delete_images')->getData();
                foreach ($delete_images as $delete_image) {

                    $BlogImage = $this->blogImageRepository
                        ->findOneBy(['file_name' => $delete_image]);

                    // 追加してすぐに削除した画像は、Entityに追加されない
                    if ($BlogImage instanceof BlogImage) {
                        $Blog->removeBlogImage($BlogImage);
                        $this->entityManager->remove($BlogImage);
                    }
                    $this->entityManager->persist($Blog);

                    // 削除
                    $fs = new Filesystem();
                    $fs->remove($this->eccubeConfig['eccube_save_image_dir'].'/'.$delete_image);
                    //$fs->remove( $this->eccubeConfig['eccube_user_data_route'].'/cm_blog/images/'.$delete_image);
                }
                $this->entityManager->persist($Blog);
                $this->entityManager->flush();

                $sortNos = $request->get('sort_no_images');
                if ($sortNos) {
                    foreach ($sortNos as $sortNo) {
                        list($filename, $sortNo_val) = explode('//', $sortNo);
                        $BlogImage = $this->blogImageRepository
                            ->findOneBy([
                                'file_name' => $filename,
                                'Blog' => $Blog,
                            ]);
                        $BlogImage->setSortNo($sortNo_val);
                        $this->entityManager->persist($BlogImage);
                    }
                }
                $this->entityManager->flush();

                $Blog->setUpdateDate(new \DateTime());
                $this->entityManager->flush();

                log_info('商品登録完了', [$id]);

                $this->addSuccess('admin.common.save_complete', 'admin');

                if ($returnLink = $form->get('return_link')->getData()) {
                    try {
                        // $returnLinkはpathの形式で渡される. pathが存在するかをルータでチェックする.
                        $pattern = '/^'.preg_quote($request->getBasePath(), '/').'/';
                        $returnLink = preg_replace($pattern, '', $returnLink);
                        $result = $router->match($returnLink);
                        // パラメータのみ抽出
                        $params = array_filter($result, function ($key) {
                            return 0 !== \strpos($key, '_');
                        }, ARRAY_FILTER_USE_KEY);

                        // pathからurlを再構築してリダイレクト.
                        return $this->redirectToRoute($result['_route'], $params);
                    } catch (\Exception $e) {
                        // マッチしない場合はログ出力してスキップ.
                        log_warning('URLの形式が不正です。');
                    }
                }

                $cacheUtil->clearDoctrineCache();

                return $this->redirectToRoute('cm_blog_admin_blog_edit', ['id' => $Blog->getId()]);
            }
        }


        // ツリー表示のため、ルートからのカテゴリを取得
        $TopCategories = $this->categoryRepository->getList(null);

        return $this->renderRegistView([
            'Blog' => $Blog,
            'form' => $form->createView(),
            'id' => $id,
            'TopCategories' => $TopCategories,
            'ChoicedCategoryIds' => $this->setChoicedCategoryIds($Blog)
        ]);
    }

    /**
     * ブログ削除
     *
     * @Route("/%eccube_admin_route%/cm_blog/blog/{id}/delete", name="cm_blog_admin_blog_delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            // 無い場合
            $this->deleteMessage();
            return $this->redirectToRoute('cm_blog_admin_blog');
        }

        // TODO：TRANSACTIONを追加する
        try {
            // イメージをパスを取得する
            // データ削除
            $this->entityManager->remove($blog);
            $this->entityManager->flush($blog);
            // イメージを削除する
            $config = $this->configRepository->get();
            $this->addSuccess('ブログを削除しました', 'admin');
        } catch (ForeignKeyConstraintViolationException $e) {
            $error_msg = 'カテゴリ削除失敗';
            log_error($error_msg, [$e], 'plugin');
            $this->addError($error_msg, 'admin');
        }

        return $this->redirectToRoute('cm_blog_admin_blog');
    }

    /**
     * @Route("/%eccube_admin_route%/cm_blog/blog/{id}/copy", requirements={"id" = "\d+"}, name="cm_blog_admin_blog_copy", methods={"POST"})
     */
    public function copy(Request $request, $id = null)
    {
        $this->isTokenValid();

        if (!is_null($id)) {
            $Blog = $this->blogRepository->find($id);

            if ($Blog instanceof Blog) {

                // Only categories, no classes or tags for now. Need to fix the images

                $CopyBlog = clone $Blog;
                $CopyBlog->copy();
                $BlogStatus = $this->blogStatusRepository->find(BlogStatus::DISPLAY_HIDE);
                $CopyBlog->setStatus($BlogStatus);
                $CopyBlog->setSlug(null);

                $CopyBlogCategories = $CopyBlog->getBlogCategories();
                foreach ($CopyBlogCategories as $Category) {
                    $this->entityManager->persist($Category);
                }

                $CopyBlogProduct = $CopyBlog->getBlogProduct();
                foreach ($CopyBlogProduct as $Product) {
                    $this->entityManager->persist($Product);
                }


                $Images = $CopyBlog->getBlogImage();
                foreach ($Images as $Image) {
                    // 画像ファイルを新規作成
                    $extension = pathinfo($Image->getFileName(), PATHINFO_EXTENSION);
                    $filename = date('mdHis').uniqid('_').'.'.$extension;
                    try {
                        $fs = new Filesystem();
                        $fs->copy($this->eccubeConfig['eccube_save_image_dir'].'/'.$Image->getFileName(), $this->eccubeConfig['eccube_save_image_dir'].'/'.$filename);
                    } catch (\Exception $e) {
                        // エラーが発生しても無視する
                    }
                    $Image->setFileName($filename);

                    $this->entityManager->persist($Image);
                }
               
                $this->entityManager->persist($CopyBlog);

                $this->entityManager->flush();

                $this->addSuccess('plg.CMBlogPro.admin.blog.copy_complete', 'admin');

                return $this->redirectToRoute('cm_blog_admin_blog_edit', ['id' => $CopyBlog->getId()]);
            } else {
                $this->addError('plg.CMBlogPro.admin.blog.copy_error', 'admin');
            }
        } else {
            $this->addError('plg.CMBlogPro.admin.blog.copy_error', 'admin');
        }

        return $this->redirectToRoute('cm_blog_admin_blog');
    }


    /**
     * Bulk public action
     *
     * @Route("/%eccube_admin_route%/cm_blog/blog/bulk/blog-status/{id}", requirements={"id" = "\d+"}, name="cm_blog_admin_bulk_blog_status", methods={"POST"})
     *
     * @param Request $request
     * @param BlogStatus $BlogStatus
     *
     * @return RedirectResponse
     */
    public function bulkBlogStatus(Request $request, BlogStatus $BlogStatus, CacheUtil $cacheUtil)
    {
        $this->isTokenValid();

        /** @var Blog[] $Blogs */
        $Blogs = $this->blogRepository->findBy(['id' => $request->get('ids')]);
        $count = 0;
        foreach ($Blogs as $Blog) {
            try {
                $Blog->setStatus($BlogStatus);
                $this->blogRepository->save($Blog);
                $count++;
            } catch (\Exception $e) {
                $this->addError($e->getMessage(), 'admin');
            }
        }
        try {
            if ($count) {
                $this->entityManager->flush();
                $msg = $this->translator->trans('plg.CMBlogPro.admin.blog.bulk_change_status_complete', [
                    '%count%' => $count,
                    '%status%' => $BlogStatus->getName(),
                ]);
                $this->addSuccess($msg, 'admin');
                $cacheUtil->clearDoctrineCache();
            }
        } catch (\Exception $e) {
            $this->addError($e->getMessage(), 'admin');
        }

        return $this->redirectToRoute('cm_blog_admin_blog', ['resume' => Constant::ENABLED]);
    }

    /**
     * 編集画面用のrender. ymk
     *
     * @param array       $parameters
     *
     * @return Response
     */
    protected function renderRegistView($parameters = [])
    {
        // 商品検索フォーム
        $searchProductModalForm = $this->formFactory->createBuilder(SearchProductType::class)->getForm();
        $viewParameters = [
            'searchProductModalForm' => $searchProductModalForm->createView(),
        ];
        $viewParameters += $parameters;

        return $this->render('@CMBlogPro42/admin/blog/edit.twig', $viewParameters);
    }

}