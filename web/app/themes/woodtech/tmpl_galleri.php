<?php
/*
Template Name: Standard gallerisida m. sidebar
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
      <div class="col-xs-12  col-sm-8">
      <?php if (have_posts()) : while (have_posts()) : the_post();
        the_content(); 

      // Check for image-pages
      $args = array(
        'post_type' => 'page',
        'post_parent' => get_the_ID(),
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
      );

      $the_query = new WP_Query( $args ); ?>

      <?php if ( $the_query->have_posts() ) : ?>

      <div class="row  no-top">

      <!-- the loop -->
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <div class="col-xs-6 col-sm-4 col-md-3  gallery-link-item">
          <a href="<?php the_permalink(); ?>">
            <?php           
              if ( has_post_thumbnail() ) {
                  the_post_thumbnail('thumbnail');
              }           
            ?>
            <h5><?php the_title(); ?></h5>
          </a>
        </div>
      <?php endwhile; ?>

      </div>
      <?php endif; 
      wp_reset_postdata(); 

      ?>
      <!-- end of the loop -->

      <?php endwhile; endif; ?>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>