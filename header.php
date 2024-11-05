<!DOCTYPE html>
<html>
  <head <?php language_attributes(); ?>>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php the_title(); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
  </head>
  <body>
    <div>
      <header>
      <?php 
wp_nav_menu ( array (
 'theme_location' => 'header-menu' 
 ) ); ?>
      </header>