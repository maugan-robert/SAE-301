<?php
get_header(); ?>

<div class="match-container">

    <!-- Récupérer les informations du match -->
    <?php
    // Récupérer les champs ACF pour le match
    $date_time = get_field('date-heures'); // Date et heure du match
    $score_a = get_field('score-a'); // Score de l'équipe A
    $score_b = get_field('score-b'); // Score de l'équipe B
    $teams = get_field('equipes'); // Équipes participantes (relation)

    if ($teams) {
        // Récupérer les noms des équipes
        $team_a = get_the_title($teams[0]); // Nom de l'équipe A
        $team_b = get_the_title($teams[1]); // Nom de l'équipe B
        
        // Récupérer les logos des équipes
        $team_a_logo = get_field('logo', $teams[0]->ID); // Logo de l'équipe A
        $team_b_logo = get_field('logo', $teams[1]->ID); // Logo de l'équipe B
    }

    // Afficher les détails du match
    ?>
    <div class="match-details">
    <p class="date-match"><strong></strong> <?php echo date('d/m/Y H:i', strtotime($date_time)); ?></p>
            <!-- Affichage des logos des équipes -->

                <div class="teams-match">
                <div class="team-a">
                <div class="team-a-up">
                <?php
                if ($team_a_logo) {
                    echo '<img src="' . esc_url(wp_get_attachment_url($team_a_logo)) . '" alt="' . esc_attr($team_a) . ' Logo" class="team-logo-single-match">';
                }
                ?>
                
                </div>
                <div class="team-a-down">
                <h2><?php echo esc_html($team_a); ?></h2>
        <ul>
            <?php
            // Récupérer et afficher les membres de l'équipe A
            $membres_a = [
                get_field("joueurs-1", $teams[0]),
                get_field("joueurs-2", $teams[0]),
                get_field("joueurs-3", $teams[0]),
                get_field("joueurs-4", $teams[0]),
                get_field("joueurs-5", $teams[0]),
            ];

            global $wpdb;
            foreach ($membres_a as $membre_id) {
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
        </div>
        <p class="score"><strong></strong> <?php echo esc_html($score_a); ?> - <?php echo esc_html($score_b); ?></p>
                <div class="team-b">
                <div class="team-b-up">
                <?php
                if ($team_b_logo) {
                    echo '<img src="' . esc_url(wp_get_attachment_url($team_b_logo)) . '" alt="' . esc_attr($team_b) . ' Logo" class="team-logo-single-match">';
                }
                ?>
               
                </div>
                <div class="team-b-down">
                <h2><?php echo esc_html($team_b); ?></h2>
        <ul>
            <?php
            // Récupérer et afficher les membres de l'équipe B
            $membres_b = [
                get_field("joueurs-1", $teams[1]),
                get_field("joueurs-2", $teams[1]),
                get_field("joueurs-3", $teams[1]),
                get_field("joueurs-4", $teams[1]),
                get_field("joueurs-5", $teams[1]),
            ];

            foreach ($membres_b as $membre_id) {
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
                </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
