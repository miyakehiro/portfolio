<?php
/* =====================================================
管理画面
======================================================== */
if ( is_admin() ) {

	/* 固定ページ編集時にビジュアルエディタを非表示に
	/* http://webdesignerwork.jp/wordpress/wordpress_visualeditor/
	------------------------------------------------------------ */
	function disable_visual_editor_in_page(){
		global $typenow;
		if ( $typenow == 'page' ) {
			add_filter( 'user_can_richedit', 'disable_visual_editor_filter' );
		}
	}
	function disable_visual_editor_filter(){
		return false;
	}
	add_action( 'load-post.php', 'disable_visual_editor_in_page' );
	add_action( 'load-post-new.php', 'disable_visual_editor_in_page' );

	/* 管理画面カテゴリ欄の縦幅を伸ばす
	------------------------------------------------------------ */
	function custom_admin_style() {
		?><style>
			.categorydiv div.tabs-panel {max-height:100%;}
		</style><?php
	}
	add_action( 'admin_head','custom_admin_style' );
}
