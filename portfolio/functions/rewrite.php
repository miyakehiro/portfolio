<?php
/* =====================================================
リライト
======================================================== */

/* パーマリンク「/taxonomy/」削除
/* http://yumeneko.pmfan.jp/wordpress/plugins/custom-post-custom-taxonomy.html
------------------------------------------------------------ */
function my_custom_post_type_permalinks_set( $termlink, $term, $taxonomy ) {
    return str_replace( '/' . $taxonomy . '/', '/', $termlink );
}
add_filter( 'term_link', 'my_custom_post_type_permalinks_set', 11, 3 );

/* タクソノミのリライトルールを追加
/* http://www.codamac.jp/blog/custom-taxonomy-404/
------------------------------------------------------------ */
// item
add_rewrite_rule( 'item/([^/]+)/?$', 'index.php?item_cat=$matches[1]', 'top' );
add_rewrite_rule( 'item/([^/]+)/page/([0-9]+)/?$', 'index.php?item_cat=$matches[1]&paged=$matches[2]', 'top' );
// news
add_rewrite_rule( 'news/([^/]+)/?$', 'index.php?news_cat=$matches[1]', 'top' );
add_rewrite_rule( 'news/([^/]+)/page/([0-9]+)/?$', 'index.php?news_cat=$matches[1]&paged=$matches[2]', 'top' );
// faq
add_rewrite_rule( 'faq/([^/]+)/?$', 'index.php?faq_cat=$matches[1]', 'top' );
add_rewrite_rule( 'faq/([^/]+)/page/([0-9]+)/?$', 'index.php?faq_cat=$matches[1]&paged=$matches[2]', 'top' );
