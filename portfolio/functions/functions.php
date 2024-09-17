<?php
/* =====================================================
追加関数
======================================================== */

/* 親ページと子ページをスラッグで判定
/* http://qiita.com/thanks2music@github/items/5ee9151592d35eef3bd1
------------------------------------------------------------ */
function is_parent_slug() {
	global $post;
	if ( $post->post_parent ) {
		$post_data = get_post( $post->post_parent );
		return $post_data->post_name;
	}
}

/* 非公開や下書きの固定ページを親ページに設定できるようにする
/* http://kachibito.net/wp-code/add-private-draft
------------------------------------------------------------ */
add_filter('page_attributes_dropdown_pages_args', 'add_private_draft');
function add_private_draft($args) {
	$args['post_status'] = 'publish,private,draft';
	return $args;
}

/* 固定ページの親を全て取得して配列にする
/* https://securavita.net/wordpress-get-page-parent/
------------------------------------------------------------ */
function get_page_parent( $parent_id , $object = true , $root = true ) {
	//parent_idが0の場合何もしない
	if( $parent_id == false ) {
		return false;
	}
	if( $object == true ) { //返り値がpostオブジェクト
		while( $parent_id ) {
			$page = get_post( $parent_id );
			$result[] = $page;
			$parent_id = $page->post_parent;
		}
	} else { //返り値がpostID
		while( $parent_id ) {
			$page_id = get_post_field( 'post_parent' , $parent_id );
			$result[] = $parent_id;
			$parent_id = $page_id;
		}
	}
	//配列を逆順に(rootを0に)
	$result = array_reverse( $result );
	//rootがtureの場合0番目(rootページのみ)をセット
	if( $root == true) {
		$result = $result[0];
	}
	return $result;
}



/* prism.jsのコード挿入ボタンを、テキストエディタに追加する
/* https://yumanoblog.com/prismjs-wordpress/
------------------------------------------------------------ */
function add_shortcode_quicktags() {
  if ( wp_script_is('quicktags') ) :
?>
  <script>
    QTags.addButton( 'prism_shortcode', 'prism', '<pre class="line-numbers"><code class="language-markup"></code></pre>' );
    QTags.addButton( 'left_arrow_shortcode', '<', '＆lt;' );
    QTags.addButton( 'right_arrow_shortcode', '>', '＆gt;' );
    QTags.addButton( 'two_arrow_shortcode', '<>', '＆lt;＆gt;' );
  </script>
<?php
  endif;
}
add_action( 'admin_print_footer_scripts', 'add_shortcode_quicktags' );

function five_posts_on_homepage( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', '5' );
    }
}
add_action( 'pre_get_posts', 'five_posts_on_homepage' );

/**
* ページネーションHTML出力
*
*https://www.warna.info/archives/723/
*https://kaminarimagazine.com/web/2019/07/26/%e3%82%b3%e3%83%94%e3%83%9a%e3%81%a7%e7%b0%a1%e5%8d%98%ef%bc%81wordpress%e3%81%a7%e3%82%a2%e3%83%bc%e3%82%ab%e3%82%a4%e3%83%96%e3%83%9a%e3%83%bc%e3%82%b8%e3%81%ae%e3%83%9a%e3%83%bc%e3%82%b8%e3%83%a3/
*/
function page_navi( $args = '' ) {
    global $wp_query;

    if ( ! ( is_archive() || is_home() || is_search() ) ) { return; }
    $default = array(
        'items'             => 11,
        'show_adjacent'     => true,
        'prev_label'        => '&lt;',
        'next_label'        => '&gt;',
        'show_boundary'     => true,
        'first_label'       => '&laquo;',
        'last_label'        => '&raquo;',
        'show_num'          => false,
        'num_position'      => 'before',
        'num_format'        => '<span>%d/%d</span>',
        'echo'              => true,
        'navi_element'      => '',
        'elm_class'         => 'c-pager01',
        'elm_id'            => '',
        'li_class'          => '',
        'current_class'     => 'current',
        'current_format'    => '<span>%d</span>',
        'class_prefix'      => '',
        'indent'            => 0
    );
    $default = apply_filters( 'page_navi_default', $default );

    $args = wp_parse_args( $args, $default );

    $max_page_num = $wp_query->max_num_pages;
    $current_page_num = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    $elm = in_array( $args['navi_element'], array( 'nav', 'div', '' ) ) ? $args['navi_element'] : 'div';

    $args['items'] = absint( $args['items'] ) ? absint( $args['items'] ) : $default['items'];
    $args['elm_id'] = is_array( $args['elm_id'] ) ? $default['elm_id'] : $args['elm_id'];
    $args['elm_id'] = preg_replace( '/[^\w_-]+/', '', $args['elm_id'] );
    $args['elm_id'] = preg_replace( '/^[\d_-]+/', '', $args['elm_id'] );

    $args['class_prefix'] = is_array( $args['class_prefix'] ) ? $default['class_prefix'] : $args['class_prefix'];
    $args['class_prefix'] = preg_replace( '/[^\w_-]+/', '', $args['class_prefix'] );
    $args['class_prefix'] = preg_replace( '/^[\d_-]+/', '', $args['class_prefix'] );

    $args['elm_class'] = sanitize_attr_classes( $args['elm_class'], $args['class_prefix'] );
    $args['li_class'] = sanitize_attr_classes( $args['li_class'], $args['class_prefix'] );
    $args['current_class'] = sanitize_attr_classes( $args['current_class'], $args['class_prefix'] );
    $args['current_class'] = $args['current_class'] ? $args['current_class'] : $default['current_class'];



    $tabs = str_repeat( "\t", (int)$args['indent'] );
    $elm_tabs = '';

    $befores = $current_page_num - floor( ( $args['items'] - 1 ) / 2 );
    $afters = $current_page_num + ceil( ( $args['items'] - 1 ) / 2 );

    if ( $max_page_num <= $args['items'] ) {
        $start = 1;
        $end = $max_page_num;
    } elseif ( $befores <= 1 ) {
        $start = 1;
        $end = $args['items'];
    } elseif ( $afters >= $max_page_num ) {
        $start = $max_page_num - $args['items'] + 1;
        $end = $max_page_num;
    } else {
        $start = $befores;
        $end = $afters;
    }

    $elm_attrs = '';
    if ( $args['elm_id'] ) {
        $elm_attrs = ' id="' . $args['elm_id'] . '"';
    }
    if ( $args['elm_class'] ) {
        $elm_attrs .= ' class="' . $args['elm_class'] . '"';
    }
/**ページ総数
*    $num_list_item = '';
*    if ( $args['show_num'] ) {
*        $num_list_item = '<li class="page_nums';
*        if ( $args['li_class'] ) {
*            $num_list_item .= ' ' . $args['li_class'];
*        }
*        $num_list_item .= '">' . sprintf( $args['num_format'], $current_page_num, $max_page_num ) . "</li>\n";
*    }
*/
    $page_navi = '';
    if ( $elm ) {
        $elm_tabs = "\t";
        $page_navi = $tabs . '<' . $elm;
        if ( $elm_attrs ) {
            $page_navi .= $elm_attrs . ">\n";
        }
    }

    $page_navi .= $elm_tabs . $tabs . '<ul';
    if ( ! $elm && $elm_attrs ) {
        $page_navi .= $elm_attrs;
    }
    $page_navi .= ">\n";

    if ($args['num_position'] != 'after' && $num_list_item ) {
        $page_navi .= "\t" . $elm_tabs . $tabs . $num_list_item;
    }
    if ( $args['show_boundary'] ) {
        $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'first';
        if ( $args['li_class'] ) {
            $page_navi .= ' ' . $args['li_class'];
        }
        $page_navi .= '"><a href="' . get_pagenum_link() . '">' . esc_html( $args['first_label'] ) . '</a></li>' . "\n";
    }

    if ( $args['show_adjacent'] ) {
        $previous_num = max( 1, $current_page_num - 1 );
        $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'previous';
        if ( $args['li_class'] ) {
            $page_navi .= ' ' . $args['li_class'];
        }
        $page_navi .= '"><a href="' . get_pagenum_link( $previous_num ) . '">' . esc_html( $args['prev_label'] ) . '</a></li>' . "\n";
    }

    for ( $i = $start; $i <= $end; $i++ ) {
        $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="';
        if ( $i == $current_page_num ) {
            $page_navi .= $args['current_class'];
            if ( $args['li_class'] ) {
                $page_navi .= ' ' . $args['li_class'];
            }
            $page_navi .= '">' . sprintf( $args['current_format'], $i ) . "</li>\n";
        } else {
            $delta = absint( $i - $current_page_num );
            $b_f = $i < $current_page_num ? 'before' : 'after';
            $page_navi .= $args['class_prefix'] . $b_f . ' ' . $args['class_prefix'] . 'delta-' . $delta;
            if ( $i == $start ) {
                $page_navi .= ' ' . $args['class_prefix'] . 'head';
            } elseif ( $i == $end ) {
                $page_navi .= ' ' . $args['class_prefix'] . 'tail';
            }
            if ( $args['li_class'] ) {
                $page_navi .= ' ' . $args['li_class'] . '"';
            }
            $page_navi .= '"><a href="' . get_pagenum_link( $i ) . '">' . $i . "</a></li>\n";
        }
    }


    if ( $args['show_adjacent'] ) {
        $next_num = min( $max_page_num, $current_page_num + 1 );
        $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'next';
        if ( $args['li_class'] ) {
            $page_navi .= ' ' . $args['li_class'];
        }
        $page_navi .= '"><a href="' . get_pagenum_link( $next_num ) . '">' . esc_html( $args['next_label'] ) . '</a></li>' . "\n";
    }



    if ( $args['show_boundary'] ) {
        $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'last';
        if ( $args['li_class'] ) {
            $page_navi .= ' ' . $args['li_class'];
        }
        $page_navi .= '"><a href="' . get_pagenum_link( $max_page_num ) . '">' . esc_html( $args['last_label'] ) . '</a></li>' . "\n";
    }

    if ($args['num_position'] == 'after' && $num_list_item ) {
        $page_navi .= "\t" . $elm_tabs . $tabs . $num_list_item;
    }

    $page_navi .= $elm_tabs . $tabs . "</ul>\n";

    if ( $elm ) {
        $page_navi .= $tabs . '</' . $elm . ">\n";
    }

    $page_navi = apply_filters( 'page_navi', $page_navi );

    if ( $args['echo'] ) {
        echo $page_navi;
    } else {
        return $page_navi;
    }
}


function sanitize_attr_classes( $classes, $prefix = '' ) {
    if ( ! is_array( $classes ) ) {
        $classes = preg_replace( '/[^\s\w_-]+/', '', $classes );
        $classes = preg_split( '/[\s]+/', $classes );
    }

    foreach ( $classes as $key => $class ) {
        if ( is_array( $class ) ) {
            unset( $classes[$key] );
        } else {
            $class = preg_replace( '/[^\w_-]+/', '', $class );
            $class = preg_replace( '/^[\d_-]+/', '', $class );
            if ( $class ) {
                $classes[$key] = $prefix . $class;
            }
        }
    }
    $classes = implode( ' ', $classes );

    return $classes;
}

