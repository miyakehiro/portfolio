<?php
/* =====================================================
<head>内
======================================================== */

/* 不要タグ削除
------------------------------------------------------------ */
remove_action( 'wp_head', 'feed_links', 2 ); //サイト全体のfeed
remove_action( 'wp_head', 'feed_links_extra', 3 ); //その他のfeed
remove_action( 'wp_head', 'rsd_link' ); //Really Simple Discovery Link
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer Link
remove_action( 'wp_head', 'rel_canonical' ); //canonical
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); //前後の記事 Link
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); //Short Link
remove_action( 'wp_head', 'wp_generator' ); //WP version
remove_action( 'wp_head', 'print_emoji_detection_script', 7  ); //emoji JS
remove_action( 'wp_print_styles', 'print_emoji_styles'  ); //emoji CSS
remove_action( 'wp_head', 'rest_output_link_wp_head' ); //Embed Link
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); //Embed Link
remove_action( 'wp_head', 'wp_oembed_add_host_js' ); //Embed JS
remove_action( 'template_redirect', 'rest_output_link_header', 11 ); //Embed HTTP Response Header
//dns-prefetch
function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

/* wp_titleの$sepが空文字または半角スペースの場合は余分な空白削除
/* http://yumeneko.pmfan.jp/wordpress/wp-technique/trap-wp_title-function.html
------------------------------------------------------------ */
function my_title_fix( $title, $sep, $seplocation ) {
	if( !$sep || $sep == " " ) {
		$title = str_replace( ' ' . $sep . ' ', $sep, $title );
	}
	return $title;
}
add_filter( 'wp_title', 'my_title_fix', 10, 3 );

/* カスタム分類のラベルをwp_titleから削除
/* 例）<title><?php wp_title(''); ?>｜<?php bloginfo('name'); ?></title>
/* https://monoxa.net/2015/10/how-to-hide-a-custom-category-name-to-wp-title/
------------------------------------------------------------ */
function remove_tax_name( $title, $sep, $seplocation ) {
	if ( is_tax() ) {
		$term_title = single_term_title( '', false );
		if ( 'right' == $seplocation ) {
			$title = $term_title . " $sep ";
		} else {
			$title = " $sep " . $term_title;
		}
	}
	return $title;
}
add_filter( 'wp_title', 'remove_tax_name', 10, 3 );
