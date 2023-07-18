<?php

namespace Customize\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eccube\Controller\AbstractController;

class PreparationPageController extends AbstractController
{
  /**
   * @Route("/preparation", name="preparation")
   * @Template("preparation.twig")
   */
  public function index(Request $request)
  {
    return [];
  }
}