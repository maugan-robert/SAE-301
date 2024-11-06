<?php get_header(); ?>

<div class="toutes-les-equipes">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="equipes">
                <!-- Section en haut à gauche : Nom de l'équipe et statistiques -->
                <div class="team-header">
                    <!-- Nom de l'équipe à gauche -->
                    <div class="team-info">
                        <h1 class="team-title"><?php the_title(); ?></h1>
                        <div class="statistiques">
                            <p>Victoires : <?php echo esc_html(get_field('victoires')); ?></p>
                            <p>Défaites : <?php echo esc_html(get_field('defaites')); ?></p>
                        </div>
                    </div>
                    
                    <!-- Logo de l'équipe à droite -->
                    <div class="team-logo-profil">
                        <?php 
                        $logo_id = get_field('logo'); 
                        if ($logo_id): 
                            echo wp_get_attachment_image($logo_id, 'thumbnail', false, ['class' => 'equipe-logo-profil', 'alt' => get_the_title() . ' Logo']);
                        else: ?>
                            <p>Aucun logo n'est défini pour cette équipe.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Liste des membres de l'équipe -->
                <div class="members">
                    <h3 class="title-team">TEAM</h3>
                    <ul>
                        <?php
                        $membres = [
                            get_field("joueurs-1"),
                            get_field("joueurs-2"),
                            get_field("joueurs-3"),
                            get_field("joueurs-4"),
                            get_field("joueurs-5"),
                        ];

                        global $wpdb;
                        foreach ($membres as $membre_id) {
                            if ($membre_id) {
                                $user_name = $wpdb->get_var($wpdb->prepare("
                                    SELECT display_name 
                                    FROM {$wpdb->users}
                                    WHERE ID = %d
                                ", $membre_id));
                                if ($user_name) {
                                    echo '<li>' . esc_html($user_name) . '</li>';
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>

                <div class="content"><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php
    $match_ids = get_field('matchs-selon-equipe'); // Récupérer les IDs des matchs
    if ($match_ids) :
        echo '<h2 class="title-matchs">MATCHS</h2>';
        echo '<ul class="match-list">';

        foreach ($match_ids as $match_id) {
            $match = get_post($match_id); // Obtenir l'objet du match
            $score_a = get_field('score-a', $match_id); // Récupérer le score de l'équipe A
            $score_b = get_field('score-b', $match_id); // Récupérer le score de l'équipe B
            $date_time = get_field('date-heures', $match_id); // Récupérer la date/heure du match
            
            // Récupérer les équipes du match
            $equipes = get_field('equipes', $match_id);

            // Vérifier si les équipes sont présentes
            if ($equipes) : ?>
                <li class="match-item">
                    <a href="<?php echo esc_url(get_permalink($match_id)); ?>">
                        <div class="match-card">
                            <div class="match-info">
                                <p class="match-date"><?php echo date('d/m/Y H:i', strtotime($date_time)); ?></p>
                            </div>
                            
                            <div class="match-teams">
    <?php foreach ($equipes as $index => $equipe) :
        // Récupérer le logo de chaque équipe
        $logo_id = get_field('logo', $equipe->ID);
        $initials = strtoupper(substr($equipe->post_title, 0, 3)); // Initiales de l'équipe
        
        // Définir la classe conditionnelle pour le logo avec une structure if classique
        if ($index === 0) {
            $team_logo_class = 'team-a-logo';
        } else {
            $team_logo_class = 'team-b-logo';
        }
        ?>
        <div class="team-logo <?php echo esc_attr($team_logo_class); ?>">
            <?php if ($logo_id) : ?>
                <img src="<?php echo esc_url(wp_get_attachment_url($logo_id)); ?>" alt="<?php echo esc_attr($equipe->post_title); ?> Logo">
            <?php endif; ?>
            <span class="team-initials"><?php echo esc_html($initials); ?></span>
        </div>
    <?php endforeach; ?>
</div>
                            </div>
                            
                            <div class="match-info">
                                <span class="score"><?php echo esc_html($score_a); ?> - <?php echo esc_html($score_b); ?></span>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endif;
        }
        echo '</ul>';
    else :
        echo '<p>Aucun match trouvé.</p>';
    endif;
    ?>
</div>
<?php get_footer(); ?>
