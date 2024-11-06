<?php
/* Template Name: formulaire */
get_header();
?>

<div class="contact-form-container">
    <h1 class="contact-form-title">Contactez-nous</h1>
    <form class="contact-form" action="#" method="post">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" required placeholder="Votre nom" />
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre adresse email" />
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required placeholder="Votre message" rows="4"></textarea>
        </div>

        <button type="submit" class="submit-button">Envoyer</button>
    </form>
</div>

<?php get_footer(); ?>
