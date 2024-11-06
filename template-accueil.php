<?php   
/* Template Name: Accueil */
get_header(); ?>

<div>
    <img src="<?php echo get_template_directory_uri(); ?>/image-intro.jpg" class="img-accueil" alt="">
    <div>
        <h1 class="title-accueil">Bienvenue à toi, Summoner !</h1>
        <p class="text-intro-accueil">Prépare toi à entrer dans la bataille ! Le tournoi SUMMONERS CHAMPIONS va commencer. Que vous soyez un joueur aguerri ou que vous découvriez les joies de la compétition, notre tournoi est ouvert à tous ! </p>
        <a class="button-intro" href="/sae301.mauganrobert.fr/inscription">CRÉER UN COMPTE</a>
    </div>
    <div class="contenu-accueil">
        <h2 class="title-part">C'est quoi le Summoners Champions ?</h2>
        <p class="text">C’est un tournoi ouvert en ligne pour toutes et tous. 10 équipes maximum s’affronteront dans une phase de ligue sanglante ! À la fin de cette phase, la première équipe remportera le tournoi. </p>
        <a href="/sae301.mauganrobert.fr/classement" class="button-blue">VOIR LE CLASSEMENT</a>
        <p class="text">Le SUMMONERS CHAMPIONS à lieu toutes les semaines et les gagnants remporte 500 euros de cashprize à se partager !</p>
    </div>
    <div class="contenu-participer">
        <img class="image" src="<?php echo get_template_directory_uri(); ?>/image2.jpg"alt="">
        <h2 class="title-part">Comment participer ?</h2>
        <p class="text">Pour rejoindre le tournoi, il faut d’abord créer un compte et ensuite créer ou rejoindre une équipe ! Une fois que vous avez rejoins, vous pourrez voir vos adversaires et vous préparez à les affronter pour atteindre la victoire !  </p>
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
    </div>
</div>

<?php get_footer(); ?>