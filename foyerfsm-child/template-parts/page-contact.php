<?php
/**
 * Template Name: Page Contact
 * Description: Page de contact professionnelle avec formulaire
 */

get_header();
?>

<main class="contact-page">
    
    <!-- ===== HERO SIMPLE ===== -->
    <?php
    $hero_image = get_option('contact_page_hero_image', '');
    $hero_image_url = $hero_image ? wp_get_attachment_image_url($hero_image, 'full') : get_template_directory_uri() . '/assets/images/contact-hero.jpg';
    ?>
    <div class="contact-hero" style="background-image: url('<?php echo esc_url($hero_image_url); ?>');">
        <div class="hero-overlay">
            <div class="container">
                <h1 class="hero-title"><?php echo esc_html(get_option('contact_page_hero_title', 'Contactez-nous')); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html(get_option('contact_page_hero_subtitle', 'Pour tous vos besoins d\'information, n\'hésitez pas à nous contacter')); ?></p>
            </div>
        </div>
    </div>

    <div class="container">
        
        <!-- ===== INTRODUCTION ===== -->
        <div class="contact-intro">
            <?php 
            $intro_text = get_option('contact_page_intro', '<p>Pour le plus grand bonheur de nos résidentes, nous répondons à toute demande concernant le foyer, les chambres disponibles ou la vie de la communauté. Parce qu\'aucune demande ne ressemble à une autre, notre équipe s\'engage à vous accompagner personnellement.</p>');
            echo wp_kses_post($intro_text);
            ?>
        </div>

        <!-- ===== CONTENU PRINCIPAL : 2 COLONNES ===== -->
        <div class="contact-content two-columns">
            
            <!-- COLONNE GAUCHE : INFORMATIONS DE CONTACT -->
            <div class="contact-info-column">
                <h2 class="contact-info-title"><?php echo esc_html(get_option('contact_info_title', 'Informations de contact')); ?></h2>
                <p class="contact-info-subtitle"><?php echo esc_html(get_option('contact_info_subtitle', 'Pour tous vos besoins d\'informations, contactez-nous ou suivez-nous sur nos réseaux sociaux.')); ?></p>
                
                <div class="contact-details">
                    
                    <?php 
                    $contact_phone = get_option('foyer_contact_phone', '01 23 45 67 89');
                    $contact_email = get_option('foyer_contact_email', 'contact@foyer.fr');
                    $contact_address = get_option('foyer_footer_address', '15 rue Monin, 41000 BLOIS');
                    ?>
                    
                    <!-- Téléphone -->
                    <div class="contact-detail-item">
                        <div class="detail-icon">📞</div>
                        <div class="detail-content">
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>">
                                <?php echo esc_html($contact_phone); ?>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="contact-detail-item">
                        <div class="detail-icon">✉️</div>
                        <div class="detail-content">
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>">
                                <?php echo esc_html($contact_email); ?>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Adresse -->
                    <div class="contact-detail-item">
                        <div class="detail-icon">📍</div>
                        <div class="detail-content">
                            <span><?php echo esc_html($contact_address); ?></span>
                        </div>
                    </div>
                    
                    <!-- WhatsApp (optionnel) -->
                    <?php 
                    $whatsapp = get_option('contact_whatsapp', '');
                    if (!empty($whatsapp)) : 
                    ?>
                    <div class="contact-detail-item">
                        <div class="detail-icon">📱</div>
                        <div class="detail-content">
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank">
                                <?php echo esc_html($whatsapp); ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Réseaux sociaux -->
                    <?php 
                    $facebook = get_option('contact_facebook', '');
                    $instagram = get_option('contact_instagram', '');
                    
                    if (!empty($facebook) || !empty($instagram)) : 
                    ?>
                    <div class="contact-social">
                        <p class="social-label"><?php echo esc_html(get_option('contact_social_label', 'Suivez-nous')); ?></p>
                        <div class="social-icons">
                            <?php if (!empty($facebook)) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="social-icon" aria-label="Facebook">📘</a>
                            <?php endif; ?>
                            <?php if (!empty($instagram)) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="social-icon" aria-label="Instagram">📷</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
            
            <!-- COLONNE DROITE : FORMULAIRE DE CONTACT -->
            <div class="contact-form-column">
                <h2 class="contact-form-title"><?php echo esc_html(get_option('contact_form_title', 'Envoyez-nous un message')); ?></h2>
                
                <?php
                // Traitement du formulaire
                if (isset($_POST['submit_contact']) && wp_verify_nonce($_POST['contact_nonce'], 'contact_action')) {
                    
                    $errors = array();
                    
                    // Récupération des champs
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
                    
                    // Envoi
                    if (empty($errors)) {
                        
                        $to = get_option('contact_email_soeurs', get_option('admin_email'));
                        $subject = "Contact : " . $objet;
                        
                        $email_content = "Nouveau message de contact reçu le " . date('d/m/Y à H:i') . "\n\n";
                        $email_content .= "Nom : $nom\n";
                        $email_content .= "Prénom : " . ($prenom ?: 'Non renseigné') . "\n";
                        $email_content .= "Email : $email\n";
                        $email_content .= "Téléphone : $telephone\n";
                        $email_content .= "Objet : $objet\n\n";
                        $email_content .= "Message :\n$message\n\n";
                        $email_content .= "---\n";
                        $email_content .= "Message envoyé depuis le site " . get_bloginfo('name');
                        
                        $headers = array(
                            'Content-Type: text/plain; charset=UTF-8',
                            'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                            'Reply-To: ' . $email
                        );
                        
                        if (wp_mail($to, $subject, $email_content, $headers)) {
                            echo '<div class="form-success">';
                            echo '<h3>' . esc_html(get_option('contact_success_title', 'Message envoyé !')) . '</h3>';
                            echo '<p>' . esc_html(get_option('contact_success_message', 'Nous vous répondrons dans les plus brefs délais.')) . '</p>';
                            echo '</div>';
                        } else {
                            echo '<div class="form-error">';
                            echo '<p>' . esc_html(get_option('contact_error_message', 'Une erreur est survenue. Veuillez réessayer.')) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="form-error"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . esc_html($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                }
                ?>

                <?php if (!isset($_POST['submit_contact']) || !empty($errors)) : ?>
                <form method="post" action="" class="contact-form">
                    <?php wp_nonce_field('contact_action', 'contact_nonce'); ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom"><?php echo esc_html(get_option('contact_label_nom', 'Nom *')); ?></label>
                            <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? esc_attr($_POST['nom']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom"><?php echo esc_html(get_option('contact_label_prenom', 'Prénom')); ?></label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? esc_attr($_POST['prenom']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email"><?php echo esc_html(get_option('contact_label_email', 'Email *')); ?></label>
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone"><?php echo esc_html(get_option('contact_label_telephone', 'Téléphone *')); ?></label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? esc_attr($_POST['telephone']) : ''; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="objet"><?php echo esc_html(get_option('contact_label_objet', 'Objet *')); ?></label>
                        <input type="text" id="objet" name="objet" value="<?php echo isset($_POST['objet']) ? esc_attr($_POST['objet']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message"><?php echo esc_html(get_option('contact_label_message', 'Message *')); ?></label>
                        <textarea id="message" name="message" rows="6" maxlength="500" required><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                        <span class="field-info"><?php echo esc_html(get_option('contact_message_info', 'Max. 500 caractères')); ?></span>
                    </div>
                    
                    <div class="form-submit">
                        <button type="submit" name="submit_contact" class="btn-submit">
                            <?php echo esc_html(get_option('contact_submit_text', 'Envoyer le message')); ?>
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
            
        </div>
        
        <!-- ===== CARTE (OPTIONNELLE) ===== -->
        <?php 
        $show_map = get_option('contact_show_map', true);
        if ($show_map) : 
        $map_address = get_option('foyer_footer_address', '15 rue Monin, 41000 BLOIS');
        ?>
        <div class="contact-map">
            <iframe 
                src="https://www.google.com/maps?q=<?php echo urlencode($map_address); ?>&output=embed" 
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>