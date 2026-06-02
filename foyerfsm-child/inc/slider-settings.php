<?php
/**
 * Réglages Customizer - Slider, À propos, Nos Valeurs et Services
 */

// =============================================
// SECTION SLIDER
// =============================================
/* les options s'affichaint dans personnaliser => Desormais ils s'affichent dans "Option du theme
* Si besoin de revoir les options dans Personnaliser, il suffit de decommenter cecie
//  FIN
*****
add_action('customize_register', 'foyerfsm_slider_settings');
function foyerfsm_slider_settings($wp_customize) {
    $wp_customize->add_section('foyerfsm_slider_section', array(
        'title'    => '🎠 Slider accueil',
        'priority' => 35,
        'description' => 'Gérez les 3 slides de la page d\'accueil',
    ));
    
    // Vitesse du slider
    $wp_customize->add_setting('slider_speed', array(
        'default' => '5000',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('slider_speed', array(
        'label'   => 'Vitesse (ms)',
        'section' => 'foyerfsm_slider_section',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 2000,
            'max' => 10000,
            'step' => 500,
        ),
    ));

    // Slide 1
    $wp_customize->add_setting('slider_image_1', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slider_image_1', array(
        'label'    => '🖼️ Image - Slide 1',
        'section'  => 'foyerfsm_slider_section',
    )));
    
    $wp_customize->add_setting('slider_title_1', array(
        'default' => 'Bienvenue au Foyer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_title_1', array(
        'label'   => '📌 Titre - Slide 1',
        'section' => 'foyerfsm_slider_section',
    ));
    
    $wp_customize->add_setting('slider_text_1', array(
        'default' => '9 chambres étudiantes au cœur de Tours',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_text_1', array(
        'label'   => '📝 Texte - Slide 1',
        'section' => 'foyerfsm_slider_section',
    ));

    // Slide 2
    $wp_customize->add_setting('slider_image_2', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slider_image_2', array(
        'label'    => '🖼️ Image - Slide 2',
        'section'  => 'foyerfsm_slider_section',
    )));
    
    $wp_customize->add_setting('slider_title_2', array(
        'default' => 'Un cadre idéal pour étudier',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_title_2', array(
        'label'   => '📌 Titre - Slide 2',
        'section' => 'foyerfsm_slider_section',
    ));
    
    $wp_customize->add_setting('slider_text_2', array(
        'default' => 'Chambres avec douche et toilette privatives',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_text_2', array(
        'label'   => '📝 Texte - Slide 2',
        'section' => 'foyerfsm_slider_section',
    ));

    // Slide 3
    $wp_customize->add_setting('slider_image_3', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'slider_image_3', array(
        'label'    => '🖼️ Image - Slide 3',
        'section'  => 'foyerfsm_slider_section',
    )));
    
    $wp_customize->add_setting('slider_title_3', array(
        'default' => 'À 5 minutes du tram',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_title_3', array(
        'label'   => '📌 Titre - Slide 3',
        'section' => 'foyerfsm_slider_section',
    ));
    
    $wp_customize->add_setting('slider_text_3', array(
        'default' => 'Proche des facultés et commodités',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('slider_text_3', array(
        'label'   => '📝 Texte - Slide 3',
        'section' => 'foyerfsm_slider_section',
    ));
}

// =============================================
// SECTION À PROPOS (PAGE D'ACCUEIL)
// =============================================
add_action('customize_register', 'foyerfsm_about_settings');
function foyerfsm_about_settings($wp_customize) {
    $wp_customize->add_section('foyerfsm_about_section', array(
        'title'    => '🏠 À propos (page d\'accueil)',
        'priority' => 45,
        'description' => 'Personnalisez la section "À propos" de la page d\'accueil',
    ));

    // Titre de la section
    $wp_customize->add_setting('about_section_title', array(
        'default' => 'À propos de notre foyer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('about_section_title', array(
        'label'   => '📌 Titre de la section',
        'section' => 'foyerfsm_about_section',
        'type'    => 'text',
    ));

    // Texte principal
    $wp_customize->add_setting('about_text', array(
        'default' => 'Notre foyer, géré par des sœurs Franciscaines, offre un espace chaleureux et accueillant pour les étudiantes. Avec 9 chambres confortables, chacune avec sa salle de bain privée, vous bénéficierez d\'un cadre propice à l\'étude et à l\'épanouissement personnel. À deux pas de toutes les commodités, notre foyer représente une option idéale pour les étudiantes souhaitant vivre sereinement à Tours.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_text', array(
        'label'   => '📝 Texte de présentation',
        'section' => 'foyerfsm_about_section',
        'type'    => 'textarea',
    ));

    // Image
    $wp_customize->add_setting('about_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'about_image', array(
        'label'    => '🖼️ Photo du foyer',
        'section'  => 'foyerfsm_about_section',
    )));

    // Texte du bouton
    $wp_customize->add_setting('about_button_text', array(
        'default' => 'Lire plus sur le foyer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('about_button_text', array(
        'label'   => '🔘 Texte du bouton',
        'section' => 'foyerfsm_about_section',
        'type'    => 'text',
    ));

    // Lien du bouton (page "À propos")
    $wp_customize->add_setting('about_button_link', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('about_button_link', array(
        'label'   => '🔗 Lien du bouton',
        'section' => 'foyerfsm_about_section',
        'type'    => 'dropdown_pages',
        'description' => 'Choisissez la page "À propos" complète',
    ));
}

// =============================================
// SECTION NOS VALEURS (4 BLOCS)
// =============================================
add_action('customize_register', 'foyerfsm_values_settings');
function foyerfsm_values_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_values_section', array(
        'title'    => '✨ Nos Valeurs',
        'priority' => 50,
        'description' => 'Activez jusqu\'à 4 valeurs.',
    ));

    for ($i = 1; $i <= 4; $i++) {
        // Activation
        $wp_customize->add_setting("value_{$i}_active", array(
            'default' => $i <= 3 ? 1 : 0,
            'sanitize_callback' => 'wp_validate_boolean',
        ));
        $wp_customize->add_control("value_{$i}_active", array(
            'label'   => "✅ Activer valeur $i",
            'section' => 'foyerfsm_values_section',
            'type'    => 'checkbox',
        ));

        // Image
        $wp_customize->add_setting("value_{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, "value_{$i}_image", array(
            'label'    => "🖼️ Image $i",
            'section'  => 'foyerfsm_values_section',
        )));

        // Titre
        $wp_customize->add_setting("value_{$i}_title", array(
            'default' => "Valeur $i",
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("value_{$i}_title", array(
            'label'   => "📌 Titre $i",
            'section' => 'foyerfsm_values_section',
        ));

        // Description
        $wp_customize->add_setting("value_{$i}_text", array(
            'default' => "Description de la valeur $i.",
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("value_{$i}_text", array(
            'label'   => "📝 Description $i",
            'section' => 'foyerfsm_values_section',
            'type'    => 'textarea',
        ));
    }
}

// =============================================
// SECTION SERVICES (6 BLOCS)
// =============================================
add_action('customize_register', 'foyerfsm_services_settings');
function foyerfsm_services_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_services_section', array(
        'title'    => '🔧 Nos Services',
        'priority' => 55,
        'description' => 'Configurez jusqu\'à 6 services.',
    ));

    $icons = ['🏠', '🔒', '📍', '🙏', '📝', '🍽️'];
    $titles = ['Chambres Équipées', 'Sécurité', 'Localisation', 'Accompagnement', 'Admission', 'Cuisine'];
    $texts = [
        '9 chambres de 9m² à 14m², chacune avec douche et toilette privatives.',
        'Accès contrôlé et personnel disponible pour votre sécurité.',
        'À 5 min du tram et 15 min de la gare SNCF.',
        'Accompagnement spirituel à la demande.',
        'Faire une demande en ligne simplement.',
        'Grande cuisine commune entièrement équipée.'
    ];

    for ($i = 1; $i <= 6; $i++) {
        // Activation
        $wp_customize->add_setting("service_{$i}_active", array(
            'default' => $i <= 5 ? 1 : 0,
            'sanitize_callback' => 'wp_validate_boolean',
        ));
        $wp_customize->add_control("service_{$i}_active", array(
            'label'   => "✅ Activer service $i",
            'section' => 'foyerfsm_services_section',
            'type'    => 'checkbox',
        ));

        // Icône
        $wp_customize->add_setting("service_{$i}_icon", array(
            'default' => $icons[$i-1],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("service_{$i}_icon", array(
            'label'   => "🔹 Icône $i",
            'section' => 'foyerfsm_services_section',
            'type'    => 'text',
            'description' => 'Emoji ou caractère spécial',
        ));

        // Titre
        $wp_customize->add_setting("service_{$i}_title", array(
            'default' => $titles[$i-1],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("service_{$i}_title", array(
            'label'   => "📌 Titre $i",
            'section' => 'foyerfsm_services_section',
        ));

        // Description
        $wp_customize->add_setting("service_{$i}_text", array(
            'default' => $texts[$i-1],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("service_{$i}_text", array(
            'label'   => "📝 Description $i",
            'section' => 'foyerfsm_services_section',
            'type'    => 'textarea',
        ));
    }
}
// =============================================
// SECTION GALERIE
// =============================================
add_action('customize_register', 'foyerfsm_gallery_settings');
function foyerfsm_gallery_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_gallery_section', array(
        'title'    => '📸 Galerie photos',
        'priority' => 60,
        'description' => 'Gérez les photos des chambres et espaces communs.',
    ));

    // ===== TITRE DE LA SECTION =====
    $wp_customize->add_setting('gallery_title', array(
        'default' => 'Découvrez notre foyer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gallery_title', array(
        'label'   => 'Titre de la galerie',
        'section' => 'foyerfsm_gallery_section',
        'type'    => 'text',
    ));

    // ===== SOUS-TITRE =====
    $wp_customize->add_setting('gallery_subtitle', array(
        'default' => 'Photos des chambres et espaces de vie',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gallery_subtitle', array(
        'label'   => 'Sous-titre',
        'section' => 'foyerfsm_gallery_section',
        'type'    => 'text',
    ));

    // ===== NOMBRE DE PHOTOS À AFFICHER =====
    $wp_customize->add_setting('gallery_count', array(
        'default' => 9,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('gallery_count', array(
        'label'   => 'Nombre de photos à afficher',
        'section' => 'foyerfsm_gallery_section',
        'type'    => 'number',
        'input_attrs' => array('min' => 3, 'max' => 30),
    ));

    // ===== FILTRES PAR CATÉGORIE =====
    $wp_customize->add_setting('gallery_show_filters', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('gallery_show_filters', array(
        'label'   => 'Afficher les filtres par catégorie',
        'section' => 'foyerfsm_gallery_section',
        'type'    => 'checkbox',
    ));

    // ===== STYLE D'AFFICHAGE =====
    $wp_customize->add_setting('gallery_style', array(
        'default' => 'grid',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gallery_style', array(
        'label'   => 'Style d\'affichage',
        'section' => 'foyerfsm_gallery_section',
        'type'    => 'select',
        'choices' => array(
            'grid' => 'Grille (recommandé)',
            'masonry' => 'Masonry (décalé)',
            'carousel' => 'Carrousel',
        ),
    ));
}
// =============================================
// SECTION GALERIE AVANCÉE
// =============================================
add_action('customize_register', 'foyerfsm_gallery_advanced_settings');
function foyerfsm_gallery_advanced_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_gallery_advanced', array(
        'title'    => '📸 Galerie (catégories)',
        'priority' => 60,
        'description' => 'Configurez l\'affichage des photos par catégorie.',
    ));

    // Titre
    $wp_customize->add_setting('gallery_advanced_title', array(
        'default' => 'Découvrez notre foyer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gallery_advanced_title', array(
        'label'   => 'Titre',
        'section' => 'foyerfsm_gallery_advanced',
        'type'    => 'text',
    ));

    // Sous-titre
    $wp_customize->add_setting('gallery_advanced_subtitle', array(
        'default' => 'Chambres, espaces communs et extérieur',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('gallery_advanced_subtitle', array(
        'label'   => 'Sous-titre',
        'section' => 'foyerfsm_gallery_advanced',
        'type'    => 'text',
    ));

    // Nombre d'images par catégorie
    $wp_customize->add_setting('gallery_images_per_category', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('gallery_images_per_category', array(
        'label'   => 'Images par catégorie',
        'section' => 'foyerfsm_gallery_advanced',
        'type'    => 'number',
        'input_attrs' => array('min' => 3, 'max' => 15),
    ));

    // Colonnes
    $wp_customize->add_setting('gallery_columns', array(
        'default' => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('gallery_columns', array(
        'label'   => 'Nombre de colonnes',
        'section' => 'foyerfsm_gallery_advanced',
        'type'    => 'number',
        'input_attrs' => array('min' => 2, 'max' => 4),
    ));

    // Lignes
    $wp_customize->add_setting('gallery_rows', array(
        'default' => 2,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('gallery_rows', array(
        'label'   => 'Nombre de lignes',
        'section' => 'foyerfsm_gallery_advanced',
        'type'    => 'number',
        'input_attrs' => array('min' => 1, 'max' => 3),
    ));
}
// =============================================
// SECTION PAGE À PROPOS
// =============================================
add_action('customize_register', 'foyerfsm_about_page_settings');
function foyerfsm_about_page_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_about_page', array(
        'title'    => '📖 Page À propos',
        'priority' => 65,
        'description' => 'Personnalisez le contenu de la page "À propos".',
    ));

    // Message de la Supérieure
    $wp_customize->add_setting('about_superior_message', array(
        'default' => '<p>Chers amis,</p><p>Nous nous préparons à dire au revoir à l\'année 2025 et attendons avec impatience l\'arrivée de la nouvelle année 2026...</p>',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_superior_message', array(
        'label'   => 'Message de la Supérieure',
        'section' => 'foyerfsm_about_page',
        'type'    => 'textarea',
    ));

    // Image de la Supérieure
    $wp_customize->add_setting('about_superior_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'about_superior_image', array(
        'label'    => 'Photo de la Supérieure',
        'section'  => 'foyerfsm_about_page',
    )));

    // Histoire de l'étoile de mer
    $wp_customize->add_setting('about_starfish_text', array(
        'default' => '<p>« Jim avait l\'habitude de se promener sur la plage...</p>',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_starfish_text', array(
        'label'   => 'Histoire de l\'étoile de mer',
        'section' => 'foyerfsm_about_page',
        'type'    => 'textarea',
    ));
}
// =============================================
// SECTION PAGE CONTACT - DEMANDE DE CHAMBRE
// =============================================
add_action('customize_register', 'foyerfsm_contact_page_settings');
function foyerfsm_contact_page_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_contact_page', array(
        'title'    => '📝 Page Contact - Demande',
        'priority' => 70,
        'description' => 'Personnalisez la page de demande de chambre',
    ));

    // ===== HERO =====
    $wp_customize->add_setting('contact_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'contact_hero_image', array(
        'label'    => '🖼️ Image d\'en-tête',
        'section'  => 'foyerfsm_contact_page',
    )));

    $wp_customize->add_setting('contact_page_title', array(
        'default' => 'Demander une chambre',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_page_title', array(
        'label'   => '📌 Titre de la page',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_page_subtitle', array(
        'default' => 'Remplissez le formulaire ci-dessous pour votre demande de réservation',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_page_subtitle', array(
        'label'   => '📝 Sous-titre',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== TEXTE INTRO =====
    $wp_customize->add_setting('contact_intro_text', array(
        'default' => '<p>Merci de remplir ce formulaire de demande de chambre. Nous vous recontacterons dans les plus brefs délais pour vous informer des disponibilités.</p>',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('contact_intro_text', array(
        'label'   => '📋 Message d\'introduction',
        'section' => 'foyerfsm_contact_page',
        'type'    => 'textarea',
    ));

    // ===== LABELS DU FORMULAIRE =====
    $wp_customize->add_setting('contact_section_residente', array(
        'default' => 'Informations de la résidente',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_section_residente', array(
        'label'   => '🏷️ Titre section résidente',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_nom', array(
        'default' => 'Nom *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_nom', array(
        'label'   => '🏷️ Label "Nom"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_prenom', array(
        'default' => 'Prénom *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_prenom', array(
        'label'   => '🏷️ Label "Prénom"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_date', array(
        'default' => 'Date de naissance *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_date', array(
        'label'   => '🏷️ Label "Date de naissance"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_date_info', array(
        'default' => 'Le calcul majeur/mineur sera automatique',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_date_info', array(
        'label'   => 'ℹ️ Info date',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_adresse', array(
        'default' => 'Adresse *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_adresse', array(
        'label'   => '🏷️ Label "Adresse"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_telephone', array(
        'default' => 'Téléphone *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_telephone', array(
        'label'   => '🏷️ Label "Téléphone"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_email', array(
        'default' => 'Email *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_email', array(
        'label'   => '🏷️ Label "Email"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_carte', array(
        'default' => 'N° Carte Étudiante',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_carte', array(
        'label'   => '🏷️ Label "Carte étudiante"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_carte_info', array(
        'default' => 'Optionnel',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_carte_info', array(
        'label'   => 'ℹ️ Info carte',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== SECTION RESPONSABLE =====
    $wp_customize->add_setting('contact_section_responsable', array(
        'default' => 'Coordonnées du responsable légal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_section_responsable', array(
        'label'   => '🏷️ Titre section responsable',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_responsable_nom', array(
        'default' => 'Nom et prénom *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_responsable_nom', array(
        'label'   => '🏷️ Label "Responsable nom"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_responsable_lien', array(
        'default' => 'Père - Mère - Autre *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_responsable_lien', array(
        'label'   => '🏷️ Label "Lien"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_responsable_adresse', array(
        'default' => 'Adresse *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_responsable_adresse', array(
        'label'   => '🏷️ Label "Responsable adresse"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_responsable_telephone', array(
        'default' => 'Téléphone *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_responsable_telephone', array(
        'label'   => '🏷️ Label "Responsable téléphone"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_responsable_email', array(
        'default' => 'Email *',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_responsable_email', array(
        'label'   => '🏷️ Label "Responsable email"',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== SECTION COMPLÉMENTAIRE =====
    $wp_customize->add_setting('contact_section_plus', array(
        'default' => 'Informations complémentaires',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_section_plus', array(
        'label'   => '🏷️ Titre section complémentaire',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_label_message', array(
        'default' => 'Message (optionnel)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_label_message', array(
        'label'   => '🏷️ Label "Message"',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_message_info', array(
        'default' => 'Précisions souhaitées, questions, etc.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_message_info', array(
        'label'   => 'ℹ️ Info message',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== CONFIDENTIALITÉ =====
    $wp_customize->add_setting('contact_confidentialite_text', array(
        'default' => 'J\'accepte que mes données soient traitées pour ma demande de chambre. Consultez notre <a href="/politique-de-confidentialite">politique de confidentialité</a>.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('contact_confidentialite_text', array(
        'label'   => '🔒 Texte confidentialité',
        'section' => 'foyerfsm_contact_page',
        'type'    => 'textarea',
    ));

    // ===== BOUTON =====
    $wp_customize->add_setting('contact_submit_text', array(
        'default' => 'Envoyer ma demande',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_submit_text', array(
        'label'   => '🔘 Texte du bouton',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== MESSAGES DE RETOUR =====
    $wp_customize->add_setting('contact_success_title', array(
        'default' => 'Merci pour votre demande !',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_success_title', array(
        'label'   => '✅ Titre succès',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_success_message', array(
        'default' => 'Votre demande a bien été envoyée. Nous vous recontacterons très rapidement.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_success_message', array(
        'label'   => '✅ Message succès',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_error_message', array(
        'default' => 'Une erreur est survenue. Veuillez réessayer ou nous contacter par téléphone.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_error_message', array(
        'label'   => '❌ Message erreur',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== EMAIL =====
    $wp_customize->add_setting('contact_email_soeurs', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email_soeurs', array(
        'label'   => '📧 Email de réception',
        'section' => 'foyerfsm_contact_page',
        'description' => 'Les demandes seront envoyées à cette adresse',
    ));

    $wp_customize->add_setting('contact_email_subject', array(
        'default' => 'Nouvelle demande de chambre',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_email_subject', array(
        'label'   => '📧 Sujet de l\'email',
        'section' => 'foyerfsm_contact_page',
    ));

    // ===== INFORMATIONS DE CONTACT =====
    $wp_customize->add_setting('contact_info_title', array(
        'default' => 'Vous préférez nous appeler ?',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_info_title', array(
        'label'   => '📞 Titre bloc contact',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_info_text', array(
        'default' => 'N\'hésitez pas à nous contacter directement par téléphone ou email.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_info_text', array(
        'label'   => '📞 Texte bloc contact',
        'section' => 'foyerfsm_contact_page',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default' => '01 23 45 67 89',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label'   => '📞 Téléphone',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default' => 'contact@foyer.fr',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email', array(
        'label'   => '📧 Email de contact',
        'section' => 'foyerfsm_contact_page',
    ));

    $wp_customize->add_setting('contact_address', array(
        'default' => '15 rue Monin, 41000 BLOIS',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_address', array(
        'label'   => '📍 Adresse',
        'section' => 'foyerfsm_contact_page',
    ));
}

*/