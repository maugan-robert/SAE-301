<?php
/* Template Name: all-matchs */
get_header(); ?>

<div class="matchs-part">
    <h1 class="title-part">Tous les Matchs</h1>

    <?php
    // Arguments pour récupérer tous les matchs
    $args = array(
        'post_type' => 'matchs', // Le type de publication des matchs
        'posts_per_page' => -1,  // Afficher tous les matchs
        'orderby' => 'date',      // Trier par date
        'order' => 'ASC'          // Ordre croissant
    );

    // La requête
    $match_query = new WP_Query($args);

    // Vérifier si des matchs ont été trouvés
    if ($match_query->have_posts()) :
        echo '<ul class="match-list">';
        while ($match_query->have_posts()) : $match_query->the_post();
            // Récupérer les champs ACF
            $teams = get_field('equipes'); // Équipes participantes (relation)
            $score_a = get_field('score-a'); // Récupérer le score de l'équipe A
            $score_b = get_field('score-b'); // Récupérer le score de l'équipe B
            
            // Récupérer les logos des équipes
            $team_a_logo = get_field('logo', $teams[0]->ID); // Logo de l'équipe A
            $team_b_logo = get_field('logo', $teams[1]->ID); // Logo de l'équipe B

            // Récupérer les initiales des équipes (les 3 premières lettres du nom)
            $team_a_initials = strtoupper(substr(get_the_title($teams[0]), 0, 3));
            $team_b_initials = strtoupper(substr(get_the_title($teams[1]), 0, 3));
            
            // Afficher chaque match avec un lien vers la page unique
            ?>
            <li class="match-item">
                <a href="<?php the_permalink(); ?>">
                    <!-- Card match avec logos, initiales et score -->
                    <div class="match-card">
                        <!-- Logo de l'équipe A -->
                        <?php if ($team_a_logo) : ?>
                            <div class="team-logo team-a-logo">
                                <img src="<?php echo esc_url(wp_get_attachment_url($team_a_logo)); ?>" alt="<?php echo esc_attr(get_the_title($teams[0]->ID)); ?> Logo">
                            </div>
                        <?php endif; ?>

                        <!-- Initiales des équipes et score -->
                        <div class="match-info">
                            <span class="team-initials team-a"><?php echo esc_html($team_a_initials); ?></span>
                            <span class="score"><?php echo esc_html($score_a); ?> - <?php echo esc_html($score_b); ?></span>
                            <span class="team-initials team-b"><?php echo esc_html($team_b_initials); ?></span>
                        </div>

                        <!-- Logo de l'équipe B -->
                        <?php if ($team_b_logo) : ?>
                            <div class="team-logo team-b-logo">
                                <img src="<?php echo esc_url(wp_get_attachment_url($team_b_logo)); ?>" alt="<?php echo esc_attr(get_the_title($teams[1]->ID)); ?> Logo">
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
            <?php
        endwhile;
        echo '</ul>';
    else :
        echo '<p>Aucun match à afficher.</p>';
    endif;

    // Réinitialiser la requête
    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>
