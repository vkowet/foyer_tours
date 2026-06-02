<?php
/**
 * Template Name: Demande de chambre
 * Description: Formulaire de demande de chambre - Version professionnelle
 */

get_header();

// Récupérer les chambres disponibles via la même fonction que l'autre page
$chambres_disponibles = foyerfsm_get_chambres_disponibles();
$has_chambres = !empty($chambres_disponibles);

// Récupérer l'email expéditeur
$sender_email = get_option('contact_sender_email', get_option('admin_email'));
$sender_name = get_bloginfo('name');
$site_name = get_bloginfo('name');

// Récupération des options
$page_title = get_option('demande_chambre_page_title');
$page_subtitle = get_option('demande_chambre_page_subtitle');
$intro_text = get_option('demande_chambre_intro_text');

// Initialisation des données du formulaire
$form_data = array(
    'nom' => isset($_POST['nom']) ? sanitize_text_field($_POST['nom']) : '',
    'prenom' => isset($_POST['prenom']) ? sanitize_text_field($_POST['prenom']) : '',
    'date_naissance' => isset($_POST['date_naissance']) ? sanitize_text_field($_POST['date_naissance']) : '',
    'adresse' => isset($_POST['adresse']) ? sanitize_textarea_field($_POST['adresse']) : '',
    'telephone' => isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '',
    'email' => isset($_POST['email']) ? sanitize_email($_POST['email']) : '',
    'carte_etudiante' => isset($_POST['carte_etudiante']) ? sanitize_text_field($_POST['carte_etudiante']) : '',
    'chambre_souhaitee' => isset($_POST['chambre_souhaitee']) ? sanitize_text_field($_POST['chambre_souhaitee']) : '',
    'message' => isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '',
    'responsable_nom' => isset($_POST['responsable_nom']) ? sanitize_text_field($_POST['responsable_nom']) : '',
    'responsable_lien' => isset($_POST['responsable_lien']) ? sanitize_text_field($_POST['responsable_lien']) : '',
    'responsable_adresse' => isset($_POST['responsable_adresse']) ? sanitize_textarea_field($_POST['responsable_adresse']) : '',
    'responsable_telephone' => isset($_POST['responsable_telephone']) ? sanitize_text_field($_POST['responsable_telephone']) : '',
    'responsable_email' => isset($_POST['responsable_email']) ? sanitize_email($_POST['responsable_email']) : '',
);

$form_submitted_success = false;

// Fonction pour extraire les infos de la chambre depuis son ID (ex: chambre_11m2_1)
function foyerfsm_parse_chambre_id($chambre_id) {
    $parts = explode('_', $chambre_id);
    if (count($parts) >= 3) {
        $type = $parts[0] . '_' . $parts[1];
        $numero = $parts[2];
        
        $types_noms = array(
            'chambre_9m2' => 'Chambre 9m²',
            'chambre_11m2' => 'Chambre 11m²',
            'chambre_12m2' => 'Chambre 12m²',
            'chambre_14m2' => 'Chambre 14m²',
            'chambre_16m2' => 'Chambre 16m²',
            'chambre_17m2' => 'Chambre 17m²'
        );
        
        return array(
            'titre' => (isset($types_noms[$type]) ? $types_noms[$type] : 'Chambre') . ' - n°' . $numero,
            'surface' => str_replace('chambre_', '', $type),
            'type' => $type,
            'numero' => $numero
        );
    }
    return array('titre' => $chambre_id, 'surface' => '', 'type' => '', 'numero' => '');
}
?>

<main class="demande-chambre-page">
    <div class="container">

        <!-- ===== EN-TÊTE DE PAGE ===== -->
        <div class="page-header">
            <h1 class="page-title"><?php echo !empty($page_title) ? esc_html($page_title) : 'Demander une chambre'; ?></h1>
            <?php if (!empty($page_subtitle)) : ?>
                <p class="page-subtitle"><?php echo esc_html($page_subtitle); ?></p>
            <?php endif; ?>
        </div>

        <!-- ===== INTRODUCTION ===== -->
        <div class="intro-card">
            <div class="intro-icon">📋</div>
            <div class="intro-text">
                <?php 
                if (!empty($intro_text)) {
                    echo wp_kses_post($intro_text);
                } else {
                    echo '<p>Merci de remplir ce formulaire de demande de chambre. Nous vous recontacterons dans les plus brefs délais pour vous informer des disponibilités.</p>';
                }
                ?>
            </div>
        </div>

        <!-- ===== FORMULAIRE ===== -->
        <div class="form-card">
            <?php
            // Traitement du formulaire
            if (isset($_POST['submit_demande_chambre']) && wp_verify_nonce($_POST['demande_chambre_nonce'], 'demande_chambre_action')) {

                $errors = array();

                // Récupération des champs
                $nom = sanitize_text_field($_POST['nom']);
                $prenom = sanitize_text_field($_POST['prenom']);
                $date_naissance = sanitize_text_field($_POST['date_naissance']);
                $adresse = sanitize_textarea_field($_POST['adresse']);
                $telephone = sanitize_text_field($_POST['telephone']);
                $email = sanitize_email($_POST['email']);
                $carte_etudiante = sanitize_text_field($_POST['carte_etudiante']);
                $chambre_souhaitee = isset($_POST['chambre_souhaitee']) ? sanitize_text_field($_POST['chambre_souhaitee']) : '';
                $message = sanitize_textarea_field($_POST['message']);

                // Validation de la chambre choisie
                if ($has_chambres && empty($chambre_souhaitee)) {
                    $errors[] = "Veuillez sélectionner une chambre.";
                }

                // Récupérer les détails de la chambre
                $chambre_details = foyerfsm_parse_chambre_id($chambre_souhaitee);
                $chambre_titre = $chambre_details['titre'];
                $chambre_surface = $chambre_details['surface'];

                // Calcul de l'âge
                $date_naissance_obj = DateTime::createFromFormat('Y-m-d', $date_naissance);
                $age = $date_naissance_obj ? $date_naissance_obj->diff(new DateTime())->y : 0;
                $est_mineur = $age < 18;

                // Champs responsables légaux (si mineur)
                if ($est_mineur) {
                    $responsable_nom = sanitize_text_field($_POST['responsable_nom']);
                    $responsable_lien = sanitize_text_field($_POST['responsable_lien']);
                    $responsable_adresse = sanitize_textarea_field($_POST['responsable_adresse']);
                    $responsable_telephone = sanitize_text_field($_POST['responsable_telephone']);
                    $responsable_email = sanitize_email($_POST['responsable_email']);

                    if (empty($responsable_nom)) $errors[] = "Le nom du responsable légal est requis.";
                    if (empty($responsable_lien)) $errors[] = "Le lien de parenté est requis.";
                    if (empty($responsable_adresse)) $errors[] = "L'adresse du responsable légal est requise.";
                    if (empty($responsable_telephone)) $errors[] = "Le téléphone du responsable légal est requis.";
                    if (empty($responsable_email) || !is_email($responsable_email)) $errors[] = "Un email valide pour le responsable légal est requis.";
                    
                    $form_data['responsable_nom'] = $responsable_nom;
                    $form_data['responsable_lien'] = $responsable_lien;
                    $form_data['responsable_adresse'] = $responsable_adresse;
                    $form_data['responsable_telephone'] = $responsable_telephone;
                    $form_data['responsable_email'] = $responsable_email;
                }

                // Validation des champs obligatoires
                if (empty($nom)) $errors[] = "Le nom est requis.";
                if (empty($prenom)) $errors[] = "Le prénom est requis.";
                if (empty($date_naissance)) $errors[] = "La date de naissance est requise.";
                if (empty($adresse)) $errors[] = "L'adresse est requise.";
                if (empty($telephone)) $errors[] = "Le téléphone est requis.";
                if (empty($email) || !is_email($email)) $errors[] = "Un email valide est requis.";

                // Mise à jour des données
                $form_data['nom'] = $nom;
                $form_data['prenom'] = $prenom;
                $form_data['date_naissance'] = $date_naissance;
                $form_data['adresse'] = $adresse;
                $form_data['telephone'] = $telephone;
                $form_data['email'] = $email;
                $form_data['carte_etudiante'] = $carte_etudiante;
                $form_data['chambre_souhaitee'] = $chambre_souhaitee;
                $form_data['message'] = $message;

                // Envoi si pas d'erreurs
                if (empty($errors)) {
                    $emails = get_option('demande_chambre_email_reception', get_option('admin_email'));
                    $to = array_map('trim', explode(',', $emails));
                    $to = array_filter($to);
                    if (empty($to)) $to = get_option('admin_email');
                    
                    $subject = "[$site_name] Demande de chambre - " . $chambre_titre;

                    $email_content = "========================================\n";
                    $email_content .= "       NOUVELLE DEMANDE DE CHAMBRE\n";
                    $email_content .= "========================================\n\n";
                    $email_content .= "📅 Date : " . date('d/m/Y à H:i') . "\n";
                    $email_content .= "🌐 Site : " . $site_name . "\n\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "       CHAMBRE SOUHAITEE\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "🏠 Chambre : " . ($chambre_titre ?: 'Non spécifiée') . "\n";
                    if ($chambre_surface) $email_content .= "📏 Surface : " . $chambre_surface . "\n\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "       INFORMATIONS RESIDENTE\n";
                    $email_content .= "----------------------------------------\n";
                    $email_content .= "👤 Nom : " . strtoupper($nom) . " " . ucfirst($prenom) . "\n";
                    $email_content .= "🎂 Naissance : " . $date_naissance . " (" . $age . " ans)\n";
                    $email_content .= "📞 Téléphone : " . $telephone . "\n";
                    $email_content .= "✉️ Email : " . $email . "\n";
                    $email_content .= "📍 Adresse : " . str_replace("\n", ", ", $adresse) . "\n";
                    if ($carte_etudiante) $email_content .= "🎓 Carte étudiante : " . $carte_etudiante . "\n\n";

                    if ($est_mineur) {
                        $email_content .= "----------------------------------------\n";
                        $email_content .= "       RESPONSABLE LEGAL\n";
                        $email_content .= "----------------------------------------\n";
                        $email_content .= "👤 Nom : " . $responsable_nom . "\n";
                        $email_content .= "🔗 Lien : " . $responsable_lien . "\n";
                        $email_content .= "📞 Téléphone : " . $responsable_telephone . "\n";
                        $email_content .= "✉️ Email : " . $responsable_email . "\n";
                        $email_content .= "📍 Adresse : " . str_replace("\n", ", ", $responsable_adresse) . "\n\n";
                    }

                    if (!empty($message)) {
                        $email_content .= "----------------------------------------\n";
                        $email_content .= "       MESSAGE\n";
                        $email_content .= "----------------------------------------\n";
                        $email_content .= wordwrap($message, 70, "\n") . "\n\n";
                    }

                    $email_content .= "========================================\n";
                    $email_content .= "Message envoyé depuis " . $site_name . "\n";
                    $email_content .= "========================================\n";

                    $headers = array(
                        'Content-Type: text/plain; charset=UTF-8',
                        'From: ' . $sender_name . ' <' . $sender_email . '>',
                        'Reply-To: ' . $email
                    );

                    $user_subject = "Confirmation de votre demande - " . $site_name;
                    $user_content = "Bonjour " . $prenom . " " . $nom . ",\n\n";
                    $user_content .= "Nous avons bien reçu votre demande de chambre.\n\n";
                    $user_content .= "Chambre sélectionnée : " . $chambre_titre . "\n";
                    $user_content .= "Date de demande : " . date('d/m/Y') . "\n\n";
                    $user_content .= "Nous vous recontacterons dans les plus brefs délais.\n\n";
                    $user_content .= "Cordialement,\n";
                    $user_content .= "L'équipe du " . $site_name;

                    $email1_sent = wp_mail($to, $subject, $email_content, $headers);
                    $email2_sent = wp_mail($email, $user_subject, $user_content, $headers);

                    if ($email1_sent) {
                        $form_submitted_success = true;
                        $success_title = get_option('demande_chambre_success_title');
                        $success_message = get_option('demande_chambre_success_message');
                        echo '<div class="form-success">';
                        echo '<h3>✓ ' . esc_html($success_title ?: 'Merci pour votre demande !') . '</h3>';
                        echo '<p>' . esc_html($success_message ?: 'Votre demande a bien été envoyée. Nous vous recontacterons très rapidement.') . '</p>';
                        echo '<div class="success-details">';
                        echo '<p><strong>🏠 Chambre sélectionnée :</strong> ' . esc_html($chambre_titre) . '</p>';
                        echo '<p><strong>📧 Un email de confirmation vous a été envoyé à :</strong> ' . esc_html($email) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        $error_message = get_option('demande_chambre_error_message');
                        echo '<div class="form-error">';
                        echo '<p>❌ ' . esc_html($error_message ?: 'Une erreur est survenue. Veuillez réessayer ou nous contacter par téléphone.') . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="form-error"><ul>';
                    foreach ($errors as $error) {
                        echo '<li>⚠️ ' . esc_html($error) . '</li>';
                    }
                    echo '</ul></div>';
                }
            }
            ?>

            <?php if (!$form_submitted_success) : ?>
                <form method="post" action="" class="demande-form" id="demande-form">
                    <?php wp_nonce_field('demande_chambre_action', 'demande_chambre_nonce'); ?>

                    <!-- ===== FILTRE DES CHAMBRES DISPONIBLES ===== -->
                    <?php if ($has_chambres) : ?>
                        <div class="chambre-filter">
                            <div class="filter-title">
                                <span class="filter-icon">🛏️</span>
                                <span>Choisissez votre chambre *</span>
                            </div>
                            <div class="chambre-options">
                                <?php foreach ($chambres_disponibles as $chambre) :
                                    $chambre_id = $chambre->ID;
                                    $chambre_info = foyerfsm_parse_chambre_id($chambre_id);
                                    $titre = $chambre_info['titre'];
                                ?>
                                    <div class="chambre-option <?php echo ($form_data['chambre_souhaitee'] == $chambre_id) ? 'selected' : ''; ?>">
                                        <label>
                                            <input type="radio" name="chambre_souhaitee" value="<?php echo esc_attr($chambre_id); ?>" <?php echo ($form_data['chambre_souhaitee'] == $chambre_id) ? 'checked' : ''; ?> required>
                                            <span class="chambre-name"><?php echo esc_html($titre); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p class="field-description">📝 Sélectionnez la chambre qui vous intéresse</p>
                        </div>
                    <?php else : ?>
                        <div class="no-chambres-message">
                            <p>⚠️ Aucune chambre n'est actuellement disponible. Veuillez nous contacter directement pour plus d'informations.</p>
                        </div>
                    <?php endif; ?>

                    <!-- SECTION RÉSIDENTE -->
                    <h2 class="form-section-title">Informations de la résidente</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" value="<?php echo esc_attr($form_data['nom']); ?>" required>
                            <p class="field-description">📝 Votre nom de famille</p>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom *</label>
                            <input type="text" id="prenom" name="prenom" value="<?php echo esc_attr($form_data['prenom']); ?>" required>
                            <p class="field-description">📝 Votre prénom</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_naissance">Date de naissance *</label>
                            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo esc_attr($form_data['date_naissance']); ?>" required>
                            <p class="field-description">📝 Le calcul majeur/mineur sera automatique</p>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo esc_attr($form_data['telephone']); ?>" required>
                            <p class="field-description">📝 Ex: 06 12 34 56 78</p>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="adresse">Adresse *</label>
                        <textarea id="adresse" name="adresse" rows="3" required><?php echo esc_textarea($form_data['adresse']); ?></textarea>
                        <p class="field-description">📝 Votre adresse postale complète</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo esc_attr($form_data['email']); ?>" required>
                            <p class="field-description">📝 Ex: prenom.nom@email.com</p>
                        </div>
                        <div class="form-group">
                            <label for="carte_etudiante">N° Carte Étudiante</label>
                            <input type="text" id="carte_etudiante" name="carte_etudiante" value="<?php echo esc_attr($form_data['carte_etudiante']); ?>">
                            <p class="field-description">📝 Optionnel</p>
                        </div>
                    </div>

                    <!-- SECTION RESPONSABLE LÉGAL -->
                    <div class="responsable-section" id="responsable-section" style="display: none;">
                        <h2 class="form-section-title">Coordonnées du responsable légal</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="responsable_nom">Nom et prénom *</label>
                                <input type="text" id="responsable_nom" name="responsable_nom" value="<?php echo esc_attr($form_data['responsable_nom']); ?>">
                                <p class="field-description">📝 Nom et prénom du parent ou tuteur</p>
                            </div>
                            <div class="form-group">
                                <label for="responsable_lien">Lien de parenté *</label>
                                <select id="responsable_lien" name="responsable_lien">
                                    <option value="">-- Choisir --</option>
                                    <option value="Père" <?php selected($form_data['responsable_lien'], 'Père'); ?>>Père</option>
                                    <option value="Mère" <?php selected($form_data['responsable_lien'], 'Mère'); ?>>Mère</option>
                                    <option value="Tuteur légal" <?php selected($form_data['responsable_lien'], 'Tuteur légal'); ?>>Tuteur légal</option>
                                </select>
                                <p class="field-description">📝 Relation avec la résidente</p>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="responsable_adresse">Adresse *</label>
                            <textarea id="responsable_adresse" name="responsable_adresse" rows="3"><?php echo esc_textarea($form_data['responsable_adresse']); ?></textarea>
                            <p class="field-description">📝 Adresse postale du responsable légal</p>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="responsable_telephone">Téléphone *</label>
                                <input type="tel" id="responsable_telephone" name="responsable_telephone" value="<?php echo esc_attr($form_data['responsable_telephone']); ?>">
                                <p class="field-description">📝 Téléphone du responsable</p>
                            </div>
                            <div class="form-group">
                                <label for="responsable_email">Email *</label>
                                <input type="email" id="responsable_email" name="responsable_email" value="<?php echo esc_attr($form_data['responsable_email']); ?>">
                                <p class="field-description">📝 Email du responsable</p>
                            </div>
                        </div>
                    </div>

                    <h2 class="form-section-title">Informations complémentaires</h2>
                    <div class="form-group full-width">
                        <label for="message">Message (optionnel)</label>
                        <textarea id="message" name="message" rows="4"><?php echo esc_textarea($form_data['message']); ?></textarea>
                        <p class="field-description">📝 Précisions souhaitées, questions, disponibilités, etc.</p>
                    </div>

                    <div class="confidentiality">
                        <label class="checkbox-label">
                            <input type="checkbox" name="confidentialite" required>
                            <span>J'accepte que mes données soient traitées pour ma demande de chambre.</span>
                        </label>
                        <p class="field-description">📝 Vos données sont confidentielles et ne seront pas partagées</p>
                    </div>

                    <div class="form-submit">
                        <button type="submit" name="submit_demande_chambre" class="btn-submit">
                            <?php 
                            $submit_text = get_option('demande_chambre_submit_text');
                            echo esc_html($submit_text ?: 'Envoyer ma demande'); 
                            ?>
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date_naissance');
    const responsableSection = document.getElementById('responsable-section');

    if (dateInput && responsableSection) {
        function checkAge() {
            if (!dateInput.value) return;
            const birthDate = new Date(dateInput.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) age--;
            if (age < 18) {
                responsableSection.style.display = 'block';
                ['responsable_nom', 'responsable_lien', 'responsable_adresse', 'responsable_telephone', 'responsable_email'].forEach(id => {
                    if (document.getElementById(id)) document.getElementById(id).required = true;
                });
            } else {
                responsableSection.style.display = 'none';
                ['responsable_nom', 'responsable_lien', 'responsable_adresse', 'responsable_telephone', 'responsable_email'].forEach(id => {
                    if (document.getElementById(id)) document.getElementById(id).required = false;
                });
            }
        }
        dateInput.addEventListener('change', checkAge);
        dateInput.addEventListener('blur', checkAge);
        if (dateInput.value) checkAge();
    }
});
</script>

<?php get_footer(); ?>