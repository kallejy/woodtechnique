<?php
/*
Template for displaying a standard page
*/

get_header(); ?>

<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

<section class="hero-sub-page" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat #0B3662; background-size: cover; background-position: center;">
      <div class="container-fluid  container">
        <div class="row  hero-sub">
          <div class="col-xs-12">
            <h1 class="hero-sub  white"><?php the_title(); ?></h1>
          </div>
        </div>
      </div>
</section>

<section class="content">

  <div class="container-fluid  container">
    
    <div class="row">
      <div class="col-xs-12  col-sm-8  editable">
        <?php if (have_posts()) : while (have_posts()) : the_post();
                the_content();
            endwhile; endif; ?>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>