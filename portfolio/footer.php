<div class="js-pagetop ft-pagetop"><a class="ft-pagetop_link u-alpha" href="#top"></a></div>
<footer class="js-footer l-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
	<div class="ft-content">
		<div class="ft-content__inner">
			<ul class="ft-content-nav">
				<li class="ft-content-nav__item">	
					<a href="about" class="ft-content-nav__item-link">ABOUT</a>	
				</li>
				<li class="ft-content-nav__item">	
					<a href="#profile" class="ft-content-nav__item-link">PROFILE</a>	
				</li>
				<li class="ft-content-nav__item">	
					<a href="#works" class="ft-content-nav__item-link">WORKS</a>	
				</li>
				<li class="ft-content-nav__item">	
					<a href="#skill" class="ft-content-nav__item-link">SKILL</a>	
				</li>
				<li class="ft-content-nav__item">	
					<a href="#contact" class="ft-content-nav__item-link">CONTACT</a>	
				</li>
			</ul>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/common.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/animation.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/slick.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/ajaxzip3.js"></script>
<script type="text/javascript">
	$(function () {
		function sliderSetting(){
			const width = $(window).width();
			if(width <= 600){
				$('.js-slider').slick({
					arrows: true,
					dots: true, 
					autoplay: true,
					speed: 1500,
					slidesToShow: 1,
					centerMode: true,
					centerPadding: '30px',
				});
			}
				$('.tab-list > li').click(function () {
				$('.js-slider').slick('setPosition');
			});
		}
		sliderSetting();
		$(window).resize(function(){
			sliderSetting();
		});
	});
</script>
<script type="text/javascript">
jQuery(function( $ ) {
    jQuery( '#zip' ).keyup( function( e ) {
        AjaxZip3.zip2addr(this,'','prefecture','address1');
    } )
} );
</script>
</body>
</html>
