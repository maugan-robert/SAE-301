<?php
/* Template Name: equipes-all */

get_header();

// Vérifier si l'utilisateur est connecté
if (!is_user_logged_in()) {
    echo '<p>Vous devez être connecté pour créer une équipe.</p>';
    wp_login_form();
    get_footer();
    exit;
}

// Traitement du formulaire d'ajout d'équipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creer_equipe_nonce']) && wp_verify_nonce($_POST['creer_equipe_nonce'], 'creer_equipe')) {

    // Récupérer les données du formulaire
    $nom_equipe = sanitize_text_field($_POST['nom_equipe']);
    $joueurs = array();
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($_POST['membre_' . $i])) {
            $joueurs[] = intval($_POST['membre_' . $i]);
        }
    }

    // Création du post de type 'equipes'
    $equipe_id = wp_insert_post(array(
        'post_type' => 'equipes',
        'post_title' => $nom_equipe,
        'post_status' => 'publish',
    ));

    // Ajouter les joueurs comme un champ personnalisé
    if ($equipe_id) {
        update_field('joueurs-', $joueurs, $equipe_id);

        // Ajouter le logo si un fichier a été téléchargé
        if (isset($_FILES['image_equipe']) && !empty($_FILES['image_equipe']['name'])) {
            $upload = wp_upload_bits($_FILES['image_equipe']['name'], null, file_get_contents($_FILES['image_equipe']['tmp_name']));
            if (!$upload['error']) {
                $file_path = $upload['file'];
                $attachment_id = wp_insert_attachment(array(
                    'post_mime_type' => $_FILES['image_equipe']['type'],
                    'post_title' => basename($file_path),
                    'post_content' => '',
                    'post_status' => 'inherit',
                ), $file_path, $equipe_id);
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
                update_field('logo', $attachment_id, $equipe_id); // Enregistrer le logo comme un champ personnalisé
            }
        }
    }
}

// Paramètres de la requête pour récupérer les équipes existantes
$args = array('post_type' => 'equipes');
$the_query = new WP_Query($args);
?>

<?php if ($the_query->have_posts()) : ?>
    <div class="toutes-les-equipes">
        <div class="equipes-part">
            <h2 class="title-part">Toutes les équipes</h2>
        </div>
        <div class="equipes-grid"> <!-- Conteneur pour la grille des équipes -->
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="equipe-card">
                    <?php 
                    $logo_id = get_field('logo'); 
                    if ($logo_id): 
                        echo wp_get_attachment_image($logo_id, 'thumbnail', false, ['class' => 'equipe-logo', 'alt' => get_the_title() . ' Logo']);
                    else: ?>
                        <p>Aucun logo défini pour cette équipe.</p>
                    <?php endif; ?>
                    <h3 class="equipe-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php else : ?>
    <p>Aucune équipe n'a été trouvée.</p>
<?php endif;?>

<div class="create-team-section">
    <button id="show-create-form" class="create-team-btn">CRÉER UNE ÉQUIPE</button>

    <div id="create-form" style="display: none;">
        <h2>Créer une équipe</h2>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('creer_equipe', 'creer_equipe_nonce'); ?>
            <p>
                <label for="nom_equipe">Nom de l'équipe :</label>
                <input type="text" id="nom_equipe" name="nom_equipe" required>
            </p>
            <p>
                <label for="image_equipe">Logo de l'équipe :</label>
                <input type="file" id="image_equipe" name="image_equipe">
            </p>
            <p>
                <label>Joueurs :</label><br>
                <?php
                $users = get_users();
                for ($i = 1; $i <= 5; $i++) {
                    echo '<select name="membre_' . $i . '" class="member-select" required>';
                    echo '<option value="">Sélectionner un membre</option>';
                    foreach ($users as $user) {
                        echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </p>
            <input type="submit" value="Créer l'équipe" class="create-team-submit">
        </form>
    </div>
</div>

<script>
document.getElementById('show-create-form').addEventListener('click', function () {
    var form = document.getElementById('create-form');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
});
</script>

<?php
wp_reset_postdata();
get_footer();
?>
