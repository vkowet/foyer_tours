<?php

/**
 * Template Name: Page Contact Moderne
 * Description: Page de contact au design épuré avec cartes
 */

get_header();
?>

<main class="contact-modern-page">
    <div class="container">

        <!-- ===== HERO SECTION ===== -->
        <?php
        $hero_title = get_option('contact_page_hero_title');
        $hero_image = get_option('contact_page_hero_image');
        $hero_subtitle = get_option('contact_page_hero_subtitle');
        ?>
        <?php if ($hero_title || $hero_image) : ?>
            <div class="contact-hero">
                <?php if ($hero_image) : ?>
                    <div class="contact-hero-image">
                        <?php echo wp_get_attachment_image($hero_image, 'full'); ?>
                    </div>
                <?php endif; ?>
                <div class="contact-hero-content">
                    <?php if ($hero_title) : ?>
                        <h1><?php echo esc_html($hero_title); ?></h1>
                    <?php endif; ?>
                    <?php if ($hero_subtitle) : ?>
                        <p><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== INTRODUCTION ===== -->
        <?php $intro_text = get_option('contact_page_intro'); ?>
        <?php if ($intro_text) : ?>
            <div class="contact-intro">
                <?php echo wp_kses_post($intro_text); ?>
            </div>
        <?php endif; ?>

        <!-- ===== BLOC INFORMATIONS ===== -->
        <?php
        $info_title = get_option('contact_info_title');
        $info_subtitle = get_option('contact_info_subtitle');
        $whatsapp = get_option('contact_whatsapp');
        $facebook = get_option('contact_facebook');
        $instagram = get_option('contact_instagram');
        $social_label = get_option('contact_social_label');
        ?>
        <?php if ($info_title || $info_subtitle || $whatsapp || $facebook || $instagram) : ?>
            <div class="contact-info-block">
                <?php if ($info_title) : ?>
                    <h2><?php echo esc_html($info_title); ?></h2>
                <?php endif; ?>

                <?php if ($info_subtitle) : ?>
                    <p><?php echo esc_html($info_subtitle); ?></p>
                <?php endif; ?>

                <?php if ($whatsapp) : ?>
                    <div class="contact-whatsapp">
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/\s+/', '', $whatsapp)); ?>">
                            📱 WhatsApp : <?php echo esc_html($whatsapp); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($facebook || $instagram) : ?>
                    <div class="contact-social">
                        <?php if ($social_label) : ?>
                            <span><?php echo esc_html($social_label); ?></span>
                        <?php endif; ?>
                        <?php if ($facebook) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="social-link">Facebook</a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="social-link">Instagram</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- ===== CARTES DE CONTACT ===== -->
        <?php
        $card_phone = get_option('contact_card_phone');
        $card_email = get_option('contact_card_email');
        $card_address = get_option('contact_card_address');
        ?>
        <?php if ($card_phone || $card_email || $card_address) : ?>
            <div class="contact-cards">

                <?php if ($card_phone) : ?>
                    <div class="contact-card">
                        <div class="card-icon">📞</div>
                        <div class="card-content">
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $card_phone)); ?>" class="card-link">
                                <?php echo esc_html($card_phone); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($card_email) : ?>
                    <div class="contact-card">
                        <div class="card-icon">✉️</div>
                        <div class="card-content">
                            <a href="mailto:<?php echo esc_attr($card_email); ?>" class="card-link">
                                <?php echo esc_html($card_email); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($card_address) : ?>
                    <div class="contact-card">
                        <div class="card-icon">📍</div>
                        <div class="card-content">
                            <span class="card-text"><?php echo esc_html($card_address); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- ===== TITRE FORMULAIRE ===== -->
        <?php $form_title = get_option('contact_form_title'); ?>
        <?php if ($form_title) : ?>
            <h2 class="form-title"><?php echo esc_html($form_title); ?></h2>
        <?php endif; ?>

        <!-- ===== FORMULAIRE ===== -->
        <div class="form-wrapper">
            <?php
            // Traitement du formulaire
            if (isset($_POST['submit_contact_modern']) && wp_verify_nonce($_POST['contact_modern_nonce'], 'contact_modern_action')) {

                $errors = array();
                $success = false;

                // Vérification du captcha
                if (!empty($_SESSION['foyer_captcha_error'])) {
                    $errors[] = $_SESSION['foyer_captcha_error'];
                    unset($_SESSION['foyer_captcha_error']);
                }

                // Récupération et nettoyage des champs
                $nom = sanitize_text_field($_POST['nom']);
                $prenom = sanitize_text_field($_POST['prenom']);
                $email = sanitize_email($_POST['email']);
                $telephone = sanitize_text_field($_POST['telephone']);
                $objet = sanitize_text_field($_POST['objet']);
                $message = sanitize_textarea_field($_POST['message']);

                // Validation
                if (empty($nom)) $errors[] = "Le nom est requis.";
                if (empty($email) || !is_email($email)) $errors[] = "Un email valide est requis.";
                if (empty($telephone)) $errors[] = "Le téléphone est requis.";
                if (empty($objet)) $errors[] = "L'objet est requis.";
                if (empty($message)) $errors[] = "Le message est requis.";

                // Envoi si pas d'erreurs
                if (empty($errors)) {

                    // Gestion des emails (supporte plusieurs adresses séparées par des virgules)
                    $emails = get_option('contact_email_soeurs', get_option('admin_email'));
                    $to = array_map('trim', explode(',', $emails));
                    $to = array_filter($to); // Enlève les entrées vides

                    // Si aucune adresse valide, utiliser l'admin email
                    if (empty($to)) {
                        $to = get_option('admin_email');
                    }

                    $sender_email = get_option('contact_sender_email', get_option('admin_email'));
                    $sender_name = get_bloginfo('name');
                    $site_name = get_bloginfo('name');

                    $subject = "📧 [$site_name] Contact : " . $objet;

                    $email_content = "========================================\n";
                    $email_content .= "NOUVEAU MESSAGE DE CONTACT\n";
                    $email_content .= "========================================\n\n";
                    $email_content .= "📅 Date: " . date('d/m/Y à H:i') . "\n";
                    $email_content .= "🌐 Site: " . $site_name . "\n\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "INFORMATIONS EXPÉDITEUR\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "👤 Nom complet: " . $nom . " " . $prenom . "\n";
                    $email_content .= "✉️ Email: " . $email . "\n";
                    $email_content .= "📞 Téléphone: " . $telephone . "\n\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "MESSAGE\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "📝 Objet: " . $objet . "\n\n";
                    $email_content .= wordwrap($message, 70, "\n") . "\n\n";
                    $email_content .= "========================================\n";
                    $email_content .= "Message envoyé depuis " . $site_name . "\n";
                    $email_content .= "========================================\n";

                    $headers = array(
                        'Content-Type: text/plain; charset=UTF-8',
                        'From: ' . $sender_name . ' <' . $sender_email . '>',
                        'Reply-To: ' . $email
                    );

                    if (wp_mail($to, $subject, $email_content, $headers)) {
                        $success = true;
                        echo '<div class="form-success">';
                        echo '<h3>✅ Message envoyé !</h3>';
                        echo '<p>Nous vous répondrons dans les plus brefs délais.</p>';
                        echo '<p><strong>📧 Une copie a été envoyée à :</strong> ' . esc_html($email) . '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="form-error">';
                        echo '<h3>❌ Erreur d\'envoi</h3>';
                        echo '<p>Une erreur technique est survenue. Veuillez réessayer ou nous contacter par téléphone.</p>';
                        echo '</div>';
                    }
                }

                // Affichage des erreurs
                if (!empty($errors)) {
                    echo '<div class="form-error">';
                    echo '<h3>❌ Formulaire incomplet</h3>';
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li>⚠️ ' . esc_html($error) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>

            <?php if (!isset($_POST['submit_contact_modern']) || !empty($errors)) : ?>
                <form method="post" action="" class="contact-modern-form">
                    <?php wp_nonce_field('contact_modern_action', 'contact_modern_nonce'); ?>

                    <div class="form-grid">
                        <div class="form-field">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? esc_attr($_POST['nom']) : ''; ?>" required>
                        </div>

                        <div class="form-field">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? esc_attr($_POST['prenom']) : ''; ?>">
                        </div>

                        <div class="form-field">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" required>
                        </div>

                        <div class="form-field">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? esc_attr($_POST['telephone']) : ''; ?>" required>
                        </div>

                        <div class="form-field full-width">
                            <label for="objet">Objet *</label>
                            <input type="text" id="objet" name="objet" value="<?php echo isset($_POST['objet']) ? esc_attr($_POST['objet']) : ''; ?>" required>
                        </div>

                        <div class="form-field full-width">
                            <label for="message">Message *
                                <?php $msg_info = get_option('contact_message_info'); ?>
                                <?php if ($msg_info) : ?>
                                    <span class="field-note"><?php echo esc_html($msg_info); ?></span>
                                <?php endif; ?>
                            </label>
                            <textarea id="message" name="message" rows="5" maxlength="500" placeholder="écrire votre message ici..." required><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-submit">
                        <button type="submit" name="submit_contact_modern" class="submit-btn">
                            Envoyer le message
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- ===== CARTE GOOGLE MAPS ===== -->
        <?php if (get_option('contact_show_map', 0)) : ?>
            <?php $map_address = get_option('foyer_footer_address'); ?>
            <?php if ($map_address) : ?>
                <div class="contact-map">
                    <iframe
                        src="https://www.google.com/maps?q=<?php echo urlencode($map_address); ?>&output=embed"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>