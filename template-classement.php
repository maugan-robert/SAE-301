<?php 
/* Template Name: Classement */
get_header(); ?>
<div class="classement-container">
    <h1 class="title-part">Classement</h1>
    <table class="classement-table">
        <body>
            <?php
            // Arguments pour récupérer toutes les équipes, triées par le champ "points" de façon décroissante
            $args = array(
                'post_type' => 'equipes', // Le type de publication des équipes
                'posts_per_page' => -1,   // Afficher toutes les équipes
                'meta_key' => 'points',   // Le champ ACF pour le tri
                'orderby' => 'meta_value_num', // Trier par la valeur numérique du champ
                'order' => 'DESC',        // Ordre décroissant
            );

            // La requête
            $equipe_query = new WP_Query($args);
            $rank = 1; // Initialiser le classement

            // Vérifier si des équipes ont été trouvées
            if ($equipe_query->have_posts()) :
                while ($equipe_query->have_posts()) : $equipe_query->the_post();
                    $logo_id = get_field('logo'); 
                    $victoires = get_field('victoires'); // Récupérer le nombre de victoires
                    $defaites = get_field('defaites');   // Récupérer le nombre de défaites
                    $points = get_field('points');       // Récupérer le nombre de points

                    // Afficher les informations de l'équipe dans le tableau
                    ?>
                    <div >
                    <tr class="ligne-classement">
                        <div class="classement-start">
                        <td class="rank-classement"><?php echo esc_html($rank); ?></td>
                        <td>
                            <?php if ($logo_id): ?>
                                <?php echo wp_get_attachment_image($logo_id, 'thumbnail', false, ['class' => 'equipe-logo-classement', 'alt' => get_the_title() . ' Logo']); ?>
                            <?php endif; ?>
                            </td>
                            </div>
                        <td class="nom-equipe-classement"><?php the_title(); ?></td>
                        <td class="points-classement"><?php echo esc_html($points); ?></td>
                    </tr>
                    </div>
                    <?php
                    $rank++; // Incrémenter le rang
                endwhile;
            else :
                echo '<tr><td colspan="5">Aucune équipe à afficher.</td></tr>';
            endif;

            // Réinitialiser la requête
            wp_reset_postdata();
            ?>
        </tbody>
    </table>
</div>

<?php get_footer(); ?>