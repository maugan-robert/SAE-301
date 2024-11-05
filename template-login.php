<?php
// Vérifier si le formulaire de connexion a été soumis
/* Template Name: Connexion */

// Inclure l'en-tête WordPress
get_header();

if (isset($_POST['login'])) {
    $creds = array();
    $creds['user_login'] = sanitize_text_field($_POST['username']);
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = true;

    // Essayer de connecter l'utilisateur
    $user = wp_signon($creds, false);

    // Vérifier si la connexion a réussi
    if (is_wp_error($user)) {
        echo '<div class="login-error">' . $user->get_error_message() . '</div>';
    } else {
        // Redirige vers la page d'accueil après la connexion
        wp_redirect(home_url());
        exit;
    }
}
?>

<!-- Formulaire de connexion -->
<div class="login-container">
    <h2 class="login-title">Connexion</h2>
    <form method="post" class="login-form">
        <label for="username" class="login-label">Nom d'utilisateur :</label>
        <input type="text" name="username" class="login-input" required>

        <label for="password" class="login-label">Mot de passe :</label>
        <input type="password" name="password" class="login-input" required>

        <input type="submit" name="login" value="Connexion" class="login-submit">
    </form>
</div>

<?php
get_footer(); // Inclure le pied de page WordPress
?>
