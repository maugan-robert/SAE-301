<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php the_title(); ?></title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Comme:wght@400&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div class="site-wrapper">
    <header class="site-header">
      <div class="header-container">
        <!-- Logo -->
        <div class="logo">
          <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/logo.png" alt="Logo Summoners Champions">
          </a>
        </div>

        <!-- Navigation -->
        <nav class="main-navigation">
          <?php 
          wp_nav_menu(array(
            'theme_location' => 'header-menu',
            'menu_class'     => 'menu-items',
          )); 
          ?>
        </nav>

        <!-- Burger Menu (Mobile) -->
        <div class="burger-menu" id="burger-menu">
          <button class="burger-icon">
            <span></span>
            <span></span>
            <span></span>
          </button>
          <button class="close-overlay">&times;</button>
        </div>
      </div>

      <!-- Overlay Menu Mobile -->
      <div class="mobile-menu-overlay" id="mobile-menu-overlay">
        <div class="mobile-menu-content">
          <?php 
          wp_nav_menu(array(
            'theme_location' => 'header-menu',
            'menu_class'     => 'mobile-menu-items',
          )); 
          ?>
        </div>
      </div>
    </header>
  </div>

  <script>
    const burgerMenu = document.getElementById('burger-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    burgerMenu.addEventListener('click', function() {
      burgerMenu.classList.toggle('active');
      mobileMenuOverlay.classList.toggle('active');
    });
  </script>
  <?php wp_footer(); ?>
</body>
</html>
