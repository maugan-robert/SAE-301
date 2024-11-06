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

//ajouter une nouvelle zone de menu à mon thème
function register_my_menu(){
    register_nav_menus( array(
        'header-menu' => __( 'Header'),
        'footer-menu'  => __( 'Footer'),
    ) );
}
add_action( 'init', 'register_my_menu', 0 );


function custom_user_login() {
    if (isset($_POST['login'])) {
        $username = sanitize_user($_POST['username']);
        $password = $_POST['password'];

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            echo 'Erreur de connexion : ' . $user->get_error_message();
        } else {
            wp_redirect(home_url()); // Redirige vers la page d'accueil après connexion réussie
            exit;
        }
    }
}

function custom_menu_items($items, $args) {
    // Vérifie que le menu est celui du header
    if ($args->theme_location === 'header-menu') {
        // Vérifie si l'utilisateur est connecté
        if (is_user_logged_in()) {
            // Enlève le lien de connexion du menu
            $items = preg_replace('/<li><a href=".*?wp-login.php.*?">Connexion<\/a><\/li>/', '', $items);
            
            // Enlève le lien d'inscription du menu
            $items = preg_replace('/<li><a href=".*?\/inscription.*?">Inscription<\/a><\/li>/', '', $items);

            // Ajoute le lien de déconnexion avec une classe personnalisée pour le style
            $items .= '<li class="menu-item logout-menu-item"><a href="' . wp_logout_url(home_url()) . '">ME DÉCONNECTER</a></li>';
        } else {
            // Ajoute le lien de connexion s'il n'est pas connecté
            $items .= '<li class="menu-item"><a href="' . site_url('/connexion') . '">Connexion</a></li>';
            
            // Ajoute le lien d'inscription s'il n'est pas connecté
            $items .= '<li class="menu-item"><a href="' . site_url('/inscription') . '">Inscription</a></li>';
        }
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'custom_menu_items', 10, 2);
