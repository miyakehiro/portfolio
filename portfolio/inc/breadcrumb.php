<?php
	//path
	$home_url = home_url();
	$theme_url = get_stylesheet_directory_uri();
?>
<div class="l-breadcrumb u-view-pc">
	<ol class="breadcrumb-list u-inner">
		<li class="breadcrumb-list__item"><a class="breadcrumb-list__link" href="<?php echo $home_url; ?>">TOP</a></li>
		<?php if ( is_home() ) : //投稿 ?>
			<li class="breadcrumb-list__item">記事一覧</li>
		<?php elseif ( is_category() ) : //カテゴリ ?>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/article/" class="breadcrumb-list__link">記事一覧</a></li>
			<li class="breadcrumb-list__item"><?php single_cat_title(); ?></li>
		<?php elseif ( is_tag() ) : //タグ ?>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/article/" class="breadcrumb-list__link">記事一覧</a></li>
			<li class="breadcrumb-list__item"><?php single_tag_title(); ?></li>
		<?php elseif ( is_singular('post') ) : $cat = get_the_category(); $cat = $cat[0]; //投稿記事 ?>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/article/" class="breadcrumb-list__link">記事一覧</a></li>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/article/<?php echo $cat->slug; ?>/" class="breadcrumb-list__link"><?php echo $cat->name; ?></a></li>
			<li class="breadcrumb-list__item"><?php the_title( '' ); ?></li>
		<?php elseif ( is_post_type_archive() ) : //カスタム投稿アーカイブ ?>
			<li class="breadcrumb-list__item"><?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?></li>
		<?php elseif ( is_tax() ) : $terms = get_the_terms( $post->ID, '' . get_post_type() . '_cat' ); $term = $terms[0]; //カスタム投稿タクソノミーアーカイブ ?>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/<?php $taxonomy = get_query_var( 'taxonomy' ); echo get_taxonomy( $taxonomy )->object_type[0]; ?>/" class="breadcrumb-list__link"><?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?></a></li>
			<li class="breadcrumb-list__item"><?php single_cat_title(); ?></li>
		<?php elseif ( is_singular() && !is_page() ) : $terms = get_the_terms( $post->ID, '' . get_post_type() . '_cat' ); $term = $terms[0]; //カスタム投稿記事 ?>
			<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/" class="breadcrumb-list__link"><?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?></a></li>
			<?php if($terms): ?>
				<li class="breadcrumb-list__item"><a href="<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/<?php echo $term->slug; ?>/" class="breadcrumb-list__link"><?php echo $term->name; ?></a></li>
			<?php endif; ?>
			<li class="breadcrumb-list__item"><?php the_title( '' ); ?></li>
		<?php elseif ( is_page() && $post->post_parent ) : //子ページ ?>
			<?php
				// 親を全て取得して配列に登録
				$parents = get_page_parent( $post->post_parent, true, false );
				foreach ($parents as $parent):
			?>
				<?php if( $parent->post_status === 'private' || $parent->post_status === 'draft' || $parent->post_status === 'pending' ): //非公開・下書き・レビュー待ち ?>
					<li class="breadcrumb-list__item"><?php echo $parent->post_title; ?></li>
				<?php else: //公開 ?>
					<?php $url = get_page_link( $parent->ID ); ?>
					<li class="breadcrumb-list__item"><a href="<?php echo $url; ?>" class="breadcrumb-list__link"><?php echo $parent->post_title; ?></a></li>
				<?php endif; ?>
			<?php endforeach; ?>
			<li class="breadcrumb-list__item"><?php wp_title( '' ); ?></li>
		<?php else: //その他ページ ?>
			<li class="breadcrumb-list__item"><?php wp_title( '' ); ?></li>
		<?php endif; ?>
	</ol>
</div>
<!-- /#breadcrumb -->
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "BreadcrumbList",
	"itemListElement": [
		{
			"@type": "ListItem",
			"position": 1,
			"item": {
				"@id": "<?php echo $home_url; ?>",
				"name": "HOME"
			}
		},
		<?php if ( is_home() ) : //投稿 ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/article/",
				"name": "記事一覧"
			}
		}
		<?php elseif ( is_category() ) : //カテゴリ ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/article/",
				"name": "記事一覧"
			}
		},
		{
			"@type": "ListItem",
			"position": 3,
			"item": {
				"@id": "<?php echo get_category_link($cat); ?>",
				"name": "<?php single_cat_title(); ?>"
			}
		}
		<?php elseif ( is_tag() ) : //タグ ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/article/",
				"name": "記事一覧"
			}
		},
		{
			"@type": "ListItem",
			"position": 3,
			"item": {
				"@id": "<?php echo get_tag_link($tag); ?>",
				"name": "<?php single_cat_title(); ?>"
			}
		}
		<?php elseif ( is_tax() ) : //カスタム投稿タクソノミーアーカイブ ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/<?php $taxonomy = get_query_var( 'taxonomy' ); echo get_taxonomy( $taxonomy )->object_type[0]; ?>/",
				"name": "<?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?>"
			}
		},
		{
			"@type": "ListItem",
			"position": 3,
			"item": {
				"@id": "<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/<?php echo $term->slug; ?>/",
				"name": "<?php single_cat_title(); ?>"
			}
		}
		<?php elseif ( is_singular('post') ) : $cat = get_the_category(); $cat = $cat[0]; //投稿記事 ?> ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/article/",
				"name": "記事一覧"
			}
		},
		{
			"@type": "ListItem",
			"position": 3,
			"item": {
				"@id": "<?php echo $home_url; ?>/article/<?php echo $cat->slug; ?>/",
				"name": "<?php echo $cat->name; ?>"
			}
		},
		{
			"@type": "ListItem",
			"position": 4,
			"item": {
				"@id": "<?php the_permalink(); ?>",
				"name": "<?php the_title( '' ); ?>"
			}
		},
		<?php elseif ( is_post_type_archive() ) : //カスタム投稿アーカイブ ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/",
				"name": "<?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?>"
			}
		}
		<?php elseif ( is_singular() && !is_page() ) : $parents_count = 3; //カスタム投稿記事 ?>
		{
			"@type": "ListItem",
			"position": 2,
			"item": {
				"@id": "<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/",
				"name": "<?php echo esc_html( get_post_type_object( get_post_type() )->label ); ?>"
			}
		},
		<?php if($terms): //タクソノミーがある場合 ?>
		{
			"@type": "ListItem",
			"position": <?php echo $parents_count; ?>,
			"item": {
				"@id": "<?php echo $home_url; ?>/<?php echo get_post_type(); ?>/<?php echo $term->slug; ?>/",
				"name": "<?php echo $term->name; ?>"
			}
		},
		<?php $parents_count++; endif; ?>
		{
			"@type": "ListItem",
			"position": <?php echo $parents_count; ?>,
			"item": {
				"@id": "<?php the_permalink(); ?>",
				"name": "<?php the_title(); ?>"
			}
		}
		<?php elseif ( is_page() && $post->post_parent ) : //子ページ ?>
			<?php
				// 親を全て取得して配列に登録
				$parents = get_page_parent( $post->post_parent, true, false );
				// カウンター
				$parents_count = 2;
				foreach ( $parents as $parent ):
					$url = get_page_link( $parent->ID );
			?>
				{
					"@type": "ListItem",
					"position": <?php echo $parents_count; ?>,
					"item": {
						"@id": "<?php echo $url; ?>",
						"name": "<?php echo $parent->post_title; ?>"
					}
				},
			<?php
				$parents_count++;
				endforeach;
			?>
		{
			"@type": "ListItem",
			"position": <?php echo $parents_count; ?>,
			"item": {
				"@id": "<?php the_permalink(); ?>",
				"name": "<?php wp_title( '' ); ?>"
			}
		}
		<?php else: //その他ページ ?>
		{
			"@type": "ListItem",
			"position": 3,
			"item": {
				"@id": "<?php the_permalink(); ?>",
				"name": "<?php wp_title( '' ); ?>"
			}
		}
		<?php endif; ?>
	]
}
</script>
