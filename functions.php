<?php
// vignettes
add_theme_support( 'post-thumbnail' );
add_theme_support( 'post-thumbnails' );
// menus

function theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('dm-sans-font', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap', false);
  }
  add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

