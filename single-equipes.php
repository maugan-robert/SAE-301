<?php get_header(); ?>

<div class="toutes-les-equipes">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="equipes">
                <!-- Affichage du logo de l'équipe -->
                <?php 
                $logo_id = get_field('logo'); 
                if ($logo_id): 
                    echo wp_get_attachment_image($logo_id, 'thumbnail', false, ['class' => 'equipe-logo', 'alt' => get_the_title() . ' Logo']);
                else: ?>
                    <p>Aucun logo n'est défini pour cette équipe.</p>
                <?php endif; ?>
                
                <!-- Titre de l'équipe -->
                <h1 class="title"><?php the_title(); ?></h1>

                <div class="statistiques">
                    <p>Victoires : <?php echo esc_html(get_field('victoires')); ?></p>
                    <p>Défaites : <?php echo esc_html(get_field('defaites')); ?></p>
                </div>

                <!-- Liste des membres de l'équipe -->
                <div class="equipes">
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


                <!-- Contenu de l'article -->
                <div class="content"><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>