<?php 
/*
Template Name: Startsida
*/
get_header(); ?>

<section class="hero-intro">
	<div class="hero-slider">

		<?php
		// check if the repeater field has rows of data
		if( have_rows('slider') ):
		// loop through the rows of data
		while ( have_rows('slider') ) : the_row(); ?>

		<div class="start-hero--slide">
			<img src="<?php the_sub_field('bild'); ?>">
			<div class="hero-content">
				<div class="hero-intro-text  hero-center">
					<p class="hero-title  balance-text  white"><?php the_sub_field('rubrik'); ?></p>
					<p class="hero-description  white"><?php the_sub_field('text'); ?></p>
					<a class="btn  ib  btn-1  btn-1e" href="<?php the_sub_field('lank'); ?>"><?php the_sub_field('knapptext'); ?></a>
				</div>
			</div>
		</div>

		<?php endwhile;

	    else :

	        // no rows found

	    endif;

	  ?>

	</div>
</section>

<section class="content">

	<div class="container-fluid  container">

		<div class="row  border-bottom  onwhite-border">
			<?php
			// check if the repeater field has rows of data
			if( have_rows('puffar') ):
			// loop through the rows of data
			while ( have_rows('puffar') ) : the_row(); ?>
			<div class="col-xs-12  col-sm-12  col-md-4  cta-item  xs2">
				<img src="<?php the_sub_field('bild'); ?>">
				<?php the_sub_field('text'); ?>
			</div>
			<?php endwhile;

	    else :

	        // no rows found

	    endif;

	  	?>
		</div>

		<div class="row  no-pb  middle-sm  center-sm">
			<div class="col-xs-12  col-sm-6  cta-item">
				<img src="<?php the_field('bild_1'); ?>">
			</div>
			<div class="col-xs-12  col-sm-6  cta-item">
				<?php the_field('text_1'); ?>
			</div>
		</div>

		<div class="row  middle-sm  center-sm">
			<div class="col-xs-12  col-sm-6  cta-item  order-last">
				<?php the_field('text_2'); ?>
			</div>
			<div class="col-xs-12  col-sm-6  cta-item  order-first">
				<img src="<?php the_field('bild_2'); ?>">
			</div>
		</div>

	</div>

</section>

<?php get_footer(); ?>