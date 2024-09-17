<?php
// page_slug
if ( is_front_page() ){
	$page_slug = 'home';
} elseif ( is_home() || is_category() || is_tag() || is_singular( 'post' ) ) {
	$page_slug = 'article';
} elseif ( is_tax() ) {
	$taxonomy = get_query_var( 'taxonomy' );
	$page_slug = get_taxonomy( $taxonomy )->object_type[0];
} elseif ( is_post_type_archive() || is_single() ) {
	$page_slug = get_query_var( 'post_type' );
} elseif ( is_404() ) {
	$page_slug = 'error';
} elseif ( is_search() ) {
	$page_slug = 'search';
} else {
	$page = get_post( get_the_ID() );
	$page_slug = $page->post_name;
}
// META
$site_tit = get_bloginfo( 'name' );
$site_dsc = get_bloginfo( 'description' );
$site_kwd = 'フロントエンドエンジニア,コーダー,コーディング,HTML,CSS,SCSS,Javascript,PHP,WordPress,ポートフォリオ';
if ( is_front_page() ) { //HOME
	$page_tit = $site_tit;
	$page_dsc = $site_dsc;
	$page_kwd = $site_kwd;
} elseif( is_page() && $post->post_parent ) { //子ページ
	// 親を全て取得して配列に登録
	$parents = get_page_parent( $post->post_parent, true, false );
	$parents = array_reverse( $parents );
	$parent_page_tit = '';
	$parent_page_dsc = '';
	$parent_page_kwd = '';
	foreach ($parents as $parent){
		$parent_page_tit .= $parent->post_title . '｜';
		$parent_page_dsc .= $parent->post_title . '｜';
		$parent_page_kwd .= $parent->post_title . ',';
	}
	$page_tit = wp_title( '', 0 ) . '｜' . $parent_page_tit . $site_tit;
	$page_dsc = wp_title( '', 0 ) . '｜' . $parent_page_dsc . $site_dsc;
	$page_kwd = wp_title( '', 0 ) . ',' . $parent_page_kwd . $site_kwd;
} else { //その他
	$page_tit = wp_title( '', 0 ) . '｜' . $site_tit;
	$page_dsc = wp_title( '', 0 ) . '｜' . $site_dsc;
	$page_kwd = wp_title( '', 0 ) . ',' . $site_kwd;
}
//og:type
if ( is_front_page() ) {
	$page_type = 'website';
} else {
	$page_type = 'article';
}
//hd_txt_tag
if ( is_front_page() ) {
	$hd_txt_tag = 'h1';
} else {
	$hd_txt_tag = 'p';
}

//main_tag
if ( is_category() || is_tag() || is_tax() ) {
	$main_tag = 'p';
} else {
	$main_tag = 'h1';
}

//canonical
$site_htp = empty ( $_SERVER["HTTPS"] ) ? "http://" : "https://";
$page_url = $site_htp . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . $_SERVER["QUERY_STRING"];
$page_url = strtok ( $page_url, '?' );

//og:image
$page_image = get_stylesheet_directory_uri(). 'screenshot.png';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width">
	<title><?php echo $page_tit; ?></title>
	<meta name="description" content="<?php echo $page_dsc; ?>">
	<meta name="keywords" content="<?php echo $page_kwd; ?>">
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/common/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/common/apple-touch-icon.png">
	<meta property="og:site_name" content="<?php echo $site_tit; ?>">
	<meta property="og:type" content="<?php echo $page_type; ?>">
	<meta property="og:url" content="<?php echo $page_url; ?>">
	<meta property="og:image" content="<?php echo $page_image; ?>">
	<meta property="og:title" content="<?php echo $page_tit; ?>">
	<meta property="og:description" content="<?php echo $page_dsc; ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo $page_tit; ?>">
	<meta name="twitter:description" content="<?php echo $page_dsc; ?>">
	<meta name="twitter:image" content="<?php echo $page_image; ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/slick.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/slick-theme.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css">
	<link rel="canonical" href="<?php echo $page_url; ?>">
	<?php wp_enqueue_script( 'jquery' ); ?>
	<?php wp_head(); ?>
</head>
<body id="<?php echo $page_slug; ?>" class="js-anime">
<!-- ローディング画面 -->
<div class="loading">
	<div class="loading__logo"></div>
</div>
<div class="js-media-query u-media-query"></div>
<div class="js-nav-overlay nav-overlay"></div>
<div class="l-wrapper">
        <header class="js-header l-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
            <div class="hd-info">
                <div class="hd-info-inner">
                    <h1 class="hd-info__logo js-logo">
                        <a href="/" class="hd-info_logo-link u-alpha">my page</a>
                    </h1>
                    <ul class="js-nav-btn nav-btn">
                        <li class="nav-btn__line"></li>
                        <li class="nav-btn__line"></li>
                        <li class="nav-btn__line"></li>
                    </ul>
                    <nav class="js-nav-content l-nav animated-nav" role="navigation" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
                        <ul class="nav-list">
                            <li class="nav-list__item" itemprop="name">
                                <a class="nav-list__link" itemprop="URL" href="#about">ABOUT</a>
                            </li>
                            <li class="nav-list__item" itemprop="name">
                                <a class="nav-list__link" itemprop="URL" href="#profile">PROFILE</a>
                            </li>
                            <li class="nav-list__item" itemprop="name">
                                <a class="nav-list__link" itemprop="URL" href="#works">WORKS</a>
                            </li>
                            <li class="nav-list__item" itemprop="name">
                                <a class="nav-list__link" itemprop="URL" href="#skill">SKILL</a>
                            </li>
                            <li class="nav-list__item" itemprop="name">
                                <a class="nav-list__link" itemprop="URL" href="#contact">CONTACT</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
		<!-- /.l-header -->
        <div class="l-main-img">
            <picture>
                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/img_main01.webp" type="image/webp">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/img_main01.png" alt="my page">
            </picture>
			<div class="l-main-img-inner">
				<p class="main-txt">my page</p>
			</div>
		</div>
