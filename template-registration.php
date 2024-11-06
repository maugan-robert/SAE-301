<?php
// Vérifier si le formulaire d'inscription a été soumis
/*
Template Name: Inscription
*/
get_header(); // Inclut l'en-tête du site

if (isset($_POST['submit'])) {
    // Récupérer et assainir les données du formulaire
    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $email = sanitize_email($_POST['email']);

    // Vérifier si l'utilisateur existe déjà
    if (username_exists($username) || email_exists($email)) {
        echo '<div class="register-error">Erreur : Le nom d’utilisateur ou l’adresse e-mail est déjà utilisé.</div>';
    } else {
        // Créer un nouvel utilisateur
        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password, // Le mot de passe sera automatiquement haché
            'role' => 'contributor' // Définir le rôle comme contributeur
        );

        // Insérer l'utilisateur dans la base de données
        $user_id = wp_insert_user($userdata);

        // Vérifier si l'utilisateur a été créé avec succès
        if (!is_wp_error($user_id)) {
            // Rediriger vers la page de connexion
            wp_redirect(home_url('/connexion'));
            exit; // Arrêter l'exécution du script pour s'assurer que la redirection se fait
        } else {
            echo '<div class="register-error">Erreur : ' . $user_id->get_error_message() . '</div>';
        }
    }
}
?>
<!-- Formulaire d'inscription -->
<div class="register-container">
    <h2 class="register-title">Inscription</h2>
    <form method="post" class="register-form">
        <label for="username" class="register-label">Pseudo :</label>
        <input type="text" name="username" class="register-input" required>

        <label for="email" class="register-label">Adresse e-mail :</label>
        <input type="email" name="email" class="register-input" required>
        
        <label for="password" class="register-label">Mot de passe :</label>
        <input type="password" name="password" class="register-input" required>

        <input type="submit" name="submit" value="Inscription" class="register-submit">
    </form>
</div>

<?php get_footer(); ?>
