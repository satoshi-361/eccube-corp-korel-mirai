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

namespace Customize\Twig\Extension;

use Eccube\Common\EccubeConfig;
use Eccube\Repository\ProductRepository;
use Twig\TwigFunction;

use Eccube\Twig\Extension\EccubeExtension as BaseExtension;

class EccubeExtension extends BaseExtension
{
    /**
     * EccubeExtension constructor.
     *
     * @param EccubeConfig $eccubeConfig
     * @param ProductRepository $productRepository
     */
    public function __construct(EccubeConfig $eccubeConfig, ProductRepository $productRepository)
    {
        parent::__construct( $eccubeConfig, $productRepository );
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFunction[] An array of functions
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('has_errors', [$this, 'hasErrors']),
            new TwigFunction('active_menus', [$this, 'getActiveMenus']),
            new TwigFunction('class_categories_as_json', [$this, 'getClassCategoriesAsJson']),
            new TwigFunction('product', [$this, 'getProduct']),
            new TwigFunction('currency_symbol', [$this, 'getCurrencySymbol']),
            new TwigFunction('youtube_embed_link', [$this, 'getYouTubeEmbedLink']),
        ];
    }

    /**
     * return id of Youtube video
     *
     * @return string
     */
    public function getYouTubeEmbedLink($url) {
        $regex = '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/';
        preg_match($regex, $url, $matches);
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
}
