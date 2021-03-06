<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <!--
    Designed & Developed by Fem punkter (@fempunkter)
    https://fempunkter.se
  -->
  <meta charset="utf-8">
  <meta http-equiv=X-UA-Compatible content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="format-detection" content="telephone=no">
  <title><?php wp_title();?></title>
  <link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/assets/img/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700|Montserrat:400,400i,500,700,700i" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128516288-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-128516288-1');
  </script>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-fixed-width">

<header id="header">
  <div class="header-bg-fix"></div>
  <div class="container-fluid  container  resize">
    <div class="row  row-header">
      <div class="main-logo  col-xs-8  col-sm-4  col-md-3">
        <a href="<?php echo home_url(); ?>" class="logo">
          <img src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/wexio_tooling_logotyp_org.svg" alt="Wexiö Tooling Logotyp">
        </a>
      </div>
      <nav class="main-nav  col-xs-12  col-sm-12  col-md-9  end-md  relative  resize">
        <input class="toggle" id="toggle" value="menu" type="checkbox">
        <label for="toggle"><div class="burger  end-sm"></div><p>Meny</p></label>
        <?php if ( has_nav_menu( 'main-menu' ) ) { ?>
        <ul class="main-nav--list">
          <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false ) ); ?>
        </ul>
        <?php }
        if ( has_nav_menu( 'top-menu' ) ) { ?>
        <ul class="top-nav--list">
          <?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'container' => false ) ); ?>
        </ul>
        <?php } ?>
      </nav>
    </div>
  </div>
</header>