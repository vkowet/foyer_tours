<?php
/**
 * Template Name: Page Contact Moderne
 * Description: Page de contact au design épuré avec cartes et captcha intégré
 */

get_header();
?>

<main class="contact-modern-page">

    <div class="container">

        <!-- ===== INTRODUCTION ===== -->
        <div class="contact-intro">
            <?php
            $intro_text = get_option('contact_modern_intro', '<h1>Pour tous vos besoins d\'informations, contactez-nous ou suivez-nous sur nos réseaux sociaux.</h1>');
            echo wp_kses_post($intro_text);
            ?>
        </div>

        <!-- ===== CARTES DE CONTACT ===== -->
        <div class="contact-cards">

            <!-- Téléphone -->
            <div class="contact-card">
                <div class="card-icon">📞</div>
                <div class="card-content">
                    <?php
                    $phone = get_option('foyer_contact_phone', '01 23 45 67 89');
                    $phone2 = get_option('contact_phone_2', '');
                    ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="card-link">
                        <?php echo esc_html($phone); ?>
                    </a>
                    <?php if (!empty($phone2)) : ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone2)); ?>" class="card-link">
                            <?php echo esc_html($phone2); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="contact-card">
                <div class="card-icon">✉️</div>
                <div class="card-content">
                    <?php
                    $email = get_option('foyer_contact_email', 'contact@foyer.fr');
                    ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="card-link">
                        <?php echo esc_html($email); ?>
                    </a>
                </div>
            </div>

            <!-- Adresse -->
            <div class="contact-card">
                <div class="card-icon">📍</div>
                <div class="card-content">
                    <?php
                    $address = get_option('foyer_footer_address', '29 Rue place Coty, Tours 37100');
                    ?>
                    <span class="card-text"><?php echo esc_html($address); ?></span>
                </div>
            </div>

        </div>

        <!-- ===== TITRE FORMULAIRE ===== -->
        <h2 class="form-title"><?php echo esc_html(get_option('contact_modern_form_title', 'Envoyez-nous un message')); ?></h2>

        <!-- ===== FORMULAIRE ===== -->
        <div class="form-wrapper">
            <?php
            // Traitement du formulaire
            $form_submitted = isset($_POST['submit_contact_modern']);
            $nonce_valid = isset($_POST['contact_modern_nonce']) && wp_verify_nonce($_POST['contact_modern_nonce'], 'contact_modern_action');
            
            if ($form_submitted && $nonce_valid) {

                $errors = array();
                $form_data = array();

                // ✅ VÉRIFICATION CORRECTE : Le captcha doit être validé
                if (!function_exists('foyer_is_captcha_validated') || !foyer_is_captcha_validated()) {
                    $errors[] = "Veuillez valider le captcha pour prouver que vous n'êtes pas un robot.";
                }

                // Récupération et nettoyage des champs
                $form_data['nom'] = sanitize_text_field($_POST['nom']);
                $form_data['prenom'] = sanitize_text_field($_POST['prenom']);
                $form_data['email'] = sanitize_email($_POST['email']);
                $form_data['telephone'] = sanitize_text_field($_POST['telephone']);
                $form_data['objet'] = sanitize_text_field($_POST['objet']);
                $form_data['message'] = sanitize_textarea_field($_POST['message']);
                
                // Honeypot anti-spam (champ caché)
                if (!empty($_POST['website'])) {
                    $errors[] = "Spam détecté. Veuillez réessayer.";
                }

                // Validation des champs obligatoires
                if (empty($form_data['nom'])) $errors[] = "Le nom est requis.";
                if (empty($form_data['email']) || !is_email($form_data['email'])) $errors[] = "Un email valide est requis.";
                if (empty($form_data['telephone'])) $errors[] = "Le téléphone est requis.";
                if (empty($form_data['objet'])) $errors[] = "L'objet est requis.";
                if (empty($form_data['message'])) $errors[] = "Le message est requis.";
                
                // Validation supplémentaire du téléphone
                if (!empty($form_data['telephone']) && !preg_match('/^[0-9+\-\s]{10,20}$/', $form_data['telephone'])) {
                    $errors[] = "Le numéro de téléphone n'est pas valide.";
                }
                
                // Validation de la longueur du message
                if (strlen($form_data['message']) > 500) {
                    $errors[] = "Le message ne doit pas dépasser 500 caractères.";
                }

                // Envoi du message si pas d'erreurs
                if (empty($errors)) {

                    $to = get_option('contact_email_soeurs', get_option('admin_email'));
                    $subject = "Contact : " . $form_data['objet'];

                    $email_content = "Nouveau message de contact reçu le " . date('d/m/Y à H:i') . "\n\n";
                    $email_content .= "--- INFORMATIONS EXPÉDITEUR ---\n";
                    $email_content .= "Nom : " . $form_data['nom'] . "\n";
                    $email_content .= "Prénom : " . ($form_data['prenom'] ?: 'Non renseigné') . "\n";
                    $email_content .= "Email : " . $form_data['email'] . "\n";
                    $email_content .= "Téléphone : " . $form_data['telephone'] . "\n\n";
                    $email_content .= "--- MESSAGE ---\n";
                    $email_content .= "Objet : " . $form_data['objet'] . "\n";
                    $email_content .= "Message :\n" . $form_data['message'] . "\n\n";
                    $email_content .= "---\n";
                    $email_content .= "Message envoyé depuis le site " . get_bloginfo('name') . " (" . get_site_url() . ")\n";
                    $email_content .= "IP de l'expéditeur : " . $_SERVER['REMOTE_ADDR'] . "\n";
                    $email_content .= "User Agent : " . $_SERVER['HTTP_USER_AGENT'];

                    $headers = array(
                        'Content-Type: text/plain; charset=UTF-8',
                        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                        'Reply-To: ' . $form_data['email']
                    );

                    if (wp_mail($to, $subject, $email_content, $headers)) {
                        // ✅ Réinitialiser le captcha après envoi réussi
                        if (function_exists('foyer_reset_captcha')) {
                            foyer_reset_captcha();
                        }
                        
                        echo '<div class="form-success">';
                        echo '<h3>✅ Message envoyé avec succès !</h3>';
                        echo '<p>Merci ' . esc_html($form_data['prenom'] ?: $form_data['nom']) . ', votre message a bien été reçu.</p>';
                        echo '<p>Nous vous répondrons dans les plus brefs délais.</p>';
                        echo '<button class="submit-btn" onclick="location.reload();">Envoyer un autre message</button>';
                        echo '</div>';
                        
                        // JavaScript pour réinitialiser l'état du formulaire
                        echo '<script>
                            if (window.resetAllCaptchas) {
                                window.resetAllCaptchas();
                            }
                            // Réinitialiser le compteur de caractères
                            const charCount = document.querySelector(".char-count");
                            if (charCount) charCount.textContent = "0/500";
                        </script>';
                        
                        // Marquer que le formulaire a été envoyé avec succès
                        $form_success = true;
                    } else {
                        echo '<div class="form-error">';
                        echo '<p>❌ Une erreur technique est survenue. Veuillez réessayer ou nous contacter directement par téléphone.</p>';
                        echo '</div>';
                        
                        // JavaScript pour réactiver le bouton en cas d'erreur
                        echo '<script>
                            const submitBtn = document.querySelector("#submit-btn");
                            const formLoader = document.querySelector(".form-loader");
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = "Envoyer le message";
                                if (formLoader) formLoader.style.display = "none";
                            }
                        </script>';
                    }
                } else {
                    // Afficher les erreurs de validation
                    echo '<div class="form-error">';
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li>' . esc_html($error) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    
                    // JavaScript pour réactiver le bouton en cas d'erreur
                    echo '<script>
                        const submitBtn = document.querySelector("#submit-btn");
                        const formLoader = document.querySelector(".form-loader");
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = "Envoyer le message";
                            if (formLoader) formLoader.style.display = "none";
                        }
                    </script>';
                }
            }
            ?>

            <?php 
            // Afficher le formulaire seulement si pas de succès d'envoi
            if (!isset($form_success) || !$form_success) : 
            ?>
                <form method="post" action="" class="contact-modern-form" id="contact-form">
                    <?php wp_nonce_field('contact_modern_action', 'contact_modern_nonce'); ?>
                    
                    <!-- Honeypot anti-spam (caché) -->
                    <div class="form-field honeypot" style="display:none; position:absolute; left:-9999px;">
                        <label for="website">Site web</label>
                        <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-grid">
                        <!-- Nom -->
                        <div class="form-field">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? esc_attr($_POST['nom']) : ''; ?>" required>
                        </div>

                        <!-- Prénom -->
                        <div class="form-field">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? esc_attr($_POST['prenom']) : ''; ?>">
                        </div>

                        <!-- Email -->
                        <div class="form-field">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" required>
                        </div>

                        <!-- Téléphone -->
                        <div class="form-field">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo isset($_POST['telephone']) ? esc_attr($_POST['telephone']) : ''; ?>" required pattern="[0-9+\-\s]{10,20}" title="Veuillez entrer un numéro de téléphone valide">
                        </div>

                        <!-- Objet -->
                        <div class="form-field full-width">
                            <label for="objet">Objet *</label>
                            <input type="text" id="objet" name="objet" value="<?php echo isset($_POST['objet']) ? esc_attr($_POST['objet']) : ''; ?>" required>
                        </div>

                        <!-- Message -->
                        <div class="form-field full-width">
                            <label for="message">Message * <span class="field-note">Max. 500 caractères</span></label>
                            <textarea id="message" name="message" rows="5" maxlength="500" placeholder="écrire votre message ici..." required><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                            <span class="char-count">0/500</span>
                        </div>
                    </div>

                    <!-- ===== ZONE CAPTCHA ===== -->
                    <div class="form-field captcha-container">
                        <?php
                        // Vérifier si la page courante doit avoir un captcha
                        $current_page_id = get_the_ID();
                        $protected_pages = get_option('foyer_cv41_pages', []);
                        
                        if (in_array($current_page_id, $protected_pages)) {
                            // Le captcha sera ajouté dynamiquement par puzzle.js
                            echo '<div id="foyer-captcha-placeholder"></div>';
                            echo '<input type="hidden" name="foyer_captcha" id="foyer_captcha" value="">';
                        } else {
                            // Si pas de captcha requis, ajouter un champ caché pour compatibilité
                            echo '<input type="hidden" name="foyer_captcha" value="ok">';
                        }
                        ?>
                    </div>

                    <div class="form-submit">
                        <button type="submit" name="submit_contact_modern" class="submit-btn" id="submit-btn">
                            Envoyer le message
                        </button>
                        <div class="form-loader" style="display:none;">
                            <span class="spinner"></span> Envoi en cours...
                        </div>
                    </div>
                    
                    <div class="form-info">
                        <small>* Champs obligatoires</small>
                        <small>Vos données sont traitées uniquement pour répondre à votre demande.</small>
                    </div>
                </form>
                
                <script type="text/javascript">
                // Script de gestion du formulaire avec captcha
                (function() {
                    // Attendre que le DOM soit chargé
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initFormHandlers);
                    } else {
                        initFormHandlers();
                    }
                    
                    function initFormHandlers() {
                        const form = document.getElementById('contact-form');
                        if (!form) return;
                        
                        const submitBtn = document.getElementById('submit-btn');
                        const formLoader = document.querySelector('.form-loader');
                        const messageField = document.getElementById('message');
                        const charCount = document.querySelector('.char-count');
                        const captchaPlaceholder = document.getElementById('foyer-captcha-placeholder');
                        const hasCaptcha = captchaPlaceholder !== null;
                        
                        // Compteur de caractères
                        if (messageField && charCount) {
                            messageField.addEventListener('input', function() {
                                const length = this.value.length;
                                charCount.textContent = length + '/500';
                                if (length > 500) {
                                    charCount.style.color = '#dc3545';
                                } else {
                                    charCount.style.color = '#6c757d';
                                }
                            });
                        }
                        
                        // Fonction pour vérifier si le captcha est validé
                        function isCaptchaValidated() {
                            if (!hasCaptcha) return true;
                            
                            // Vérifier via les classes du captcha
                            const captchaWrap = document.querySelector('.cv4wrap');
                            const captchaHidden = document.querySelector('.cv4hidden');
                            
                            if (captchaWrap && captchaHidden) {
                                return captchaWrap.classList.contains('valid') && captchaHidden.value === 'ok';
                            }
                            
                            return false;
                        }
                        
                        // Interception de la soumission du formulaire
                        form.addEventListener('submit', function(e) {
                            // Vérifier le captcha
                            if (hasCaptcha && !isCaptchaValidated()) {
                                e.preventDefault();
                                
                                // Afficher un message d'erreur
                                let statusDiv = document.querySelector('.captcha-status');
                                if (!statusDiv) {
                                    const captchaWrap = document.querySelector('.cv4wrap');
                                    if (captchaWrap) {
                                        statusDiv = document.createElement('div');
                                        statusDiv.className = 'captcha-status';
                                        captchaWrap.appendChild(statusDiv);
                                    }
                                }
                                
                                if (statusDiv) {
                                    statusDiv.innerHTML = '<span class="captcha-error">⚠️ Veuillez valider le captcha avant d\'envoyer le message</span>';
                                }
                                
                                // Faire défiler jusqu'au captcha
                                const captchaElement = document.querySelector('.cv4wrap');
                                if (captchaElement) {
                                    captchaElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    
                                    // Mettre en évidence
                                    captchaElement.style.transition = 'all 0.3s ease';
                                    captchaElement.style.boxShadow = '0 0 0 2px #dc3545';
                                    setTimeout(() => {
                                        captchaElement.style.boxShadow = '';
                                    }, 1000);
                                }
                                
                                return false;
                            }
                            
                            // Éviter les soumissions multiples
                            if (submitBtn.disabled) {
                                e.preventDefault();
                                return false;
                            }
                            
                            // Afficher le loader
                            if (submitBtn && formLoader) {
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Envoi en cours...';
                                formLoader.style.display = 'block';
                            }
                            
                            // Le formulaire sera soumis normalement
                            return true;
                        });
                        
                        // Réinitialiser l'état si des erreurs sont présentes
                        if (document.querySelector('.form-error')) {
                            if (submitBtn && formLoader) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Envoyer le message';
                                formLoader.style.display = 'none';
                            }
                        }
                    }
                })();
                </script>
                
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>