<?php
/* phpcs:disable */
/* VS Code - Ce fichier est du PHP, ignorer l'analyse JavaScript */

/**
 * Options du thème - Menu dédié dans l'administration
 */

// Ajouter le menu dans l'admin
add_action('admin_menu', 'foyerfsm_add_theme_options_page');
function foyerfsm_add_theme_options_page()
{
    add_menu_page(
        'Options du thème',      // Titre de la page
        'Options Foyer',         // Titre du menu
        'manage_options',        // Capacité requise
        'foyerfsm-options',      // Slug
        'foyerfsm_render_options_page', // Fonction d'affichage
        'dashicons-admin-generic', // Icône
        30                        // Position
    );
}

// Fonction d'affichage de la page d'options
function foyerfsm_render_options_page()
{
?>
    <div class="wrap">
        <h1>Options du thème Foyer FSM</h1>

        <div class="notice notice-info">
            <p>Bienvenue dans la gestion des options du thème. Utilisez les onglets ci-dessous pour configurer chaque section.</p>
        </div>

        <?php
        // Afficher les onglets
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=foyerfsm-options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">⚙️ Général</a>
            <a href="?page=foyerfsm-options&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">🏠 À propos accueil</a>
            <a href="?page=foyerfsm-options&tab=apropos" class="nav-tab <?php echo $active_tab == 'apropos' ? 'nav-tab-active' : ''; ?>">📄 Page À propos</a>
            <a href="?page=foyerfsm-options&tab=values" class="nav-tab <?php echo $active_tab == 'values' ? 'nav-tab-active' : ''; ?>">✨ Valeurs</a>
            <a href="?page=foyerfsm-options&tab=services" class="nav-tab <?php echo $active_tab == 'services' ? 'nav-tab-active' : ''; ?>">🔧 Services accueil</a>
            <a href="?page=foyerfsm-options&tab=services-page" class="nav-tab <?php echo $active_tab == 'services-page' ? 'nav-tab-active' : ''; ?>">📄 Page Services</a>
            <a href="?page=foyerfsm-options&tab=gallery" class="nav-tab <?php echo $active_tab == 'gallery' ? 'nav-tab-active' : ''; ?>">📸 Galeries</a>
            <a href="?page=foyerfsm-options&tab=informations" class="nav-tab <?php echo $active_tab == 'informations' ? 'nav-tab-active' : ''; ?>">📋 Informations</a>
            <a href="?page=foyerfsm-options&tab=footer" class="nav-tab <?php echo $active_tab == 'footer' ? 'nav-tab-active' : ''; ?>">🔻 Footer</a>
            <a href="?page=foyerfsm-options&tab=contact" class="nav-tab <?php echo $active_tab == 'contact' ? 'nav-tab-active' : ''; ?>">📝 Contact</a>
            <a href="?page=foyerfsm-options&tab=demande-chambre" class="nav-tab <?php echo $active_tab == 'demande-chambre' ? 'nav-tab-active' : ''; ?>">📝 Page Demander une chambre</a>
            <a href="?page=foyerfsm-options&tab=hero-student" class="nav-tab <?php echo $active_tab == 'hero-student' ? 'nav-tab-active' : ''; ?>">🎓 Slider</a>
            <a href="?page=foyerfsm-options&tab=page-chambres" class="nav-tab <?php echo $active_tab == 'page-chambres' ? 'nav-tab-active' : ''; ?>">🏠 Page Nos chambres</a>
        </h2>

        <form method="post" action="options.php">
            <?php
            // Déterminer quelle section afficher
            switch ($active_tab) {
                case 'general':
                    settings_fields('foyerfsm_general_options');
                    do_settings_sections('foyerfsm-general');
                    break;
                case 'about':
                    settings_fields('foyerfsm_about_options');
                    do_settings_sections('foyerfsm-about');
                    break;
                case 'apropos':
                    settings_fields('foyerfsm_apropos_options');

                    // Récupérer le sous-onglet actif
                    $apropos_subtab = isset($_GET['apropos_subtab']) ? $_GET['apropos_subtab'] : 'hero';

                    // Afficher les sous-onglets
            ?>
                    <div class="apropos-subtabs" style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #c3c4c7;">
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=hero" class="button <?php echo $apropos_subtab === 'hero' ? 'button-primary' : ''; ?>">🏠 Hero</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=superior" class="button <?php echo $apropos_subtab === 'superior' ? 'button-primary' : ''; ?>">✉️ Supérieure</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=starfish" class="button <?php echo $apropos_subtab === 'starfish' ? 'button-primary' : ''; ?>">⭐ Étoile de mer</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=history" class="button <?php echo $apropos_subtab === 'history' ? 'button-primary' : ''; ?>">📜 Histoire</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=events" class="button <?php echo $apropos_subtab === 'events' ? 'button-primary' : ''; ?>">📅 Événements</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=missions" class="button <?php echo $apropos_subtab === 'missions' ? 'button-primary' : ''; ?>">🌍 Missions</a>
                        <a href="?page=foyerfsm-options&tab=apropos&apropos_subtab=support" class="button <?php echo $apropos_subtab === 'support' ? 'button-primary' : ''; ?>">💝 Soutien</a>
                    </div>

                    <div id="apropos-tab-content">
                        <?php do_settings_sections('foyerfsm-apropos'); ?>
                    </div>

                    <style>
                        /* Cacher toutes les sections par défaut */
                        .form-table {
                            display: none !important;
                        }

                        /* Afficher uniquement la section correspondant au sous-onglet */
                        <?php
                        if ($apropos_subtab === 'hero') echo '.form-table:first-of-type { display: table !important; }';
                        elseif ($apropos_subtab === 'superior') echo '.form-table:nth-of-type(2) { display: table !important; }';
                        elseif ($apropos_subtab === 'starfish') echo '.form-table:nth-of-type(3) { display: table !important; }';
                        elseif ($apropos_subtab === 'history') echo '.form-table:nth-of-type(4) { display: table !important; }';
                        elseif ($apropos_subtab === 'events') echo '.form-table:nth-of-type(5) { display: table !important; }';
                        elseif ($apropos_subtab === 'missions') echo '.form-table:nth-of-type(6) { display: table !important; }';
                        elseif ($apropos_subtab === 'support') echo '.form-table:nth-of-type(7) { display: table !important; }';
                        ?>
                    </style>
            <?php
                    break;
                case 'values':
                    settings_fields('foyerfsm_values_options');
                    do_settings_sections('foyerfsm-values');
                    break;
                case 'services':
                    settings_fields('foyerfsm_services_options');
                    do_settings_sections('foyerfsm-services');
                    break;
                case 'gallery':
                    settings_fields('foyerfsm_gallery_options');
                    do_settings_sections('foyerfsm-gallery');
                    break;
                case 'informations':
                    settings_fields('foyerfsm_informations_options');
                    do_settings_sections('foyerfsm-informations');
                    break;
                case 'services-page':
                    settings_fields('foyerfsm_services_page_options');
                    do_settings_sections('foyerfsm-services-page');
                    break;
                case 'contact':
                    settings_fields('foyerfsm_contact_options');
                    do_settings_sections('foyerfsm-contact');
                    break;
                case 'demande-chambre':
                    settings_fields('foyerfsm_demande_chambre_options');
                    do_settings_sections('foyerfsm-demande-chambre');
                    break;
                case 'footer':
                    settings_fields('foyerfsm_footer_options');
                    do_settings_sections('foyerfsm-footer');
                    break;
                case 'hero-student':
                    settings_fields('foyerfsm_hero_student_options');
                    do_settings_sections('foyerfsm-hero-student');
                    break;
                case 'page-chambres':
                    settings_fields('foyerfsm_page_chambres_options');
                    do_settings_sections('foyerfsm-page-chambres');
                    break;
                case 'chambres-disponibles':
                    settings_fields('foyerfsm_chambres_disponibles_options');
                    do_settings_sections('foyerfsm-chambres-disponibles');
                    break;
            }
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// =============================================
// OPTIONS DU HERO ÉTUDIANT (SLIDER 3 SLIDES)
// =============================================

add_filter('foyerfsm_options_tabs', function ($tabs) {
    $tabs['hero-student'] = '🎓 Slide principal';
    return $tabs;
});

add_action('admin_init', 'foyerfsm_register_hero_student_options');
function foyerfsm_register_hero_student_options()
{
    register_setting('foyerfsm_hero_student_options', 'hero_student_slider_speed');

    for ($i = 1; $i <= 3; $i++) {
        register_setting('foyerfsm_hero_student_options', "hero_student_image_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_surtitre_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_titre_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_texte_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_cta_primaire_texte_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_cta_primaire_lien_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_cta_secondaire_texte_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_cta_secondaire_lien_$i");
        register_setting('foyerfsm_hero_student_options', "hero_student_reassurance_$i");
    }

    add_settings_section(
        'foyerfsm_hero_student_main',
        '🎠 Configuration du slider étudiant',
        'foyerfsm_hero_student_intro',
        'foyerfsm-hero-student'
    );

    add_settings_field(
        'hero_student_slider_speed',
        'Vitesse du slider (ms)',
        'foyerfsm_number_field',
        'foyerfsm-hero-student',
        'foyerfsm_hero_student_main',
        array('name' => 'hero_student_slider_speed', 'default' => 5000, 'min' => 2000, 'max' => 10000, 'step' => 500)
    );

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field(
            "hero_student_image_$i",
            "Image Slide $i",
            'foyerfsm_media_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_image_$i")
        );

        add_settings_field(
            "hero_student_surtitre_$i",
            "Sur-titre Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_surtitre_$i", 'default' => 'Foyer étudiant à Tours')
        );

        add_settings_field(
            "hero_student_titre_$i",
            "Titre principal Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_titre_$i", 'default' => 'Chambres étudiantes meublées dans un cadre calme et sécurisé')
        );

        add_settings_field(
            "hero_student_texte_$i",
            "Texte descriptif Slide $i",
            'foyerfsm_textarea_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_texte_$i", 'default' => 'Pour étudiantes uniquement. 9 chambres avec salle d\'eau privative, à proximité du tramway et des commodités.')
        );

        add_settings_field(
            "hero_student_cta_primaire_texte_$i",
            "Texte bouton principal Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_cta_primaire_texte_$i", 'default' => 'Voir les chambres')
        );

        add_settings_field(
            "hero_student_cta_primaire_lien_$i",
            "Lien bouton principal Slide $i",
            'foyerfsm_page_dropdown',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_cta_primaire_lien_$i")
        );

        add_settings_field(
            "hero_student_cta_secondaire_texte_$i",
            "Texte bouton secondaire Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_cta_secondaire_texte_$i", 'default' => 'Demander une chambre')
        );

        add_settings_field(
            "hero_student_cta_secondaire_lien_$i",
            "Lien bouton secondaire Slide $i",
            'foyerfsm_page_dropdown',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_cta_secondaire_lien_$i")
        );

        add_settings_field(
            "hero_student_reassurance_$i",
            "Texte de réassurance Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-hero-student',
            'foyerfsm_hero_student_main',
            array('name' => "hero_student_reassurance_$i", 'default' => 'Visites et demandes en ligne selon les disponibilités')
        );
    }
}

function foyerfsm_hero_student_intro()
{
    echo '<p class="description">Configurez les 3 slides du hero étudiant. Chaque slide a son propre contenu et sa propre image.</p>';
}

// =============================================
// ENREGISTREMENT DES OPTIONS
// =============================================
add_action('admin_init', 'foyerfsm_register_all_options');
function foyerfsm_register_all_options()
{
    // ===== SECTION SLIDER =====
    register_setting('foyerfsm_slider_options', 'slider_speed');
    register_setting('foyerfsm_slider_options', 'slider_button_text');
    register_setting('foyerfsm_slider_options', 'slider_button_link');
    for ($i = 1; $i <= 3; $i++) {
        register_setting('foyerfsm_slider_options', "slider_image_$i");
        register_setting('foyerfsm_slider_options', "slider_title_$i");
        register_setting('foyerfsm_slider_options', "slider_text_$i");
    }

    add_settings_section('foyerfsm_slider_main', 'Configuration du slider', '__return_empty_string', 'foyerfsm-slider');

    add_settings_field(
        'slider_speed',
        'Vitesse (ms)',
        'foyerfsm_number_field',
        'foyerfsm-slider',
        'foyerfsm_slider_main',
        array('name' => 'slider_speed', 'default' => 5000, 'min' => 2000, 'max' => 10000, 'step' => 500)
    );

    add_settings_field(
        'slider_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-slider',
        'foyerfsm_slider_main',
        array('name' => 'slider_button_text', 'default' => 'Demander une chambre')
    );

    add_settings_field(
        'slider_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-slider',
        'foyerfsm_slider_main',
        array('name' => 'slider_button_link')
    );

    for ($i = 1; $i <= 3; $i++) {
        add_settings_field(
            "slider_image_$i",
            "Image Slide $i",
            'foyerfsm_media_field',
            'foyerfsm-slider',
            'foyerfsm_slider_main',
            array('name' => "slider_image_$i")
        );
        add_settings_field(
            "slider_title_$i",
            "Titre Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-slider',
            'foyerfsm_slider_main',
            array('name' => "slider_title_$i", 'default' => $i == 1 ? 'Bienvenue au Foyer' : ($i == 2 ? 'Un cadre idéal pour étudier' : 'À 5 minutes du tram'))
        );
        add_settings_field(
            "slider_text_$i",
            "Texte Slide $i",
            'foyerfsm_text_field',
            'foyerfsm-slider',
            'foyerfsm_slider_main',
            array('name' => "slider_text_$i", 'default' => $i == 1 ? '9 chambres étudiantes au cœur de Tours' : ($i == 2 ? 'Chambres avec douche et toilette privatives' : 'Proche des facultés et commodités'))
        );
    }

    // ===== SECTION À PROPOS =====
    register_setting('foyerfsm_about_options', 'about_section_title');
    register_setting('foyerfsm_about_options', 'about_text');
    register_setting('foyerfsm_about_options', 'about_image');
    register_setting('foyerfsm_about_options', 'about_button_text');
    register_setting('foyerfsm_about_options', 'about_button_link');

    add_settings_section('foyerfsm_about_main', 'Section "À propos" de l\'accueil', '__return_empty_string', 'foyerfsm-about');

    add_settings_field(
        'about_section_title',
        'Titre',
        'foyerfsm_text_field',
        'foyerfsm-about',
        'foyerfsm_about_main',
        array('name' => 'about_section_title', 'default' => 'À propos de notre foyer')
    );
    add_settings_field(
        'about_text',
        'Texte',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-about',
        'foyerfsm_about_main',
        array('name' => 'about_text', 'default' => 'Notre foyer, géré par des sœurs Franciscaines, offre un espace chaleureux...')
    );
    add_settings_field(
        'about_image',
        'Image',
        'foyerfsm_media_field_with_hint',
        'foyerfsm-about',
        'foyerfsm_about_main',
        array(
            'name' => 'about_image',
            'description' => '📐 Taille recommandée : 400x300px (format paysage) pour un affichage optimal'
        )
    );
    add_settings_field(
        'about_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-about',
        'foyerfsm_about_main',
        array('name' => 'about_button_text', 'default' => 'Lire plus sur le foyer')
    );
    add_settings_field(
        'about_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-about',
        'foyerfsm_about_main',
        array('name' => 'about_button_link')
    );

    // ===== SECTION VALEURS (4 BLOCS) =====
    register_setting('foyerfsm_values_options', 'values_section_title');
    for ($i = 1; $i <= 4; $i++) {
        register_setting('foyerfsm_values_options', "value_{$i}_active");
        register_setting('foyerfsm_values_options', "value_{$i}_image");
        register_setting('foyerfsm_values_options', "value_{$i}_title");
        register_setting('foyerfsm_values_options', "value_{$i}_text");
    }

    add_settings_section('foyerfsm_values_main', 'Configuration des valeurs', '__return_empty_string', 'foyerfsm-values');

    add_settings_field(
        'values_section_title',
        'Titre de la section',
        'foyerfsm_text_field',
        'foyerfsm-values',
        'foyerfsm_values_main',
        array('name' => 'values_section_title', 'default' => 'Nos Valeurs')
    );

    for ($i = 1; $i <= 4; $i++) {
        add_settings_field(
            "value_{$i}_active",
            "Valeur $i - Activer",
            'foyerfsm_checkbox_field',
            'foyerfsm-values',
            'foyerfsm_values_main',
            array('name' => "value_{$i}_active", 'default' => $i <= 3 ? 1 : 0)
        );
        add_settings_field(
            "value_{$i}_image",
            "Image $i",
            'foyerfsm_media_field',
            'foyerfsm-values',
            'foyerfsm_values_main',
            array('name' => "value_{$i}_image")
        );
        add_settings_field(
            "value_{$i}_title",
            "Titre $i",
            'foyerfsm_text_field',
            'foyerfsm-values',
            'foyerfsm_values_main',
            array('name' => "value_{$i}_title", 'default' => "Valeur $i")
        );
        add_settings_field(
            "value_{$i}_text",
            "Description $i",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-values',
            'foyerfsm_values_main',
            array('name' => "value_{$i}_text", 'default' => "Description de la valeur $i.")
        );
    }

    // ===== SECTION SERVICES (6 BLOCS) =====
    register_setting('foyerfsm_services_options', 'services_section_title');
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
        register_setting('foyerfsm_services_options', "service_{$i}_active");
        register_setting('foyerfsm_services_options', "service_{$i}_icon");
        register_setting('foyerfsm_services_options', "service_{$i}_title");
        register_setting('foyerfsm_services_options', "service_{$i}_text");
    }

    add_settings_section('foyerfsm_services_main', 'Configuration des services', '__return_empty_string', 'foyerfsm-services');

    add_settings_field(
        'services_section_title',
        'Titre de la section',
        'foyerfsm_text_field',
        'foyerfsm-services',
        'foyerfsm_services_main',
        array('name' => 'services_section_title', 'default' => 'Nos Services')
    );

    for ($i = 1; $i <= 6; $i++) {
        add_settings_field(
            "service_{$i}_active",
            "Service $i - Activer",
            'foyerfsm_checkbox_field',
            'foyerfsm-services',
            'foyerfsm_services_main',
            array('name' => "service_{$i}_active", 'default' => $i <= 5 ? 1 : 0)
        );
        add_settings_field(
            "service_{$i}_icon",
            "Icône $i",
            'foyerfsm_text_field',
            'foyerfsm-services',
            'foyerfsm_services_main',
            array('name' => "service_{$i}_icon", 'default' => $icons[$i - 1])
        );
        add_settings_field(
            "service_{$i}_title",
            "Titre $i",
            'foyerfsm_text_field',
            'foyerfsm-services',
            'foyerfsm_services_main',
            array('name' => "service_{$i}_title", 'default' => $titles[$i - 1])
        );
        add_settings_field(
            "service_{$i}_text",
            "Description $i",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-services',
            'foyerfsm_services_main',
            array('name' => "service_{$i}_text", 'default' => $texts[$i - 1])
        );
    }

    // ===== SECTION GALERIES =====
    register_setting('foyerfsm_gallery_options', 'gallery_title');
    register_setting('foyerfsm_gallery_options', 'gallery_subtitle');

    register_setting('foyerfsm_gallery_options', 'gallery_all_slider_speed');
    register_setting('foyerfsm_gallery_options', 'gallery_all_slider_images_per_line');

    register_setting('foyerfsm_gallery_options', 'gallery_chambres_title');
    register_setting('foyerfsm_gallery_options', 'gallery_chambres_images_per_category');
    register_setting('foyerfsm_gallery_options', 'gallery_chambres_columns');
    register_setting('foyerfsm_gallery_options', 'gallery_chambres_rows');
    register_setting('foyerfsm_gallery_options', 'gallery_chambres_slider_images');

    register_setting('foyerfsm_gallery_options', 'gallery_communs_title');
    register_setting('foyerfsm_gallery_options', 'gallery_communs_images_per_category');
    register_setting('foyerfsm_gallery_options', 'gallery_communs_columns');
    register_setting('foyerfsm_gallery_options', 'gallery_communs_rows');

    register_setting('foyerfsm_gallery_options', 'gallery_exterieur_title');
    register_setting('foyerfsm_gallery_options', 'gallery_exterieur_images_per_category');
    register_setting('foyerfsm_gallery_options', 'gallery_exterieur_columns');
    register_setting('foyerfsm_gallery_options', 'gallery_exterieur_rows');

    add_settings_section('foyerfsm_gallery_main', 'Configuration de la galerie', '__return_empty_string', 'foyerfsm-gallery');

    add_settings_field(
        'gallery_title',
        'Titre principal',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_title', 'default' => 'Découvrez notre foyer')
    );
    add_settings_field(
        'gallery_subtitle',
        'Sous-titre',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_subtitle', 'default' => 'Chambres, espaces communs et extérieur')
    );

    add_settings_field(
        'gallery_all_slider_speed',
        'Vitesse du slider (ms)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_all_slider_speed', 'default' => 3000, 'min' => 1000, 'max' => 10000, 'step' => 500)
    );
    add_settings_field(
        'gallery_all_slider_images_per_line',
        'Images par ligne dans le slider',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_all_slider_images_per_line', 'default' => 5, 'min' => 3, 'max' => 8)
    );

    add_settings_field(
        'gallery_chambres_title',
        'Titre de la catégorie Chambres',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_chambres_title', 'default' => 'Nos chambres')
    );
    add_settings_field(
        'gallery_chambres_images_per_category',
        'Images par catégorie (Chambres)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_chambres_images_per_category', 'default' => 9, 'min' => 3, 'max' => 30)
    );
    add_settings_field(
        'gallery_chambres_columns',
        'Colonnes (Chambres)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_chambres_columns', 'default' => 3, 'min' => 2, 'max' => 4)
    );
    add_settings_field(
        'gallery_chambres_rows',
        'Lignes (Chambres)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_chambres_rows', 'default' => 3, 'min' => 1, 'max' => 4)
    );
    add_settings_field(
        'gallery_chambres_slider_images',
        'Images du slider (IDs séparés par des virgules)',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_chambres_slider_images', 'default' => '', 'description' => 'Entrez les IDs des 3 images pour le slider (ex: 45,67,89)')
    );

    add_settings_field(
        'gallery_communs_title',
        'Titre de la catégorie Espaces communs',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_communs_title', 'default' => 'Espaces de vie')
    );
    add_settings_field(
        'gallery_communs_images_per_category',
        'Images par catégorie (Espaces communs)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_communs_images_per_category', 'default' => 6, 'min' => 3, 'max' => 30)
    );
    add_settings_field(
        'gallery_communs_columns',
        'Colonnes (Espaces communs)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_communs_columns', 'default' => 3, 'min' => 2, 'max' => 4)
    );
    add_settings_field(
        'gallery_communs_rows',
        'Lignes (Espaces communs)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_communs_rows', 'default' => 1, 'min' => 1, 'max' => 3)
    );

    add_settings_field(
        'gallery_exterieur_title',
        'Titre de la catégorie Extérieur',
        'foyerfsm_text_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_exterieur_title', 'default' => 'Extérieur et jardin')
    );
    add_settings_field(
        'gallery_exterieur_images_per_category',
        'Images par catégorie (Extérieur)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_exterieur_images_per_category', 'default' => 6, 'min' => 3, 'max' => 30)
    );
    add_settings_field(
        'gallery_exterieur_columns',
        'Colonnes (Extérieur)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_exterieur_columns', 'default' => 3, 'min' => 2, 'max' => 4)
    );
    add_settings_field(
        'gallery_exterieur_rows',
        'Lignes (Extérieur)',
        'foyerfsm_number_field',
        'foyerfsm-gallery',
        'foyerfsm_gallery_main',
        array('name' => 'gallery_exterieur_rows', 'default' => 1, 'min' => 1, 'max' => 3)
    );

    // ===== SECTION INFORMATIONS =====
    register_setting('foyerfsm_informations_options', 'informations_hero_image');
    register_setting('foyerfsm_informations_options', 'informations_page_title');
    register_setting('foyerfsm_informations_options', 'informations_page_subtitle');
    register_setting('foyerfsm_informations_options', 'informations_intro_text');
    register_setting('foyerfsm_informations_options', 'informations_reglement_title');
    register_setting('foyerfsm_informations_options', 'informations_reglement_text');
    register_setting('foyerfsm_informations_options', 'informations_caution_title');
    register_setting('foyerfsm_informations_options', 'informations_caution_text');
    register_setting('foyerfsm_informations_options', 'informations_repas_text');
    register_setting('foyerfsm_informations_options', 'informations_badge_title');
    register_setting('foyerfsm_informations_options', 'informations_badge_text');
    register_setting('foyerfsm_informations_options', 'informations_engagements_title');
    register_setting('foyerfsm_informations_options', 'informations_engagements_list');
    register_setting('foyerfsm_informations_options', 'informations_engagements_complement');
    register_setting('foyerfsm_informations_options', 'informations_contract_ref');
    register_setting('foyerfsm_informations_options', 'informations_contact_text');
    register_setting('foyerfsm_informations_options', 'informations_contact_button_text');
    register_setting('foyerfsm_informations_options', 'informations_contact_button_link');

    add_settings_section('foyerfsm_informations_main', 'Configuration de la page Informations', '__return_empty_string', 'foyerfsm-informations');

    add_settings_field(
        'informations_hero_image',
        'Image d\'en-tête',
        'foyerfsm_media_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_hero_image')
    );
    add_settings_field(
        'informations_page_title',
        'Titre de la page',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_page_title', 'default' => 'Informations pratiques')
    );
    add_settings_field(
        'informations_page_subtitle',
        'Sous-titre',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_page_subtitle', 'default' => 'Règlement, caution et conditions de location')
    );
    add_settings_field(
        'informations_intro_text',
        'Message d\'introduction',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_intro_text', 'default' => '<p>Bienvenue dans notre foyer. Veuillez prendre connaissance des informations importantes concernant votre future résidence.</p>')
    );

    add_settings_field(
        'informations_reglement_title',
        'Titre section Règlement',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_reglement_title', 'default' => 'Règlement mensuel')
    );
    add_settings_field(
        'informations_reglement_text',
        'Texte Règlement',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_reglement_text', 'default' => '<p>Le règlement mensuel pour le mois à venir, sera réglé, par virement bancaire le 3 du mois en cours, au Foyer :</p><p><strong>Règlement à l’ordre des « Sœurs Franciscaines Servantes de Marie », Maison mère St Antoine à Blois</strong></p><p>Suivant éléments du RIB filigrané « Foyer FSM Marie Virginie » fourni par la congrégation.</p>')
    );

    add_settings_field(
        'informations_caution_title',
        'Titre section Caution',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_caution_title', 'default' => 'Caution')
    );
    add_settings_field(
        'informations_caution_text',
        'Texte Caution',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_caution_text', 'default' => '<p>Une caution pour l’état de la chambre est encaissée par virement bancaire immédiat au Foyer à la signature du présent contrat.</p><p><strong>Le montant de la caution est fixé à un mois de loyer de la chambre.</strong></p><p>Le présent contrat ne devient définitif qu’après constatation par la congrégation de la réalité du virement de caution et la remise de toutes les pièces justificatives demandées.</p><p>L’état initial des lieux est fait le jour de la signature du présent contrat, un nouvel état des lieux sera fait au départ de la résidente pour permettre, ou non, le remboursement de la Caution.</p><p><strong>Si les dégâts constatés à l’état des lieux de départ sont d’un montant supérieur à la caution, la remise en état de la chambre sera à la charge intégrale de la résidente.</strong></p>')
    );

    add_settings_field(
        'informations_repas_text',
        'Texte Repas',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_repas_text', 'default' => '<p><strong>Aucun repas (petit déjeuner, déjeuner et diner) n’est compris dans le montant de location de la chambre.</strong></p><p><strong>Chaque résidente se prépare ses propres repas dans la cuisine/ salle à manger mise à sa disposition au 2ème étage.</strong></p>')
    );

    add_settings_field(
        'informations_badge_title',
        'Titre section Badge',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_badge_title', 'default' => 'Badge d\'accès')
    );
    add_settings_field(
        'informations_badge_text',
        'Texte Badge',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_badge_text', 'default' => '<p>Si la résidente perd le badge d’accès au bâtiment des Fioretti, qui lui a été confié le jour de la signature du présent contrat, il sera immédiatement désactivé et remplacé à sa charge financière immédiate d’un montant forfaitaire de <strong>100 €</strong>.</p><p><em>Le règlement par virement bancaire sera fait le jour de la constatation de perte.</em></p>')
    );

    add_settings_field(
        'informations_engagements_title',
        'Titre section Règlement intérieur',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_engagements_title', 'default' => 'Règlement intérieur')
    );
    add_settings_field(
        'informations_engagements_list',
        'Liste des engagements (un par ligne)',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_engagements_list', 'default' => "Aucun matériel de cuisson (plaque, bouilloire, cafetière...) dans la chambre\nAucun moyen d'affichage sur les murs (punaises, crochets, clous, Patafix...)\nInterdiction de fumer ou vapoter dans tout le bâtiment\nRetour au plus tard à 21h, silence après cette heure")
    );
    add_settings_field(
        'informations_engagements_complement',
        'Texte complémentaire engagements',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_engagements_complement', 'default' => '<p class="engagement-note">Par le présent contrat la résidente s\'engage formellement à respecter ces règles.</p>')
    );

    add_settings_field(
        'informations_contract_ref',
        'Référence du contrat',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_contract_ref', 'default' => 'Contrat Foyer M Virginie francaise_V2_18122025.docx')
    );

    add_settings_field(
        'informations_contact_text',
        'Texte d\'appel à l\'action',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_contact_text', 'default' => 'Prête à faire votre demande ?')
    );
    add_settings_field(
        'informations_contact_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_contact_button_text', 'default' => 'Demander une chambre')
    );

    add_settings_field(
        'informations_contact_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-informations',
        'foyerfsm_informations_main',
        array('name' => 'informations_contact_button_link', 'default' => '')  // Pas de valeur par défaut
    );

    // ===== SECTION PAGE SERVICES =====
    register_setting('foyerfsm_services_page_options', 'services_page_title');
    register_setting('foyerfsm_services_page_options', 'services_page_subtitle');
    register_setting('foyerfsm_services_page_options', 'services_intro_text');
    for ($i = 1; $i <= 6; $i++) {
        register_setting('foyerfsm_services_page_options', "service_{$i}_title");
        register_setting('foyerfsm_services_page_options', "service_{$i}_text");
        register_setting('foyerfsm_services_page_options', "service_{$i}_features");
    }
    register_setting('foyerfsm_services_page_options', 'services_contact_text');
    register_setting('foyerfsm_services_page_options', 'services_contact_button_text');
    register_setting('foyerfsm_services_page_options', 'services_contact_button_link');

    add_settings_section('foyerfsm_services_page_main', '📄 Page Services', '__return_empty_string', 'foyerfsm-services-page');

    add_settings_field(
        'services_page_title',
        'Titre de la page',
        'foyerfsm_text_field',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_page_title', 'default' => 'Nos services')
    );
    add_settings_field(
        'services_page_subtitle',
        'Sous-titre',
        'foyerfsm_text_field',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_page_subtitle', 'default' => 'Découvrez tous les services mis à votre disposition')
    );
    add_settings_field(
        'services_intro_text',
        'Texte d\'introduction',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_intro_text', 'default' => '<p>Notre foyer met à disposition de ses résidentes de nombreux services pour faciliter leur quotidien et favoriser leur épanouissement.</p>')
    );

    for ($i = 1; $i <= 6; $i++) {
        add_settings_field(
            "service_{$i}_title",
            "Service $i - Titre",
            'foyerfsm_text_field',
            'foyerfsm-services-page',
            'foyerfsm_services_page_main',
            array('name' => "service_{$i}_title", 'default' => $i == 1 ? 'Chambres équipées' : ($i == 2 ? 'Espaces communs' : ($i == 3 ? 'Sécurité 24h/24' : ($i == 4 ? 'Localisation idéale' : ($i == 5 ? 'Accompagnement personnalisé' : 'Vie communautaire')))))
        );

        add_settings_field(
            "service_{$i}_text",
            "Service $i - Description",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-services-page',
            'foyerfsm_services_page_main',
            array('name' => "service_{$i}_text", 'default' => $i == 1 ? '<p>9 chambres confortables de 9m² à 14m², chacune avec sa douche et ses toilettes privatives. Un espace idéal pour l\'étude et le repos.</p>' : ($i == 2 ? '<p>Une grande cuisine commune entièrement équipée et une salle à manger conviviale au 2ème étage pour partager des moments ensemble.</p>' : ($i == 3 ? '<p>Un accès sécurisé par badge, une présence rassurante et un cadre calme pour étudier en toute sérénité.</p>' : ($i == 4 ? '<p>Situé à Tours, notre foyer est à seulement 5 minutes à pied de la station de tram Christ Roi et à 15 minutes de la gare SNCF.</p>' : ($i == 5 ? '<p>Un accompagnement spirituel et humain à la demande, dans le respect de chacun, pour soutenir les étudiantes dans leur parcours.</p>' : '<p>Des espaces de convivialité et des activités pour favoriser les échanges et créer une vraie communauté entre résidentes.</p>')))))
        );

        add_settings_field(
            "service_{$i}_features",
            "Service $i - Caractéristiques (une par ligne)",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-services-page',
            'foyerfsm_services_page_main',
            array('name' => "service_{$i}_features", 'default' => $i == 1 ? "Lit confortable\nBureau de travail\nArmoire rangement\nConnexion WiFi" : ($i == 2 ? "Cuisine équipée\nRéfrigérateur\nFour et plaques\nSalle à manger" : ($i == 3 ? "Accès par badge\nVidéosurveillance\nÉclairage automatique\nPersonnel disponible" : ($i == 4 ? "Proche des facultés\nCommerces à proximité\nArrêt de tram\nGare accessible" : ($i == 5 ? "Écoute bienveillante\nSoutien personnalisé\nAccompagnement spirituel\nEntraide communautaire" : "Salle commune\nActivités partagées\nÉvénements\nEntraide")))))
        );
    }

    add_settings_field(
        'services_contact_text',
        'Texte d\'appel à l\'action',
        'foyerfsm_text_field',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_contact_text', 'default' => 'Prête à rejoindre notre foyer ?')
    );
    add_settings_field(
        'services_contact_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_contact_button_text', 'default' => 'Demander une chambre')
    );
    add_settings_field(
        'services_contact_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-services-page',
        'foyerfsm_services_page_main',
        array('name' => 'services_contact_button_link')
    );

    // ===== SECTION PAGE À PROPOS =====
    register_setting('foyerfsm_apropos_options', 'apropos_hero_image');
    register_setting('foyerfsm_apropos_options', 'apropos_hero_title');
    register_setting('foyerfsm_apropos_options', 'apropos_hero_subtitle');

    register_setting('foyerfsm_apropos_options', 'apropos_superior_title');
    register_setting('foyerfsm_apropos_options', 'apropos_superior_message');
    register_setting('foyerfsm_apropos_options', 'apropos_superior_signature');
    register_setting('foyerfsm_apropos_options', 'apropos_superior_image');

    register_setting('foyerfsm_apropos_options', 'apropos_starfish_title');
    register_setting('foyerfsm_apropos_options', 'apropos_starfish_text');
    register_setting('foyerfsm_apropos_options', 'apropos_starfish_quote');
    register_setting('foyerfsm_apropos_options', 'apropos_starfish_quote_author');

    for ($i = 1; $i <= 5; $i++) {
        register_setting('foyerfsm_apropos_options', "apropos_history_year_$i");
        register_setting('foyerfsm_apropos_options', "apropos_history_title_$i");
        register_setting('foyerfsm_apropos_options', "apropos_history_desc_$i");
    }

    register_setting('foyerfsm_apropos_options', 'apropos_events_title');
    for ($i = 1; $i <= 4; $i++) {
        register_setting('foyerfsm_apropos_options', "apropos_event_{$i}_title");
        register_setting('foyerfsm_apropos_options', "apropos_event_{$i}_date");
        register_setting('foyerfsm_apropos_options', "apropos_event_{$i}_desc");
    }

    register_setting('foyerfsm_apropos_options', 'apropos_missions_title');
    $countries = ['france', 'inde', 'madagascar', 'tchad', 'italie'];
    foreach ($countries as $country) {
        register_setting('foyerfsm_apropos_options', "apropos_mission_{$country}_name");
        register_setting('foyerfsm_apropos_options', "apropos_mission_{$country}_flag");
        register_setting('foyerfsm_apropos_options', "apropos_mission_{$country}_title");
        register_setting('foyerfsm_apropos_options', "apropos_mission_{$country}_desc");
        register_setting('foyerfsm_apropos_options', "apropos_mission_{$country}_image");
    }

    register_setting('foyerfsm_apropos_options', 'apropos_support_title');
    register_setting('foyerfsm_apropos_options', 'apropos_support_text');
    register_setting('foyerfsm_apropos_options', 'apropos_bank_title');
    register_setting('foyerfsm_apropos_options', 'apropos_bank_iban');
    register_setting('foyerfsm_apropos_options', 'apropos_bank_bic');
    register_setting('foyerfsm_apropos_options', 'apropos_contact_title');
    register_setting('foyerfsm_apropos_options', 'apropos_contact_address');
    register_setting('foyerfsm_apropos_options', 'apropos_contact_phone');
    register_setting('foyerfsm_apropos_options', 'apropos_contact_email');
    register_setting('foyerfsm_apropos_options', 'apropos_donation_title');
    register_setting('foyerfsm_apropos_options', 'apropos_donation_text');
    register_setting('foyerfsm_apropos_options', 'apropos_donation_address');
    register_setting('foyerfsm_apropos_options', 'apropos_donation_button');

    // Récupérer le sous-onglet actif
    $apropos_subtab = isset($_GET['apropos_subtab']) ? $_GET['apropos_subtab'] : 'hero';

    // ===== SOUS-ONGLET HERO =====
    add_settings_section('apropos_hero_section', '🏠 Section Hero', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_hero_title', 'Titre du hero', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_hero_section', array('name' => 'apropos_hero_title', 'default' => 'À propos de nous'));
    add_settings_field('apropos_hero_subtitle', 'Sous-titre du hero', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_hero_section', array('name' => 'apropos_hero_subtitle', 'default' => 'Découvrez notre histoire et notre mission'));
    add_settings_field('apropos_hero_image', 'Image de fond', 'foyerfsm_media_field', 'foyerfsm-apropos', 'apropos_hero_section', array('name' => 'apropos_hero_image'));

    // ===== SOUS-ONGLET SUPÉRIEURE =====
    add_settings_section('apropos_superior_section', '✉️ Message de la Supérieure', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_superior_title', 'Titre de la section', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_superior_section', array('name' => 'apropos_superior_title', 'default' => 'Lettre aux amis et aux familles'));
    add_settings_field('apropos_superior_message', 'Message (HTML autorisé)', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_superior_section', array('name' => 'apropos_superior_message', 'default' => '<p>Chers amis,</p><p>Nous nous préparons à dire au revoir à l\'année 2025...</p>'));
    add_settings_field('apropos_superior_signature', 'Signature', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_superior_section', array('name' => 'apropos_superior_signature', 'default' => 'Sr Reetha Paul, Supérieure Générale'));
    add_settings_field('apropos_superior_image', 'Photo de la supérieure', 'foyerfsm_media_field', 'foyerfsm-apropos', 'apropos_superior_section', array('name' => 'apropos_superior_image'));

    // ===== SOUS-ONGLET ÉTOILE DE MER =====
    add_settings_section('apropos_starfish_section', '⭐ Histoire de l\'étoile de mer', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_starfish_title', 'Titre', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_starfish_section', array('name' => 'apropos_starfish_title', 'default' => 'L\'histoire de l\'étoile de mer'));
    add_settings_field('apropos_starfish_text', 'Texte (HTML autorisé)', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_starfish_section', array('name' => 'apropos_starfish_text', 'default' => '<p>« Jim avait l\'habitude de se promener sur la plage...</p>'));
    add_settings_field('apropos_starfish_quote', 'Citation', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_starfish_section', array('name' => 'apropos_starfish_quote', 'default' => '« Nous ne pouvons pas faire de grandes choses, seulement de petites choses avec un grand amour. »'));
    add_settings_field('apropos_starfish_quote_author', 'Auteur de la citation', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_starfish_section', array('name' => 'apropos_starfish_quote_author', 'default' => 'Mère Teresa'));

    // ===== SOUS-ONGLET HISTOIRE =====
    add_settings_section('apropos_history_section', '📜 Notre Histoire (Timeline)', '__return_empty_string', 'foyerfsm-apropos');
    for ($i = 1; $i <= 5; $i++) {
        add_settings_field("apropos_history_year_$i", "Année $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_history_section', array('name' => "apropos_history_year_$i"));
        add_settings_field("apropos_history_title_$i", "Titre $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_history_section', array('name' => "apropos_history_title_$i"));
        add_settings_field("apropos_history_desc_$i", "Description $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_history_section', array('name' => "apropos_history_desc_$i"));
    }

    // ===== SOUS-ONGLET ÉVÉNEMENTS =====
    add_settings_section('apropos_events_section', '📅 Événements récents', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_events_title', 'Titre de la section événements', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_events_section', array('name' => 'apropos_events_title', 'default' => 'Événements récents'));
    for ($i = 1; $i <= 4; $i++) {
        add_settings_field("apropos_event_{$i}_title", "Titre événement $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_events_section', array('name' => "apropos_event_{$i}_title"));
        add_settings_field("apropos_event_{$i}_date", "Date $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_events_section', array('name' => "apropos_event_{$i}_date"));
        add_settings_field("apropos_event_{$i}_desc", "Description $i", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_events_section', array('name' => "apropos_event_{$i}_desc"));
    }

    // ===== SOUS-ONGLET MISSIONS =====
    add_settings_section('apropos_missions_section', '🌍 Nos missions dans le monde', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_missions_title', 'Titre de la section missions', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => 'apropos_missions_title', 'default' => 'Nos missions dans le monde'));

    $countries = ['france', 'inde', 'madagascar', 'tchad', 'italie'];
    $country_names = ['France', 'Inde', 'Madagascar', 'Tchad', 'Italie'];
    $country_flags = ['🇫🇷', '🇮🇳', '🇲🇬', '🇹🇩', '🇮🇹'];

    foreach ($countries as $index => $country) {
        add_settings_field("apropos_mission_{$country}_name", "Nom du pays ($country)", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => "apropos_mission_{$country}_name", 'default' => $country_names[$index]));
        add_settings_field("apropos_mission_{$country}_flag", "Drapeau ($country)", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => "apropos_mission_{$country}_flag", 'default' => $country_flags[$index]));
        add_settings_field("apropos_mission_{$country}_title", "Titre ($country)", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => "apropos_mission_{$country}_title"));
        add_settings_field("apropos_mission_{$country}_desc", "Description ($country)", 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => "apropos_mission_{$country}_desc"));
        add_settings_field("apropos_mission_{$country}_image", "Image d'illustration ($country)", 'foyerfsm_media_field', 'foyerfsm-apropos', 'apropos_missions_section', array('name' => "apropos_mission_{$country}_image"));
    }

    // ===== SOUS-ONGLET SOUTIEN =====
    add_settings_section('apropos_support_section', '💝 Soutenir notre mission', '__return_empty_string', 'foyerfsm-apropos');
    add_settings_field('apropos_support_title', 'Titre', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_support_title', 'default' => 'Soutenir notre mission'));
    add_settings_field('apropos_support_text', 'Texte d\'introduction', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_support_text', 'default' => 'La Congrégation peut délivrer des reçus fiscaux pour les dons. Les dons ouvrent droit à une réduction d’impôt sur le revenu égale à 66% de leur montant.'));
    add_settings_field('apropos_bank_title', 'Titre banque', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_bank_title', 'default' => 'Coordonnées bancaires'));
    add_settings_field('apropos_bank_iban', 'IBAN', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_bank_iban', 'default' => 'FR76 3000 3040 9500 0500 0527 047'));
    add_settings_field('apropos_bank_bic', 'BIC', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_bank_bic', 'default' => 'SOGEFRPP'));
    add_settings_field('apropos_contact_title', 'Titre contact', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_contact_title', 'default' => 'Nous contacter'));
    add_settings_field('apropos_contact_address', 'Adresse', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_contact_address', 'default' => '15 rue Monin, 41000 BLOIS'));
    add_settings_field('apropos_contact_phone', 'Téléphone', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_contact_phone', 'default' => '02 54 78 63 97'));
    add_settings_field('apropos_contact_email', 'Email', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_contact_email', 'default' => 'secretariat@congregationfsm.fr'));
    add_settings_field('apropos_donation_title', 'Titre don', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_donation_title', 'default' => 'Faire un don'));
    add_settings_field('apropos_donation_text', 'Texte don', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_donation_text', 'default' => 'Les dons en espèces, par chèque ou par virement (avec votre adresse pour le reçu) à :'));
    add_settings_field('apropos_donation_address', 'Adresse pour les dons', 'foyerfsm_wysiwyg_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_donation_address', 'default' => "Sœurs Franciscaines Servantes de Marie\n15 rue Monin\n41000 BLOIS"));
    add_settings_field('apropos_donation_button', 'Texte du bouton', 'foyerfsm_text_field', 'foyerfsm-apropos', 'apropos_support_section', array('name' => 'apropos_donation_button', 'default' => 'Nous contacter par mail'));

    // ===== SECTION CONTACT =====
    // Enregistrement des options
    $contact_fields = [
        // Emails
        'contact_email_soeurs',
        'contact_sender_email',

        // Hero
        'contact_page_hero_title',
        'contact_page_hero_image',
        'contact_page_intro',

        // Bloc informations
        'contact_info_title',
        'contact_info_subtitle',
        'contact_whatsapp',
        'contact_facebook',
        'contact_instagram',
        'contact_social_label',

        // Cartes de contact (3 blocs)
        'contact_card_phone',
        'contact_card_email',
        'contact_card_address',

        // Formulaire
        'contact_form_title',
        'contact_message_info',
        'contact_show_map',

        // Footer
        'foyer_footer_address',
        'foyer_footer_map_enabled',

        // Barre mobile
        'foyer_mobile_bar_enabled',
        'foyer_request_room_url',
        'foyer_contact_phone',
        'foyer_contact_email',
    ];

    foreach ($contact_fields as $field) {
        register_setting('foyerfsm_contact_options', $field);
    }

    // Sections
    add_settings_section('foyerfsm_contact_main', '📱 Configuration de la page contact', '__return_empty_string', 'foyerfsm-contact');
    add_settings_section('foyerfsm_mobilebar_main', '📱 Barre mobile (contact rapide)', '__return_empty_string', 'foyerfsm-contact');
    add_settings_section('foyerfsm_footer_main', '📍 Pied de page - Coordonnées', '__return_empty_string', 'foyerfsm-contact');

    // ===== SECTION CONTACT PRINCIPALE =====

    // Emails
    add_settings_field(
        'contact_email_soeurs',
        'Email(s) de réception des messages',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array(
            'name' => 'contact_email_soeurs',
            'default' => '',
            'description' => 'Adresse(s) email qui reçoivent les messages du formulaire. Séparez plusieurs adresses par des virgules (ex: email1@site.com, email2@site.com)'
        )
    );

    add_settings_field(
        'contact_sender_email',
        'Email expéditeur (envoi)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_sender_email', 'default' => '', 'description' => 'Email utilisé comme expéditeur (doit correspondre au SMTP)')
    );

    // Hero
    add_settings_field(
        'contact_page_hero_title',
        'Titre du hero',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_page_hero_title', 'default' => '', 'description' => 'Titre principal affiché dans l\'en-tête de la page')
    );

    add_settings_field(
        'contact_page_hero_image',
        'Image du hero',
        'foyerfsm_media_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_page_hero_image', 'description' => 'Image d\'arrière-plan ou d\'illustration de l\'en-tête')
    );

    add_settings_field(
        'contact_page_intro',
        'Texte d\'introduction',
        'foyerfsm_wysiwyg_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_page_intro', 'default' => '', 'description' => 'Texte d\'introduction qui apparaît après le hero')
    );

    // Bloc informations
    add_settings_field(
        'contact_info_title',
        'Titre bloc informations',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_info_title', 'default' => '', 'description' => 'Titre de la section des informations de contact')
    );

    add_settings_field(
        'contact_info_subtitle',
        'Sous-titre bloc informations',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_info_subtitle', 'default' => '', 'description' => 'Sous-titre de la section des informations')
    );

    // Réseaux sociaux
    add_settings_field(
        'contact_whatsapp',
        'WhatsApp',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_whatsapp', 'default' => '', 'description' => 'Numéro WhatsApp (ex: 0612345678) - optionnel')
    );

    add_settings_field(
        'contact_facebook',
        'Facebook URL',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_facebook', 'default' => '', 'description' => 'URL complète de la page Facebook - optionnel')
    );

    add_settings_field(
        'contact_instagram',
        'Instagram URL',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_instagram', 'default' => '', 'description' => 'URL complète du compte Instagram - optionnel')
    );

    add_settings_field(
        'contact_social_label',
        'Label réseaux sociaux',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_social_label', 'default' => '', 'description' => 'Texte avant les liens des réseaux sociaux (ex: "Suivez-nous")')
    );

    // Cartes de contact (3 blocs)
    add_settings_field(
        'contact_card_phone',
        '📞 Téléphone (carte 1)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_card_phone', 'default' => '', 'description' => 'Numéro de téléphone affiché dans la première carte')
    );

    add_settings_field(
        'contact_card_email',
        '✉️ Email (carte 2)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_card_email', 'default' => '', 'description' => 'Adresse email affichée dans la deuxième carte')
    );

    add_settings_field(
        'contact_card_address',
        '📍 Adresse (carte 3)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_card_address', 'default' => '', 'description' => 'Adresse postale affichée dans la troisième carte')
    );

    // Formulaire
    add_settings_field(
        'contact_form_title',
        'Titre du formulaire',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_form_title', 'default' => '', 'description' => 'Titre affiché au-dessus du formulaire de contact')
    );

    add_settings_field(
        'contact_message_info',
        'Info message',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_message_info', 'default' => '', 'description' => 'Petit texte sous le champ message (ex: "Max. 500 caractères")')
    );

    add_settings_field(
        'contact_show_map',
        'Afficher la carte Google Maps',
        'foyerfsm_checkbox_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_contact_main',
        array('name' => 'contact_show_map', 'default' => 0, 'description' => 'Cocher pour afficher la carte Google Maps en bas de page')
    );

    // ===== BARRE MOBILE =====
    add_settings_field(
        'foyer_mobile_bar_enabled',
        'Activer la barre mobile',
        'foyerfsm_checkbox_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_mobilebar_main',
        array('name' => 'foyer_mobile_bar_enabled', 'default' => 1, 'description' => 'Afficher la barre de contact sur mobile')
    );

    add_settings_field(
        'foyer_request_room_url',
        'URL "Demander une chambre"',
        'foyerfsm_page_dropdown',
        'foyerfsm-contact',
        'foyerfsm_mobilebar_main',
        array('name' => 'foyer_request_room_url')
    );

    add_settings_field(
        'foyer_contact_phone',
        'Téléphone (barre mobile)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_mobilebar_main',
        array('name' => 'foyer_contact_phone', 'default' => '', 'description' => 'Numéro de téléphone pour la barre mobile')
    );

    add_settings_field(
        'foyer_contact_email',
        'Email (barre mobile)',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_mobilebar_main',
        array('name' => 'foyer_contact_email', 'default' => '', 'description' => 'Adresse email pour la barre mobile')
    );

    // ===== PIED DE PAGE - COORDONNÉES =====
    add_settings_field(
        'foyer_footer_address',
        'Adresse pour la carte',
        'foyerfsm_text_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_footer_main',
        array('name' => 'foyer_footer_address', 'default' => '', 'description' => 'Adresse utilisée pour la carte Google Maps')
    );

    add_settings_field(
        'foyer_footer_map_enabled',
        'Afficher la carte dans le footer',
        'foyerfsm_checkbox_field_with_description',
        'foyerfsm-contact',
        'foyerfsm_footer_main',
        array('name' => 'foyer_footer_map_enabled', 'default' => 1, 'description' => 'Afficher la carte Google Maps dans le footer du site')
    );
    // ===== SECTION DEMANDE DE CHAMBRE =====
    // Version simplifiée - uniquement les champs nécessaires
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_page_title');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_page_subtitle');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_hero_image');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_intro_text');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_email_reception');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_submit_text');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_success_title');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_success_message');
    register_setting('foyerfsm_demande_chambre_options', 'demande_chambre_error_message');

    add_settings_section('foyerfsm_demande_chambre_main', '📝 Configuration de la page Demander une chambre', '__return_empty_string', 'foyerfsm-demande-chambre');

    // Titre de la page
    add_settings_field(
        'demande_chambre_page_title',
        'Titre de la page',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_page_title', 'default' => 'Demander une chambre', 'description' => 'Titre principal affiché en haut de la page')
    );

    // Sous-titre
    add_settings_field(
        'demande_chambre_page_subtitle',
        'Sous-titre',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_page_subtitle', 'default' => 'Remplissez le formulaire ci-dessous pour votre demande de réservation', 'description' => 'Sous-titre affiché sous le titre')
    );

    // Image d'en-tête
    add_settings_field(
        'demande_chambre_hero_image',
        'Image d\'en-tête',
        'foyerfsm_media_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_hero_image', 'description' => 'Image illustrant l\'en-tête de la page')
    );

    // Texte d'introduction
    add_settings_field(
        'demande_chambre_intro_text',
        'Texte d\'introduction',
        'foyerfsm_wysiwyg_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_intro_text', 'default' => '<p>Merci de remplir ce formulaire de demande de chambre. Nous vous recontacterons dans les plus brefs délais pour vous informer des disponibilités.</p>', 'description' => 'Texte d\'introduction avant le formulaire')
    );

    // Email de réception
    add_settings_field(
        'demande_chambre_email_reception',
        'Email(s) de réception des demandes',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_email_reception', 'default' => get_option('admin_email'), 'description' => 'Adresse(s) email qui reçoivent les demandes. Séparez plusieurs adresses par des virgules.')
    );

    // Séparateur visuel
    add_settings_field(
        'demande_chambre_separator_1',
        '<hr style="margin: 20px 0; border-top: 1px solid #ccc;">',
        'foyerfsm_separator_field',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array()
    );

    // Messages de confirmation
    add_settings_field(
        'demande_chambre_submit_text',
        'Texte du bouton d\'envoi',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_submit_text', 'default' => 'Envoyer ma demande', 'description' => 'Texte affiché sur le bouton de validation')
    );

    add_settings_field(
        'demande_chambre_success_title',
        'Titre de confirmation',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_success_title', 'default' => 'Merci pour votre demande !', 'description' => 'Titre affiché après envoi réussi')
    );

    add_settings_field(
        'demande_chambre_success_message',
        'Message de confirmation',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_success_message', 'default' => 'Votre demande a bien été envoyée. Nous vous recontacterons très rapidement.', 'description' => 'Message affiché après envoi réussi')
    );

    add_settings_field(
        'demande_chambre_error_message',
        'Message d\'erreur',
        'foyerfsm_text_field_with_description',
        'foyerfsm-demande-chambre',
        'foyerfsm_demande_chambre_main',
        array('name' => 'demande_chambre_error_message', 'default' => 'Une erreur est survenue. Veuillez réessayer ou nous contacter par téléphone.', 'description' => 'Message affiché en cas d\'erreur d\'envoi')
    );

    // ===== SECTION PARAMÈTRES GÉNÉRAUX =====
    register_setting('foyerfsm_general_options', 'site_logo');
    register_setting('foyerfsm_general_options', 'site_favicon');
    register_setting('foyerfsm_general_options', 'site_copyright_text');
    register_setting('foyerfsm_general_options', 'site_copyright_link');
    register_setting('foyerfsm_general_options', 'site_facebook_url');
    register_setting('foyerfsm_general_options', 'site_instagram_url');
    register_setting('foyerfsm_general_options', 'site_linkedin_url');
    register_setting('foyerfsm_general_options', 'footer_show_social');
    register_setting('foyerfsm_general_options', 'footer_columns_layout');
    register_setting('foyerfsm_general_options', 'footer_background_color');
    register_setting('foyerfsm_general_options', 'footer_text_color');
    register_setting('foyerfsm_general_options', 'show_scroll_to_top');
    register_setting('foyerfsm_general_options', 'custom_css_code');

    add_settings_section('foyerfsm_general_main', 'Paramètres généraux du site', '__return_empty_string', 'foyerfsm-general');

    add_settings_field(
        'site_logo',
        'Logo du site',
        'foyerfsm_media_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_logo')
    );

    add_settings_field(
        'site_favicon',
        'Icône de l\'onglet (favicon)',
        'foyerfsm_media_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_favicon', 'description' => 'Image carrée, format 32x32px ou 512x512px')
    );

    add_settings_field(
        'site_copyright_text',
        'Texte du copyright',
        'foyerfsm_text_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_copyright_text', 'default' => '© ' . date('Y') . ' – Foyer Marie-Virginie')
    );

    add_settings_field(
        'site_copyright_link',
        'Lien du copyright (optionnel)',
        'foyerfsm_text_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_copyright_link', 'default' => '')
    );

    add_settings_field(
        'site_facebook_url',
        'URL Facebook',
        'foyerfsm_text_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_facebook_url', 'default' => '')
    );

    add_settings_field(
        'site_instagram_url',
        'URL Instagram',
        'foyerfsm_text_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_instagram_url', 'default' => '')
    );

    add_settings_field(
        'site_linkedin_url',
        'URL LinkedIn',
        'foyerfsm_text_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'site_linkedin_url', 'default' => '')
    );

    add_settings_field(
        'footer_show_social',
        'Afficher les réseaux sociaux dans le footer',
        'foyerfsm_checkbox_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'footer_show_social', 'default' => 1)
    );

    add_settings_field(
        'footer_columns_layout',
        'Nombre de colonnes dans le footer',
        'foyerfsm_select_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'footer_columns_layout', 'default' => 3, 'options' => array(1 => '1 colonne', 2 => '2 colonnes', 3 => '3 colonnes', 4 => '4 colonnes'))
    );

    add_settings_field(
        'footer_background_color',
        'Couleur de fond du footer',
        'foyerfsm_color_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'footer_background_color', 'default' => '#2c3e50')
    );

    add_settings_field(
        'footer_text_color',
        'Couleur du texte du footer',
        'foyerfsm_color_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'footer_text_color', 'default' => '#ffffff')
    );

    add_settings_field(
        'show_scroll_to_top',
        'Afficher le bouton "Retour en haut"',
        'foyerfsm_checkbox_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'show_scroll_to_top', 'default' => 1)
    );

    add_settings_field(
        'custom_css_code',
        'CSS personnalisé',
        'foyerfsm_textarea_field',
        'foyerfsm-general',
        'foyerfsm_general_main',
        array('name' => 'custom_css_code', 'default' => '')
    );

    // ===== SECTION FOOTER =====
    register_setting('foyerfsm_footer_options', 'footer_columns_layout');
    register_setting('foyerfsm_footer_options', 'footer_background_color');
    register_setting('foyerfsm_footer_options', 'footer_text_color');
    register_setting('foyerfsm_footer_options', 'footer_show_map');
    register_setting('foyerfsm_footer_options', 'footer_map_address');
    register_setting('foyerfsm_footer_options', 'footer_show_social');
    register_setting('foyerfsm_footer_options', 'footer_facebook_url');
    register_setting('foyerfsm_footer_options', 'footer_instagram_url');
    register_setting('foyerfsm_footer_options', 'footer_linkedin_url');
    register_setting('foyerfsm_footer_options', 'footer_copyright_text');
    register_setting('foyerfsm_footer_options', 'footer_copyright_link');
    register_setting('foyerfsm_footer_options', 'footer_show_scroll_top');

    add_settings_section('foyerfsm_footer_main', '⚙️ Configuration du Footer', '__return_empty_string', 'foyerfsm-footer');

    add_settings_field(
        'footer_columns_layout',
        'Nombre de colonnes',
        'foyerfsm_select_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array(
            'name' => 'footer_columns_layout',
            'default' => 3,
            'options' => array(
                1 => '1 colonne',
                2 => '2 colonnes',
                3 => '3 colonnes',
                4 => '4 colonnes'
            )
        )
    );

    add_settings_field(
        'footer_background_color',
        'Couleur de fond',
        'foyerfsm_color_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_background_color', 'default' => '#2c3e50')
    );

    add_settings_field(
        'footer_text_color',
        'Couleur du texte',
        'foyerfsm_color_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_text_color', 'default' => '#ffffff')
    );

    add_settings_field(
        'footer_show_map',
        'Afficher la carte Google Maps',
        'foyerfsm_checkbox_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_show_map', 'default' => 0)
    );

    add_settings_field(
        'footer_map_address',
        'Adresse pour la carte',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_map_address', 'default' => '29 Rue place Coty, Tours 37100')
    );

    add_settings_field(
        'footer_show_social',
        'Afficher les réseaux sociaux',
        'foyerfsm_checkbox_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_show_social', 'default' => 1)
    );

    add_settings_field(
        'footer_facebook_url',
        'URL Facebook',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_facebook_url', 'default' => '')
    );

    add_settings_field(
        'footer_instagram_url',
        'URL Instagram',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_instagram_url', 'default' => '')
    );

    add_settings_field(
        'footer_linkedin_url',
        'URL LinkedIn',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_linkedin_url', 'default' => '')
    );

    add_settings_field(
        'footer_copyright_text',
        'Texte du copyright',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_copyright_text', 'default' => '© ' . date('Y') . ' – Foyer Marie-Virginie')
    );

    add_settings_field(
        'footer_copyright_link',
        'Lien du copyright',
        'foyerfsm_text_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_copyright_link', 'default' => '')
    );

    add_settings_field(
        'footer_show_scroll_top',
        'Afficher le bouton "Retour en haut"',
        'foyerfsm_checkbox_field',
        'foyerfsm-footer',
        'foyerfsm_footer_main',
        array('name' => 'footer_show_scroll_top', 'default' => 1)
    );

    // ===== SECTION PAGE NOS CHAMBRES =====
    register_setting('foyerfsm_page_chambres_options', 'chambres_hero_image');
    register_setting('foyerfsm_page_chambres_options', 'chambres_hero_title');
    register_setting('foyerfsm_page_chambres_options', 'chambres_hero_subtitle');
    register_setting('foyerfsm_page_chambres_options', 'chambres_intro_title');
    register_setting('foyerfsm_page_chambres_options', 'chambres_intro_text');
    register_setting('foyerfsm_page_chambres_options', 'chambres_show_button');
    register_setting('foyerfsm_page_chambres_options', 'chambres_button_text');
    register_setting('foyerfsm_page_chambres_options', 'chambres_button_link');
    register_setting('foyerfsm_page_chambres_options', 'chambres_cta_title');
    register_setting('foyerfsm_page_chambres_options', 'chambres_cta_text');
    register_setting('foyerfsm_page_chambres_options', 'chambres_cta_button_text');
    register_setting('foyerfsm_page_chambres_options', 'chambres_cta_button_link');

    // Options pour chaque chambre (jusqu'à 6)
    for ($i = 1; $i <= 6; $i++) {
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_active");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_titre");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_description");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_prix");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_surface");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_image");
        register_setting('foyerfsm_page_chambres_options', "chambre_{$i}_equipements");
    }

    add_settings_section('foyerfsm_page_chambres_hero', '🎠 Hero de la page', '__return_empty_string', 'foyerfsm-page-chambres');
    add_settings_section('foyerfsm_page_chambres_intro', '📝 Introduction', '__return_empty_string', 'foyerfsm-page-chambres');
    add_settings_section('foyerfsm_page_chambres_liste', '🛏️ Liste des chambres (6 maximum)', '__return_empty_string', 'foyerfsm-page-chambres');
    add_settings_section('foyerfsm_page_chambres_cta', '🎯 Appel à l\'action final', '__return_empty_string', 'foyerfsm-page-chambres');

    // === HERO ===
    add_settings_field(
        'chambres_hero_image',
        'Image du hero',
        'foyerfsm_media_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_hero',
        array('name' => 'chambres_hero_image')
    );

    add_settings_field(
        'chambres_hero_title',
        'Titre du hero',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_hero',
        array('name' => 'chambres_hero_title', 'default' => 'Nos chambres')
    );

    add_settings_field(
        'chambres_hero_subtitle',
        'Sous-titre du hero',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_hero',
        array('name' => 'chambres_hero_subtitle', 'default' => 'Des chambres confortables pour étudier dans de bonnes conditions')
    );

    // === INTRODUCTION ===
    add_settings_field(
        'chambres_intro_title',
        'Titre de l\'introduction',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_intro',
        array('name' => 'chambres_intro_title', 'default' => 'Découvrez nos chambres')
    );

    add_settings_field(
        'chambres_intro_text',
        'Texte d\'introduction',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_intro',
        array('name' => 'chambres_intro_text', 'default' => '<p>Chaque chambre est unique et dispose de tout le confort nécessaire pour vos études. Découvrez-les ci-dessous.</p>')
    );

    // === CHAMBRES ===
    for ($i = 1; $i <= 6; $i++) {
        add_settings_field(
            "chambre_{$i}_active",
            "Chambre $i - Activer",
            'foyerfsm_checkbox_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_active", 'default' => $i <= 3 ? 1 : 0)
        );

        add_settings_field(
            "chambre_{$i}_titre",
            "Chambre $i - Titre",
            'foyerfsm_text_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_titre", 'default' => $i == 1 ? 'Chambre Douillette' : ($i == 2 ? 'Chambre Confort' : ($i == 3 ? 'Chambre Spacieuse' : "Chambre $i")))
        );

        add_settings_field(
            "chambre_{$i}_description",
            "Chambre $i - Description",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_description", 'default' => '<p>Une chambre agréable avec vue sur le jardin.</p>')
        );

        add_settings_field(
            "chambre_{$i}_prix",
            "Chambre $i - Prix mensuel",
            'foyerfsm_text_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_prix", 'default' => $i == 1 ? '350€' : ($i == 2 ? '400€' : ($i == 3 ? '450€' : '350€')))
        );

        add_settings_field(
            "chambre_{$i}_surface",
            "Chambre $i - Surface",
            'foyerfsm_text_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_surface", 'default' => $i == 1 ? '12m²' : ($i == 2 ? '14m²' : ($i == 3 ? '16m²' : '12m²')))
        );

        add_settings_field(
            "chambre_{$i}_image",
            "Chambre $i - Image principale",
            'foyerfsm_media_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_image")
        );

        add_settings_field(
            "chambre_{$i}_equipements",
            "Chambre $i - Équipements (un par ligne)",
            'foyerfsm_textarea_field',
            'foyerfsm-page-chambres',
            'foyerfsm_page_chambres_liste',
            array('name' => "chambre_{$i}_equipements", 'default' => "Lit confortable\nBureau de travail\nArmoire\nWi-Fi haut débit")
        );
    }

    // === BOUTON SUR LES CHAMBRES ===
    add_settings_field(
        'chambres_show_button',
        'Afficher le bouton "Demander cette chambre"',
        'foyerfsm_checkbox_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_liste',
        array('name' => 'chambres_show_button', 'default' => 1)
    );

    add_settings_field(
        'chambres_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_liste',
        array('name' => 'chambres_button_text', 'default' => 'Demander cette chambre')
    );

    add_settings_field(
        'chambres_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_liste',
        array('name' => 'chambres_button_link')
    );

    // === CTA FINAL ===
    add_settings_field(
        'chambres_cta_title',
        'Titre du CTA',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_cta',
        array('name' => 'chambres_cta_title', 'default' => 'Prête à rejoindre notre foyer ?')
    );

    add_settings_field(
        'chambres_cta_text',
        'Texte du CTA',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_cta',
        array('name' => 'chambres_cta_text', 'default' => 'Contactez-nous pour plus d\'informations ou pour organiser une visite.')
    );

    add_settings_field(
        'chambres_cta_button_text',
        'Texte du bouton CTA',
        'foyerfsm_text_field',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_cta',
        array('name' => 'chambres_cta_button_text', 'default' => 'Nous contacter')
    );

    add_settings_field(
        'chambres_cta_button_link',
        'Lien du bouton CTA',
        'foyerfsm_page_dropdown',
        'foyerfsm-page-chambres',
        'foyerfsm_page_chambres_cta',
        array('name' => 'chambres_cta_button_link')
    );
}

// =============================================
// FONCTIONS D'AFFICHAGE DES CHAMPS
// =============================================

function foyerfsm_media_field_with_hint($args)
{
    $name = $args['name'];
    $value = get_option($name, '');
    $description = isset($args['description']) ? $args['description'] : '';
?>
    <div class="media-field">
        <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" class="media-field-value" />
        <button type="button" class="button media-uploader" data-target="<?php echo $name; ?>">Choisir une image</button>
        <button type="button" class="button media-remove" data-target="<?php echo $name; ?>" <?php echo empty($value) ? 'style="display:none;"' : ''; ?>>Supprimer</button>
        <div class="media-preview" id="preview-<?php echo $name; ?>">
            <?php if (!empty($value)) : ?>
                <?php echo wp_get_attachment_image($value, 'thumbnail'); ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($description)) : ?>
            <div style="margin-top: 10px; padding: 8px; background: #f0f6fc; border-left: 3px solid #b75b7d;">
                <p style="margin: 0 0 5px 0; font-weight: 600;">💡 Conseil :</p>
                <p style="margin: 0; color: #333;"><?php echo $description; ?></p>
            </div>
        <?php endif; ?>
    </div>
<?php
}

function foyerfsm_text_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = get_option($name, $default);
    echo "<input type='text' name='$name' value='" . esc_attr($value) . "' class='regular-text' />";
}

function foyerfsm_number_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : 0;
    $min = isset($args['min']) ? $args['min'] : 0;
    $max = isset($args['max']) ? $args['max'] : 100;
    $step = isset($args['step']) ? $args['step'] : 1;
    $value = get_option($name, $default);
    echo "<input type='number' name='$name' value='" . esc_attr($value) . "' min='$min' max='$max' step='$step' class='small-text' />";
}

function foyerfsm_textarea_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = get_option($name, $default);
    echo "<textarea name='$name' rows='5' class='large-text'>" . esc_textarea($value) . "</textarea>";
}

function foyerfsm_checkbox_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : 0;
    $value = get_option($name, $default);
    $checked = checked(1, $value, false);
    echo "<input type='checkbox' name='$name' value='1' $checked />";
}

function foyerfsm_media_field($args)
{
    $name = $args['name'];
    $value = get_option($name, '');
?>
    <div class="media-field">
        <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" class="media-field-value" />
        <button type="button" class="button media-uploader" data-target="<?php echo $name; ?>">Choisir une image</button>
        <button type="button" class="button media-remove" data-target="<?php echo $name; ?>" <?php echo empty($value) ? 'style="display:none;"' : ''; ?>>Supprimer</button>
        <div class="media-preview" id="preview-<?php echo $name; ?>">
            <?php if (!empty($value)) : ?>
                <?php echo wp_get_attachment_image($value, 'thumbnail'); ?>
            <?php endif; ?>
        </div>
    </div>
<?php
}

function foyerfsm_page_dropdown($args)
{
    $name = $args['name'];
    $value = get_option($name, '');

    $pages = get_pages();
    if (empty($pages)) {
        echo '<p>Aucune page trouvée. Créez d\'abord des pages.</p>';
        return;
    }

    echo "<select name='$name'>";
    echo "<option value=''>— Choisir une page —</option>";
    foreach ($pages as $page) {
        $selected = selected($value, $page->ID, false);
        echo "<option value='{$page->ID}' $selected>{$page->post_title}</option>";
    }
    echo "</select>";
}

function foyerfsm_select_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $options = isset($args['options']) ? $args['options'] : array();
    $value = get_option($name, $default);

    echo "<select name='$name'>";
    foreach ($options as $val => $label) {
        $selected = selected($value, $val, false);
        echo "<option value='$val' $selected>$label</option>";
    }
    echo "</select>";
}

function foyerfsm_color_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '#000000';
    $value = get_option($name, $default);
    echo "<input type='color' name='$name' value='" . esc_attr($value) . "' class='color-field' />";
    echo " <code>$value</code>";
}

function foyerfsm_wysiwyg_field($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = get_option($name, $default);

    $editor_id = str_replace(array('[', ']'), '_', $name);

    $settings = array(
        'textarea_name' => $name,
        'textarea_rows' => 12,
        'media_buttons' => false,
        'teeny' => true,
        'quicktags' => false,
        'wpautop' => false,
        'tinymce' => array(
            'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,bullist,numlist,separator,link,unlink,separator,undo,redo',
            'toolbar2' => '',
            'plugins' => 'lists,link',
        ),
    );

    wp_editor($value, $editor_id, $settings);

    echo '<p class="description" style="background: #f0f6fc; padding: 8px 12px; border-left: 3px solid #b75b7d; margin-top: 10px;">';
    echo '📝 <strong>Comme Word :</strong> vous pouvez mettre en <strong>gras</strong>, <em>italique</em>, créer des listes ou des liens.';
    echo '</p>';
}

function foyerfsm_auto_paragraphs($content)
{
    if (empty($content)) {
        return '';
    }
    if ($content != strip_tags($content)) {
        return wp_kses_post($content);
    }
    return wpautop(esc_html($content));
}

// Fonctions d'affichage avec description
function foyerfsm_text_field_with_description($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $description = isset($args['description']) ? $args['description'] : '';
    $value = get_option($name, $default);
    echo "<input type='text' name='$name' value='" . esc_attr($value) . "' class='regular-text' />";
    if ($description) {
        echo '<p class="description" style="color: #666; margin-top: 5px; font-style: italic;">📝 ' . esc_html($description) . '</p>';
    }
}

function foyerfsm_checkbox_field_with_description($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : 0;
    $description = isset($args['description']) ? $args['description'] : '';
    $value = get_option($name, $default);
    $checked = checked(1, $value, false);
    echo "<input type='checkbox' name='$name' value='1' $checked />";
    if ($description) {
        echo '<span class="description" style="color: #666; margin-left: 10px; font-style: italic;">📝 ' . esc_html($description) . '</span>';
    }
}

function foyerfsm_media_field_with_description($args)
{
    $name = $args['name'];
    $description = isset($args['description']) ? $args['description'] : '';
    $value = get_option($name, '');
?>
    <div class="media-field">
        <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo esc_attr($value); ?>" class="media-field-value" />
        <button type="button" class="button media-uploader" data-target="<?php echo $name; ?>">Choisir une image</button>
        <button type="button" class="button media-remove" data-target="<?php echo $name; ?>" <?php echo empty($value) ? 'style="display:none;"' : ''; ?>>Supprimer</button>
        <div class="media-preview" id="preview-<?php echo $name; ?>">
            <?php if (!empty($value)) : ?>
                <?php echo wp_get_attachment_image($value, 'thumbnail'); ?>
            <?php endif; ?>
        </div>
        <?php if ($description) : ?>
            <p class="description" style="color: #666; margin-top: 5px; font-style: italic;">📝 <?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>
<?php
}

function foyerfsm_wysiwyg_field_with_description($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $description = isset($args['description']) ? $args['description'] : '';
    $value = get_option($name, $default);
    $editor_id = str_replace(array('[', ']'), '_', $name);
    $settings = array(
        'textarea_name' => $name,
        'textarea_rows' => 8,
        'media_buttons' => false,
        'teeny' => true,
        'quicktags' => true,
        'wpautop' => false,
        'tinymce' => array(
            'toolbar1' => 'bold,italic,underline,separator,bullist,numlist,separator,link,unlink,separator,undo,redo',
            'toolbar2' => '',
            'plugins' => 'lists,link',
        ),
    );
    wp_editor($value, $editor_id, $settings);
    if ($description) {
        echo '<p class="description" style="color: #666; margin-top: 10px; font-style: italic;">📝 ' . esc_html($description) . '</p>';
    }
}

// Fonction pour afficher un séparateur
function foyerfsm_separator_field($args)
{
    echo '<hr style="margin: 20px 0; border-top: 2px solid #2271b1;">';
    echo '<p style="color: #2271b1; font-weight: bold;">📋 Les champs du formulaire sont fixes et ne sont pas paramétrables</p>';
}

// =============================================
// SCRIPT POUR LES UPLOADERS
// =============================================

add_action('admin_footer', 'foyerfsm_gallery_admin_script');
function foyerfsm_gallery_admin_script()
{
    $screen = get_current_screen();
    if ($screen->id !== 'toplevel_page_foyerfsm-options') return;
?>
    <script>
        jQuery(document).ready(function($) {
            $('.media-uploader').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                var field = $('#' + target);
                var frame = wp.media({
                    title: 'Choisir une image',
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    field.val(attachment.id);
                    var preview = $('#preview-' + target);
                    preview.html('<img src="' + attachment.sizes.thumbnail.url + '" style="width: 100%; height: 100%; object-fit: cover;">');
                    button.siblings('.media-remove').show();
                });
                frame.open();
            });
            $('.media-remove').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var target = button.data('target');
                $('#' + target).val('');
                $('#preview-' + target).html('<div style="width: 100%; height: 100%; background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">📷</div>');
                button.hide();
            });
        });
    </script>
<?php
}

?>