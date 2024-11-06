<?php
/* Template Name: Profil */

get_header(); ?>

<div class="profil-container">
    <h1>Mon Profil</h1>

    <?php
    // Vérifie si l'utilisateur est connecté
    if (is_user_logged_in()) {
        // Récupérer l'utilisateur actuel
        $current_user = wp_get_current_user();
        ?>

        <div class="profil-details">
            <h2>Informations personnelles</h2>
            <p><strong>Nom d'utilisateur :</strong> <?php echo esc_html($current_user->user_login); ?></p>
            <p><strong>Email :</strong> <?php echo esc_html($current_user->user_email); ?></p>

            <h2>Modifier le mot de passe</h2>
            <form method="post">
                <p>
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new_password" required>
                </p>
                <p>
                    <input type="submit" name="update_password" value="Mettre à jour">
                </p>
            </form>
        </div>

        <?php
        // Traitement de la mise à jour du mot de passe
        if (isset($_POST['update_password'])) {
            $new_password = $_POST['new_password'];
            wp_set_password($new_password, $current_user->ID);
            echo '<div class="success">Mot de passe mis à jour avec succès.</div>';
        }
    } else {
        echo '<p>Vous devez être connecté pour voir votre profil.</p>';
    }
    ?>

</div>

<?php get_footer(); ?>