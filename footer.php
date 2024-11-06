<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400&display=swap" rel="stylesheet">
</head>
<footer>
  <div class="logo">
    <a href="<?php echo home_url(); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/logo.png" alt="Logo Summoners Champions">
    </a>
  </div>
  <nav class="second-navigation">
    <?php 
      wp_nav_menu(array(
        'theme_location' => 'footer-menu',
        'menu_class'     => 'menu-items',
      )); 
    ?>
  </nav>
  <p><?php bloginfo('name'); ?> est propulsé par <a href="https://wordpress.org" style="color: #FAFAFA;">WordPress</a>.</p>
</footer>
<?php wp_footer(); ?>
</html>
