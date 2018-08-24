<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <!--
    Designed & Developed by Fem punkter (@fempunkter)
    http://fempunkter.se
  -->
  <meta charset="utf-8">
  <meta http-equiv=X-UA-Compatible content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="format-detection" content="telephone=no">
  <title><?php wp_title();?></title>
  <link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/assets/img/favicon.png">
  <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" media="all">
  <link href="https://fonts.googleapis.com/css?family=Sorts+Mill+Goudy:400,400i|Montserrat:400,400i,500,700,700i" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-fixed-width">

<header id="header">
  <div class="header-bg-fix"></div>
  <div class="container-fluid  container  resize">
    <div class="row  row-header">
      <div class="main-logo  col-xs-8  col-sm-4">
        <a href="<?php echo home_url(); ?>" class="logo">
          <img src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/bullerbybatklubb_logo.png" alt="Bullerby Båtklubb logotyp">
        </a>
      </div>
      <nav class="main-nav  col-xs-12  col-sm-12  col-md-8  end-md  relative  resize">
        <input class="toggle" id="toggle" value="menu" type="checkbox">
        <label for="toggle"><div class="burger  end-sm"></div><p>Meny</p></label>
        <ul class="main-nav--list">
          <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false ) ); ?>
        </ul>
        <ul class="main-social-nav--list">
          <li><a class="icon-size--small  login" href="<?php echo home_url(); ?>/medlemslogin/">Medlemslogin</a></li>
          <li><a class="icon-size--small  file" href="<?php echo home_url(); ?>/dokument/">Dokument</a></li>
          <li><a class="icon-size--small  file-upload" href="<?php echo home_url(); ?>/ladda-upp/">Ladda upp</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>