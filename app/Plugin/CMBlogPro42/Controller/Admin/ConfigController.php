<?php

namespace Plugin\CMBlogPro42\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\CMBlogPro42\Form\Type\Admin\ConfigType;
use Plugin\CMBlogPro42\Repository\ConfigRepository;
use Plugin\CMBlogPro42\Repository\BlogSortRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;
    /**
     * @var BlogSortRepository
     */
    protected $blogSortRepository;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository, BlogSortRepository $blogSortRepository = null)
    {
        $this->configRepository   = $configRepository;
        $this->blogSortRepository = $blogSortRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/cm_blog_pro42/config", name="cm_blog_pro42_admin_config")
     * @Template("@CMBlogPro42/admin/config.twig")
     */
    public function index(Request $request)
    {
        $Config = $this->configRepository->get();
        $form = $this->createForm(ConfigType::class, $Config);
        if (!is_null($this->blogSortRepository) && !is_null($Config->getSort())) {
            $form['Sort']->setData($this->blogSortRepository->find($Config->getSort()->getId()));
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sortID = $form->get('Sort')->getData();
            $form->getData()->setSort($sortID);
            $Config = $form->getData();
            $this->entityManager->persist($Config);
            $this->entityManager->flush($Config);
            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('cm_blog_pro42_admin_config');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
