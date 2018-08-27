<footer>
	<div class="container-fluid  container">
		
		<div class="row  border-bottom  less-padding  onblack-border  bottom-xs">
			<div class="footer-logo  col-xs-12  col-sm-4  start-sm  center-xs  xs2">
				<img class="branded-symbol" src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/woodtechnique_logo_neg.svg" alt="Wood Technique Logotyp Negativ">
			</div>
			<div class="col-xs-12  col-sm-8  end-sm  center-xs">
				<ul class="social-nav--list">
					<li><a class="icon-size--small" target="_blank" href="<?php the_field('instagramlank', 'option'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/instagram_logo.svg"></a></l>
					<li><a class="icon-size--small" target="_blank" href="<?php the_field('facebooklank', 'option'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/facebook_logo.svg"></a></li>
				</ul> 
				<ul class="sub-nav--list">
           <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => false ) ); ?>
         </ul>
			</div>
		</div>
		<div class="row  special-padding">
			<div class="col-xs-12  col-sm-6  center-xs  start-sm">
				<p class="sm-co">© <?php the_time('Y'); ?> Wood Technique AB</p>
			</div>
			<div class="col-xs-12  col-sm-6  center-xs  end-sm">
				<p class="sm-co"><?php the_field('telefonnummer', 'option'); ?> - <a href="mailto:<?php the_field('e-postadress', 'option'); ?>"><?php the_field('e-postadress', 'option'); ?></a> - <a class="to-top" href="#">Till toppen</a></p>
			</div>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>