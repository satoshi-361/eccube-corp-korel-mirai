<!doctype html>
<html lang="ja">

<head prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb# product: https://ogp.me/ns/product#">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="eccube-csrf-token"
        content="a7608e4523217ca38c0c4cbedc37a.PINmG_mwvzvF3snzUvsc_YmhjfYAFMMVjMENBh0De08.X_EXT6uI21e_vIyxDYp5tbDmuq5PZKws-6thX2xgDCBdsV9TyIjTc6CVog">
    <title>横浜みらい / マニュアル一覧ページ</title>
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="横浜みらい" />
    <meta property="og:url" content="<?php echo $baseUrl; ?>/user_data/manual_list" />
    <link rel="canonical" href="<?php echo $baseUrl; ?>/user_data/manual_list" />
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/favicon/favicon64.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/fontawesome/css/v4-shims.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/style_sp.css" type="text/css">
    <!-- Animation -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/animate.css" type="text/css" />
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/slick.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/slick-theme.css" type="text/css" />
    <script src="/html/bundle/front.bundle.js"></script>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/manual.css" type="text/css" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7HGCRKZD9S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7HGCRKZD9S');
    </script>
    <script>
        $(function () {
            $.ajaxSetup({
                'headers': {
                    'ECCUBE-CSRF-TOKEN': $('meta[name="eccube-csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <!-- ▼下層ページ用アセット -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/subpage.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/css/subpage_sp.css" type="text/css" />
    <!-- ▲下層ページ用アセット -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/html/user_data/assets/css/customize.css">

    <style>
        .p-manual_body {
            padding: 30px 0;
            text-align: center;
        }
        .p-manual_body .image {
            margin: 25px auto;
        }
        .p-manual_body .image img {
            width: inherit;
            margin: auto;
        }
        .p-manual_body h3 {
            font-family: "Source Han Sans JP";
            font-weight: 500;
            font-size: 32px;
            line-height: 40px;
            text-align: center;
            color: #7fb744;
        }
        .p-manual_body .image.logo {
            margin-top: 80px;
        }
        .p-manual_body .link a {
            color: #159DAF;
            text-decoration: underline;
        }

        @media only screen and (max-width: 767px) {
            .p-manual_body h3 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body id="page_manual_list" class="other_page">
    <div class="page">
        <div class="ec-layoutRole">
            <header class="header">
                <!-- ▼新しいヘッダー -->
                <div class="header_contain">
                    <div class="header_logo">
                        <a href="<?php echo $baseUrl; ?>/">
                            <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/logo.png" alt="横浜みらい">
                        </a>
                    </div>
                    <div class="header_nav_pc">
                        <ul class="nav_list">
                            <li class="p-menu active">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=9">
                                    <span class="en">EARPICK</span>
                                    <span class="jp">耳かき</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=10">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_01.png"
                                                    alt="マイクロファイバー製">
                                                <span class="jp pc">
                                                    マイクロ<br>ファイバー製
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=11">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_02.png"
                                                    alt="ワイヤータイプ">
                                                <span class="jp pc">
                                                    ワイヤー<br>タイプ
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=12">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_03.png"
                                                    alt="専門医用">
                                                <span class="jp pc">専門医用</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="p-menu">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=5">
                                    <span class="en">BODYCARE</span>
                                    <span class="jp">ボディケア</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=6">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-bodycare_01.png"
                                                    alt="ヘルスケア雑貨">
                                                <span class="jp pc">
                                                    ヘルスケア<br>雑貨
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=7">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-bodycare_02.png"
                                                    alt="オーラルマウスケア">
                                                <span class="jp pc">
                                                    オーラル<br>マウスケア
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="p-menu">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=13">
                                    <span class="en">BEAUTY</span>
                                    <span class="jp">ビューティー</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=14">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-beauty_01.png"
                                                    alt="ヘアブラシ">
                                                <span class="jp pc">ヘアブラシ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="p-menu">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=20">
                                    <span class="en">TABLE WEAR</span>
                                    <span class="jp">テーブルウェア</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=21">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table01.png"
                                                    alt="カトラリー">
                                                <span class="jp pc">カトラリー</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=22">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table02.png"
                                                    alt="UDカトラリー">
                                                <span class="jp pc">UDカトラリー</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=23">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table03.png"
                                                    alt="デザインカトラリー">
                                                <span class="jp pc">
                                                    デザイン<br>カトラリー
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=24">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table04.png"
                                                    alt="離乳食スプーン">
                                                <span class="jp pc">離乳食スプーン</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=25">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table05.png"
                                                    alt="食器(グラス)">
                                                <span class="jp pc">食器(グラス)</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="p-menu">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=15">
                                    <span class="en">KITCHENTOOL</span>
                                    <span class="jp">キッチン用品</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=16">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen01.png"
                                                    alt="包丁">
                                                <span class="jp pc">包丁</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=17">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen02.png"
                                                    alt="ピーラー">
                                                <span class="jp pc">ピーラー</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=18">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen03.png"
                                                    alt="菜箸">
                                                <span class="jp pc">菜箸</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=19">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen04.png"
                                                    alt="ハサミ">
                                                <span class="jp pc">ハサミ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="p-menu">
                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=26">
                                    <span class="en">OTHER</span>
                                    <span class="jp">その他</span>
                                </a>
                                <div class="p-submenu">
                                    <ul class="p-submenu_list">
                                        <li>
                                            <a href="<?php echo $baseUrl; ?>/products/list?category_id=27">
                                                <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-other_01.png"
                                                    alt="ペットブラシ">
                                                <span class="jp pc">ペットブラシ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="header_icons">
                        <ul class="icons_list">
                            <li>
                                <a href="<?php echo $baseUrl; ?>/logout">
                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/icon-login.png" alt="ログアウト">
                                    <span class="jp">ログアウト</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $baseUrl; ?>/mypage/">
                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/icon-register.png" alt="マイページ">
                                    <span class="jp">マイページ</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $baseUrl; ?>/mypage/favorite">
                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/icon-faiver.png" alt="お気に入り">
                                    <span class="jp">お気に入り</span>
                                </a>
                            </li>
                            <li class="ec-headerRole__cart">
                                <style>
                                    .header ul li.ec-headerRole__cart a {
                                        position: relative;
                                    }

                                    .header ul li.ec-headerRole__cart a .ec-cartNavi__badge {
                                        width: 15px;
                                        height: 15px;
                                        border-radius: 10px;
                                        background: #ed431f;
                                        color: white;
                                        font-size: 12px;
                                        font-style: normal;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        position: absolute;
                                        bottom: 15px;
                                        right: -5px;
                                        z-index: 1;
                                    }

                                    @media only screen and (max-width: 767px) {
                                        .header ul li.ec-headerRole__cart a .ec-cartNavi__badge {
                                            width: 12px;
                                            height: 12px;
                                            font-size: 11px;
                                        }
                                    }
                                </style>
                                <a href="<?php echo $baseUrl; ?>/cart">
                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/icon-cart.png" alt="カート">
                                    <span class="jp">カート</span>
                                    <span class="ec-cartNavi__badge">1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sp sp_menu">
                        <div class="menu_btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div id="sp_nav" class="nav_sp sp" style="right: -100%;">
                        <div class="sp_nav_contain">
                            <div class="sp_nav_head">
                                <div class="header_logo">
                                    <a href="<?php echo $baseUrl; ?>/">
                                        <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/logo.png" alt="横浜みらい">
                                        <h1>横浜みらい</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="sp_nav_body">
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">EARPICK</span>
                                        <span class="jp">耳かき</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=10">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_01.png"
                                                        alt="マイクロファイバー製">
                                                    <span class="jp">
                                                        マイクロ<br>ファイバー製
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=11">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_02.png"
                                                        alt="ワイヤータイプ">
                                                    <span class="jp">
                                                        ワイヤー<br>タイプ
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=12">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-earpick_03.png"
                                                        alt="専門医用">
                                                    <span class="jp">専門医用</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">BODYCARE</span>
                                        <span class="jp">ボディケア</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=6">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-bodycare_01.png"
                                                        alt="ヘルスケア雑貨">
                                                    <span class="jp">
                                                        ヘルスケア<br>雑貨
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=7">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-bodycare_02.png"
                                                        alt="オーラルマウスケア">
                                                    <span class="jp">
                                                        オーラル<br>マウスケア
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">BEAUTY</span>
                                        <span class="jp">ビューティー</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=14">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-beauty_01.png"
                                                        alt="ヘアブラシ">
                                                    <span class="jp">ヘアブラシ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">TABLE WEAR</span>
                                        <span class="jp">テーブルウェア</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=21">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table01.png"
                                                        alt="UDカトラリー">
                                                    <span class="jp">カトラリー</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=22">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table02.png"
                                                        alt="UDカトラリー">
                                                    <span class="jp">UDカトラリー</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=23">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table03.png"
                                                        alt="デザインカトラリー">
                                                    <span class="jp">
                                                        デザイン<br>カトラリー
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=24">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table04.png"
                                                        alt="離乳食スプーン">
                                                    <span class="jp">離乳食スプーン</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=25">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-table05.png"
                                                        alt="食器(グラス)">
                                                    <span class="jp">食器(グラス)</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">KITCHENTOOL</span>
                                        <span class="jp">キッチン用品</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=16">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen01.png"
                                                        alt="包丁">
                                                    <span class="jp">包丁</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=17">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen02.png"
                                                        alt="ピーラー">
                                                    <span class="jp">ピーラー</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=18">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen03.png"
                                                        alt="菜箸">
                                                    <span class="jp">菜箸</span>
                                                </a>
                                            </li>
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=19">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-kitchen04.png"
                                                        alt="ハサミ">
                                                    <span class="jp">ハサミ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sp_nav_item">
                                    <button id="menu-button-1" aria-expanded="false">
                                        <span class="en">OTHER</span>
                                        <span class="jp">その他</span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="subnav_content">
                                        <ul class="subnav_itemlist">
                                            <li class="subnav_item">
                                                <a href="<?php echo $baseUrl; ?>/products/list?category_id=27">
                                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/top/category-icon/cate-icon-other_01.png"
                                                        alt="ペットブラシ">
                                                    <span class="jp">ペットブラシ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ▲新しいヘッダー -->
            </header>
            <div class="ec-layoutRole__contents">
                <div class="ec-layoutRole__main">
                    <!-- manual -->
                    <main class="main">
                        <div class="c-subpage_contain">
                            <div class="p-manualpage" style="padding-top: 40px;">
                                <div class="p-manual_body">
                                    <div class="image">
                                        <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/warn.png" />
                                    </div>
                                    <h3>
                                        このページは現在準備中です。<br/>
                                        公開までもうしばらくお待ちください。
                                    </h3>
                                    <div class="image logo">
                                        <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/logo.png" />
                                    </div>
                                    <p class="link">レーベン・オフィシャルストアは<a href="https://inventor-leben.shop-pro.jp/">こちら</a></p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <footer class="footer">
                <!-- ▼新しいフーター -->
                <div class="footer_contain">
                    <div class="footer_contain_flex">
                        <div class="footer_information">
                            <div class="footer_logo">
                                <a href="<?php echo $baseUrl; ?>/">
                                    <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/logo.png" alt="">
                                </a>
                            </div>
                            <div class="footer_company">
                                <p class="campany_name">株式会社レーベン</p>
                                <p>
                                    〒220-0004<br>横浜市西区北幸2-8-19横浜西口Ｋビル１階
                                </p>
                            </div>
                        </div>
                        <div class="footer_nav">
                            <div class="footer_nav_title">
                                <p>ご利用ガイド</p>
                            </div>
                            <div class="footer_navlist">
                                <ul>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/user_data/guide#delivery">
                                            <span class="icon">▶︎ </span>
                                            送料・配送方法について
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/user_data/guide#paymethod">
                                            <span class="icon">▶︎ </span>
                                            お支払い方法について
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/user_data/guide#refund">
                                            <span class="icon">▶︎ </span>
                                            返品・交換について
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/help/tradelaw">
                                            <span class="icon">▶︎ </span>
                                            特定商取引法に基づく表記
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/help/privacy">
                                            <span class="icon">▶︎ </span>
                                            個人情報の取り扱いについて
                                        </a>
                                    </li>
                                    <li class="sp">
                                        <a href="<?php echo $baseUrl; ?>/user_data/guide#calendar">
                                            <span class="icon">▶︎ </span>
                                            営業日カレンダー
                                        </a>
                                    </li>
                                    <li class="sp">
                                        <a href="<?php echo $baseUrl; ?>/user_data/faq">
                                            <span class="icon">▶︎ </span>
                                            よくあるご質問
                                        </a>
                                    </li>
                                    <li class="sp">
                                        <a href="https://yokohama-city.co.jp/company/">
                                            <span class="icon">▶︎ </span>
                                            レーベンとは
                                        </a>
                                    </li>
                                    <li class="sp">
                                        <a href="<?php echo $baseUrl; ?>/contact">
                                            <span class="icon">▶︎ </span>
                                            お問い合わせ
                                        </a>
                                    </li>
                                </ul>
                                <ul class="pc">
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/user_data/guide#calendar">
                                            <span class="icon">▶︎ </span>
                                            営業日カレンダー
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/user_data/faq">
                                            <span class="icon">▶︎ </span>
                                            よくあるご質問
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://yokohama-city.co.jp/company/">
                                            <span class="icon">▶︎ </span>
                                            レーベンとは
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $baseUrl; ?>/contact">
                                            <span class="icon">▶︎ </span>
                                            お問い合わせ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <p>Copyright© LEBEN Co.,Ltd. All rights reserved.</p>
                </div>
                <!-- ▲新しいフーター -->
            </footer>
        </div>
        <!-- ec-layoutRole -->
        <div class="ec-overlayRole"></div>
        <div class="ec-drawerRole"></div>
    </div>
    <div class="pagetop"
        style="position: fixed; bottom: 0px; right: 0px; opacity: 1; cursor: pointer; z-index: 200; right: 30px !important; bottom: 30px !important">
        <img src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/image/common/btn_pagetop.png" style="width:55px; height:55px;" />
    </div>
    <script>
        var eccube_lang = {
            'common.delete_confirm': "削除してもよろしいですか?",
            'front.product.out_of_stock': "ただいま品切れ中です。",
        };
    </script>
    <script src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/js/function.js"></script>
    <script src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/js/eccube.js"></script>
    <script src="/html/user_data/assets/js/customize.js"></script>
    <!-- script -->
    <script src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/js/wow.min.js"></script>
    <script src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/js/slick.js"></script>
    <script src="<?php echo $baseUrl; ?>/html/template/<?php echo $templateCode; ?>/assets/js/script.js"></script>
    <script>
        new WOW().init();
    </script>
</body>

</html>