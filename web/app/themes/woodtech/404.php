<?php
/*
Template for displaying 404
*/

get_header(); ?>

<section class="hero-sub-page">
      <div class="container-fluid  container">
        <div class="row  hero-sub">
          <div class="col-xs-12">
            <h1 class="white">Felkod: 404</h1>
          </div>
        </div>
      </div>
</section>

<section class="content">

  <div class="container-fluid  container">
    
    <div class="row">
      <div class="col-xs-12  col-sm-8  editable">
        <h2>404 - Sidan kan inte hittas</h2>
        <p>Kanske har den aldrig ens existerat, eller så har den tagits bort. Prova med någonting annat! Saknar du något innehåll? Kontakta oss.</p>
      </div>
      <div class="col-xs-12  col-sm-4  col-md-3  col-md-offset-1">
          <?php dynamic_sidebar( 'sidebar' ); ?>
      </div>
    </div>

  </div>

</section>

<?php get_footer(); ?>