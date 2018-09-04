<?php
/*
Template for displaying news
*/

get_header(); ?>

<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

<section class="hero-sub-page  news-bg">
      <div class="container-fluid  container">
        <div class="row  hero-sub">
          <div class="col-xs-12">
            <h1 class="hero-sub  white">Nyheter</h1>
          </div>
        </div>
      </div>
</section>

<section class="content">

  <div class="container-fluid  container">
    
    <div class="row">
      <div class="col-xs-12  col-sm-8  editable">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="col-xs-12 content-item">
          <a href="<?php the_permalink(); ?>">
            <?php
            if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            the_post_thumbnail( 'full' );
            } ?>
            <h3 class="news-title"><?php the_title(); ?></h3>
            <p class="sm-co">Publicerad <?php the_time('Y-m-d'); ?> av <?php the_author(); ?></p>
            <p class="limit-two-rows  t-mb1"><?php echo excerpt(50); ?></p>
            <a class="link-arrow" href="<?php the_permalink(); ?>"><?php echo __('Läs hela nyheten',"starttheme"); ?></a>
          </a>
        </div>
      <?php endwhile; endif; ?>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>