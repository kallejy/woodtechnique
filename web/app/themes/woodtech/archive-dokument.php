<?php
/*
Template for displaying dokument
*/

get_header(); ?>

<section class="hero-sub-page  news-bg">
      <div class="container-fluid  container">
        <div class="row  hero-sub">
          <div class="col-xs-12">
            <h1 class="hero-sub  white">Dokument</h1>
          </div>
        </div>
      </div>
</section>

<section class="content">

  <div class="container-fluid  container">
    <?php
    if ( is_user_logged_in() ) { ?>
    <div class="row">
      <div class="col-xs-12  col-sm-8">
        <h2>Senast uppladdade dokument</h2>
        <p>Här visas de senast uppladdade dokumenten.</p>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="col-xs-12  file-item">
          <?php
          $file = get_field('fil');
          if( $file ): ?>
          <a class="file-pdf" href="<?php echo $file['url']; ?>" download><?php the_title(); ?></a>
          <?php endif; ?>
        </div>
      <?php endwhile; endif; ?>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>  
    <?php }
     else { ?>
    <div class="row">
      <div class="col-xs-12  col-sm-8  editable">
        <h2>Senast uppladdade dokument</h2>
        <p>Detta innehåll är endast tillgängligt för inloggade medlemmar.</p>
        <p>För att logga in, använd formuläret till höger. Som inloggad medlem har du möjlighet att ta del av dokument och ladda upp bilder från olika klubbträffar.</p>

        <h4>Vill du bli medlem?</h4>
        <p>Ansökningsförfarande finns <a href="<?php echo home_url(); ?>/ansokan/">här</a>.</p>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>
    <?php }
    ?>

  </div>

</section>

<?php get_footer(); ?>