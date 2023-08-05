<?php
/* =====================================================
その他設定
======================================================== */

/* srcset属性を無効化
/* http://increment-log.com/wordpress-disabling-responsive-images/
------------------------------------------------------------ */
add_filter( 'wp_calculate_image_srcset', '__return_false' );

/* カスタム投稿etcでもアイキャッチを有効化
------------------------------------------------------------ */
add_theme_support( 'post-thumbnails' );

/* トリミングサイズ設定　※'w幅h高さ'で指定する。コメントアウトでアスペクト比も書く。
------------------------------------------------------------ */
add_image_size( 'w200h300', 200, 300, true ); //2:3

/* メインクエリのカスタマイズ（投稿タイプ・タクソノミーごとに表示件数を変更する。ページ送りがある時に使用）
/* https://dev-memo.com/php/pre-get-posts
------------------------------------------------------------ */
function custom_main_query($query) {
	if (is_admin() || !$query->is_main_query()) {
		return;
	}
	if ($query->is_home()) { //投稿
		return;
	}
	if ($query->is_post_type_archive('achievement')) { //カスタム投稿
		$query->set('posts_per_page', 1); //表示件数
	}
	if ($query->is_tax('achievement_cat')) { //タクソノミ
		$query->set('posts_per_page', 1); //表示件数
	}
}
add_action('pre_get_posts', 'custom_main_query');

// global-styles-inline-cssを無効化
function remove_global_styles_inline_css() {
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_print_styles', 'remove_global_styles_inline_css' );
