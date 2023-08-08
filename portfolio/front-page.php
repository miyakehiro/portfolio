<?php get_header(); ?>
<div class="l-contents">
	<main role="main">
        <section id="about" class="home-about sec js-anime-elem">
            <div class="home-about__inner u-inner">
                <h2 class="tit c-tit01">ABOUT</h2>
                <p class="txt">このサイトは、エンジニアミヤケのポートフォリオサイトです。<br>これまで手掛けたwebサイト、自身のスキル・経歴をまとめています。<br>このサイトはエンジニアとしての私を知ってもらうために作りました。<br>このサイトで使用ツールは下記表にまとめています。</p> 
            </div>
        </section>
        <section id="profile" class="home-profile sec js-anime-elem">
            <div class="home-profile__inner u-inner">
                <h2 class="tit c-tit01">PROFILE</h2>
                <div class="home-profile__box">
                    <picture class="img">
                        <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/img_profile01.webp" type="image/webp">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/img_profile01.png" alt="">
                    </picture>
                    <p class="txt">京都出身のエンジニアです。大学卒業、ホームセンターの販売員を早期に退職したのちに<br>職業訓練でwebデザインの基礎を学び、コーディングを主にし、コーダー・フロントエンドエンジニアとして多くのwebサイト製作に携わってきました。</p>
                </div>
                
            </div>
        </section>
        <section id="works" class="home-works sec js-anime-elem">
            <div class="home-works__inner u-inner">
                <h2 class="tit c-tit01">WORKS</h2>    
                <div class="home-works__box">
                    <p class="txt">これまで製作したwebサイトを勤めていた企業別にまとめています。<br>掲載している実績によっては、リニュアルされたり、サイト自体が存在してない場合があります。</p>
                    <?php
                        $taxonomy_slug = 'achievement_cat'; // カスタムタクソノミーのスラッグを指定
                        $post_type_slug = 'achievement'; // 投稿タイプのスラッグを指定
                        $terms = get_terms($taxonomy_slug); // タームを取得
                    ?>
                        <ul class="tab-list">
                            <?php foreach ( $terms as $value ) : ?>
                            <li class="js-switch-tab tab-list-item tab<?php if( $value === reset($terms) ) : ?> is-active<?php endif; ?>">
                                <?php echo esc_html($value->name); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php foreach ( $terms as $value ) : ?>
                        <?php
                            $term_slug = $value->slug;
                            $args = array(
                                'post_type' => $post_type_slug,
                                $taxonomy_slug => $term_slug,
                                'posts_per_page' => -1,
                                'orderby' => 'date',
                                'post_status' => 'publish'
                            );
                            $myquery = new WP_Query( $args );
                        ?>
                            <ul class="js-switch-content js-slider slide-list <?php echo $term_slug; ?><?php if( $value === reset($terms) ) : ?> is-active<?php endif; ?>">
                                <?php if ( $myquery->have_posts()): ?>
                                    <?php while($myquery->have_posts()): $myquery->the_post(); ?>
                                        <li class="slide-list__item">
                                        <?php if( get_field('url') ):?>
                                            <a class="link" href="<?php the_field('url'); ?>" target="_blank">
                                        <?php endif; ?>
                                                <div class="img">
                                                    <?php
                                                        $image_id = get_post_thumbnail_id();
                                                        $image_url = wp_get_attachment_image_src($image_id, 'w200h300');
                                                    ?>
                                                    <?php if($image_id): ?>
                                                        <img src="<?php echo $image_id; ?>" alt="">
                                                    <?php else: ?>
                                                        <img src="https://placehold.jp/400x267.png" alt="">
                                                    <?php endif; ?>
                                                </div>
                                                <h3 class="sub-tit"><?php the_title(); ?></h3>
                                        <?php if( get_field('url') ):?>
                                            </a>
                                        <?php endif; ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                             </ul>
                            <?php wp_reset_postdata(); ?>
                        <?php endforeach; ?>
                </div>            
            </div>
        </section>
        <section id="skill" class="home-skill sec js-anime-elem">
            <div class="home-skill__inner u-inner">
                <h2 class="tit c-tit01">SKILL</h2>
                <div class="home-skill__box">
                    <ul class="list">
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill01.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill01.png" alt="Illustrator">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">Illustrator</h3>
                                <p class="txt">基本的な操作が可能。<br>Illustratorで作成されたwebデザインから画像等を切り出したりしてwebサイトを製作することができます。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill02.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill02.png" alt="Photoshop">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">Photoshop</h3>
                                <p class="txt">基本的な操作が可能。<br>Photoshopで作成されたwebデザインから画像を加工したり、切り出したりしてwebサイトを製作することができます。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill03.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill03.png" alt="XD">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">XD</h3>
                                <p class="txt">基本的な操作が可能。<br>XDで作成されたwebデザインから画像を加工したり、切り出したりしてwebサイトを製作することができます。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill04.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill04.png" alt="DreamWeaver">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">DreamWeaver</h3>
                                <p class="txt">基本的な操作が可能。<br>エディターは主にvs code(Visual Studio Code)を使用しています。DreamWeaverでは、エクセルからHTMLで表を作成する際や画像にリンクを配置するクリッカブルマップの際に使用します。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill05.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill05.png" alt="Visual Studio Code">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">Visual Studio Code</h3>
                                <p class="txt">エメットやスニペットを使用して常に速さと正確さを追及してコーディングするように心掛けています。便利なプラグインがあれば、積極的に使用しています。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill06.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill06.png" alt="HTML5">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">HTML5</h3>
                                <p class="txt">W3Cの規定している記述でマークアップが可能です。またSEOに配慮し、インデントなどが整った見やすいコーディングに心掛けています。コーディングチェックに関しては専用のツールを使用。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill07.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill07.png" alt="CSS3">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">CSS3</h3>
                                <p class="txt">スタイルタグは問題なく、使用できます。デザイン通りに製作できますが、ユーザーが見やすよう、使いやすようにするために提案などして変更することもあります。また他の人が見てすぐ分かるようにクラス名、id名など一定の規則性を持たせて製作しています。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill08.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill08.png" alt="JavaScript">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">JavaScript</h3>
                                <p class="txt">まだまだ勉強が必要で一から製作するのは、まだ難しいですが既存のファイルを変更したり、改造することは可能です。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill09.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill09.png" alt="Sass">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">Sass</h3>
                                <p class="txt">SCSSで製作したファイルをコンパイルしてCSSを圧縮した状態で生成する方法を主に取っています。SCSSのファイル構成はそれぞれのフォルダに格納してインポートして1つのファイルにするようにしています。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill10.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill10.png" alt="jQuery">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">jQuery</h3>
                                <p class="txt">slickやlightboxなど、既に製作されているモノなら、埋め込みや変更することが可能です。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill11.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill11.png" alt="gulp.js">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">gulp.js</h3>
                                <p class="txt">SCSSからCSS、ejsからHTMLにコンパイルしたり、jsや画像ファイル圧縮してファイルサイズを軽くすることを主に使用しています。バージョンに関してはnvmで管理しています。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill12.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill12.png" alt="SEO">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">SEO</h3>
                                <p class="txt">タイトル、ディレクション、キーワード、altタグ等の基本的なSEOに加えて、構造化マークアップ、Google Analyticsやサーチコンソールの登録、使用経験があります。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill13.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill13.png" alt="WordPress">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">WordPress</h3>
                                <p class="txt">サーバーにWordPressをインストールしたり、基本的な操作は可能です。WordPressのPHPも少し触ることが出来、投稿やカスタム投稿の表示や変更なども可能。WordPress使ったサイトも多数製作しました。</p>
                            </div>
                        </li>
                        <li class="list-item">
                            <picture class="img">
                                <source srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill14.webp" type="image/webp">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home/ico_skill14.png" alt="Git">
                            </picture>
                            <div class="txt-box">
                                <h3 class="sub-tit">Git</h3>
                                <p class="txt">複数メンバーでwebサイト製作する際に使用した経験があります。自身でもアカウント作り、勉強中です。このポートフォリオサイトはGitで管理しています。</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="contact" class="home-contact sec js-anime-elem">
            <div class="home-contact__inner u-inner">
                <h2 class="tit c-tit01">CONTACT</h2>
                <div class="home-contact__box c-form01">
                <?php echo do_shortcode('[mwform_formkey key="9"]'); ?>
                </div>
            </div>
        </section>
	</main>
</div>
<!-- /.l-contents -->
<?php get_footer(); ?>
