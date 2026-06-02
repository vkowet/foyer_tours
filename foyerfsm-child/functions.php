<?php

/**
 * FoyerFSM Child Theme Functions
 * VERSION OPTIMISÉE - UNE SEULE SECTION NOS VALEURS
 */

// =============================================
// 1. CHARGEMENT DES STYLES
// =============================================
add_action('wp_enqueue_scripts', 'foyerfsm_child_styles', 20);
function foyerfsm_child_styles()
{
    // Style parent
    wp_enqueue_style(
        'foyerfsm-parent',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('FoyerFMS')->get('Version')
    );

    // Style enfant
    wp_enqueue_style(
        'foyerfsm-child',
        get_stylesheet_directory_uri() . '/style.css',
        array('foyerfsm-parent'),
        wp_get_theme()->get('Version')
    );

    // Theme.css (design principal)
    wp_enqueue_style(
        'foyerfsm-theme',
        get_stylesheet_directory_uri() . '/assets/css/theme.css',
        array('foyerfsm-child'),
        '4.0.0'
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Lora:wght@400;500;600&display=swap',
        array(),
        null
    );
}

// =============================================
// 2. CHARGEMENT DES SCRIPTS
// =============================================
add_action('wp_enqueue_scripts', 'foyerfsm_child_scripts', 30);
function foyerfsm_child_scripts()
{
    // Menu mobile
    wp_enqueue_script(
        'foyerfsm-navigation',
        get_stylesheet_directory_uri() . '/assets/js/navigation.js',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/js/navigation.js'),
        true
    );

    // Slider (page d'accueil uniquement)
    if (is_front_page()) {
        wp_enqueue_script(
            'foyerfsm-slider',
            get_stylesheet_directory_uri() . '/assets/js/slider.js',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/js/slider.js'),
            true
        );
    }
}

// =============================================
// 3. BLOCS GUTENBERG PERSONNALISÉS
// =============================================
add_action('init', 'foyerfsm_register_custom_blocks');
function foyerfsm_register_custom_blocks()
{
    if (!function_exists('register_block_type')) return;

    // Bloc Fiche Chambre
    register_block_type('foyerfsm/chambre-card', array(
        'render_callback' => 'foyerfsm_render_chambre_card',
        'attributes' => array(
            'titre' => array('type' => 'string', 'default' => 'Chambre'),
            'surface' => array('type' => 'string', 'default' => '12m²'),
            'prix' => array('type' => 'string', 'default' => '400€'),
            'image_id' => array('type' => 'number', 'default' => 0),
            'lien' => array('type' => 'string', 'default' => '#')
        )
    ));

    // Bloc Service
    register_block_type('foyerfsm/service-card', array(
        'render_callback' => 'foyerfsm_render_service_card',
        'attributes' => array(
            'titre' => array('type' => 'string', 'default' => 'Service'),
            'description' => array('type' => 'string', 'default' => ''),
            'icone' => array('type' => 'string', 'default' => '🏠')
        )
    ));
}

// Rendu bloc Chambre (à compléter avec ton code existant)
function foyerfsm_render_chambre_card($attributes)
{
    ob_start();
    // Ton code existant
    return ob_get_clean();
}

// Rendu bloc Service (à compléter avec ton code existant)
function foyerfsm_render_service_card($attributes)
{
    ob_start();
    // Ton code existant
    return ob_get_clean();
}

// =============================================
// 4. CUSTOMIZER - COULEURS
// =============================================
add_action('customize_register', 'foyerfsm_customize_register');
function foyerfsm_customize_register($wp_customize)
{
    $wp_customize->add_section('foyerfsm_colors', array(
        'title' => '🎨 Couleurs du Foyer',
        'priority' => 30,
    ));

    $wp_customize->add_setting('primary_color', array(
        'default' => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => 'Couleur principale',
        'section' => 'foyerfsm_colors',
    )));

    $wp_customize->add_setting('secondary_color', array(
        'default' => '#8b5a2b',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => 'Couleur des boutons',
        'section' => 'foyerfsm_colors',
    )));
}

add_action('wp_head', 'foyerfsm_customizer_colors');
function foyerfsm_customizer_colors()
{
    $primary = get_theme_mod('primary_color', '#2c3e50');
    $secondary = get_theme_mod('secondary_color', '#8b5a2b');
?>
    <style>
        :root {
            --primary-color: <?php echo $primary; ?>;
            --secondary-color: <?php echo $secondary; ?>;
        }
    </style>
<?php
}

// =============================================
// 5. CUSTOMIZER - CONTACT
// =============================================


// =============================================
// 6. CUSTOMIZER - SLIDER, À PROPOS & VALEURS
// =============================================
require_once get_stylesheet_directory() . '/inc/slider-settings.php';

// =============================================
// 7. CORRECTIONS GUTENBERG
// =============================================
add_filter('the_content', 'fix_gutenberg_markup');
function fix_gutenberg_markup($content)
{
    return preg_replace('/<div class="wp-block-group__inner-container([^>]*)">\s*<\/div>/', '', $content);
}

add_action('wp', 'disable_broken_blocks_on_home');
function disable_broken_blocks_on_home()
{
    if (is_front_page()) {
        remove_filter('the_content', 'wpautop');
    }
}

// =============================================
// 8. BOUTON MENU BURGER
// =============================================
function foyerfsm_add_menu_button()
{
?>
    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="hamburger"></span>
        <span class="screen-reader-text">Menu</span>
    </button>
<?php
}
add_action('wp_nav_menu_before', 'foyerfsm_add_menu_button');

// =============================================
// 9. POST TYPE CHAMBRES
// =============================================
add_action('init', 'foyerfsm_register_chambre_post_type');
function foyerfsm_register_chambre_post_type()
{
    register_post_type('chambre', array(
        'labels' => array(
            'name' => 'Chambres',
            'singular_name' => 'Chambre'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-building',
        'show_in_rest' => true,
    ));
}

// =============================================
// 10. DÉSACTIVER GUTENBERG SUR PAGE ACCUEIL
// =============================================
add_filter('use_block_editor_for_post', 'disable_gutenberg_for_home', 10, 2);
function disable_gutenberg_for_home($use_block_editor, $post)
{
    if ($post && $post->ID == get_option('page_on_front')) {
        return false;
    }
    return $use_block_editor;
}

add_action('wp_enqueue_scripts', 'remove_gutenberg_styles', 100);
function remove_gutenberg_styles()
{
    if (is_front_page()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }
}

// =============================================
// CRÉER LES CATÉGORIES D'IMAGES
// =============================================
add_action('init', 'foyerfsm_create_image_categories');
function foyerfsm_create_image_categories()
{
    // Taxonomie pour les images
    register_taxonomy(
        'image_category',
        'attachment',
        array(
            'labels' => array(
                'name' => 'Catégories d\'images',
                'singular_name' => 'Catégorie',
                'menu_name' => 'Catégories',
                'all_items' => 'Toutes les catégories',
                'edit_item' => 'Modifier la catégorie',
                'add_new_item' => 'Ajouter une catégorie',
            ),
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => false,
            'hierarchical' => true,
        )
    );

    // Ajouter les catégories par défaut si elles n'existent pas
    $default_categories = array(
        'chambres' => 'Chambres',
        'communs' => 'Espaces communs',
        'exterieur' => 'Extérieur',
    );

    foreach ($default_categories as $slug => $name) {
        if (!term_exists($slug, 'image_category')) {
            wp_insert_term($name, 'image_category', array('slug' => $slug));
        }
    }
}

// =============================================
// INTERFACE SIMPLIFIÉE POUR LES CATÉGORIES D'IMAGES
// =============================================

// 1. Ajouter une liste déroulante dans l'écran d'édition des médias
add_filter('attachment_fields_to_edit', 'foyerfsm_add_image_category_dropdown', 10, 2);
function foyerfsm_add_image_category_dropdown($form_fields, $post)
{
    // Récupérer les catégories existantes
    $categories = get_terms(array(
        'taxonomy' => 'image_category',
        'hide_empty' => false,
    ));

    if (empty($categories)) return $form_fields;

    // Récupérer la catégorie actuelle de l'image
    $current_terms = wp_get_object_terms($post->ID, 'image_category', array('fields' => 'slugs'));
    $current = !empty($current_terms) ? $current_terms[0] : '';

    // Créer les options de la liste déroulante
    $options = '<option value="">— Choisir une catégorie —</option>';
    foreach ($categories as $cat) {
        $selected = selected($current, $cat->slug, false);
        $options .= "<option value='{$cat->slug}' {$selected}>{$cat->name}</option>";
    }

    // Ajouter le champ dans l'interface
    $form_fields['image_category'] = array(
        'label' => 'Catégorie',
        'input' => 'html',
        'html'  => "<select name='attachments[{$post->ID}][image_category]' id='attachments[{$post->ID}][image_category]'>{$options}</select>",
        'helps' => 'Sélectionnez la catégorie de cette image (chambres, espaces communs, extérieur)',
    );

    return $form_fields;
}

// 2. Sauvegarder la catégorie quand on met à jour l'image
add_filter('attachment_fields_to_save', 'foyerfsm_save_image_category', 10, 2);
function foyerfsm_save_image_category($post, $attachment)
{
    if (isset($attachment['image_category'])) {
        $category_slug = sanitize_text_field($attachment['image_category']);
        if (!empty($category_slug)) {
            wp_set_object_terms($post['ID'], $category_slug, 'image_category', false);
        }
    }
    return $post;
}

// 3. Ajouter une colonne "Catégorie" dans la bibliothèque média
add_filter('manage_media_columns', 'foyerfsm_add_media_category_column');
function foyerfsm_add_media_category_column($columns)
{
    $columns['image_category'] = 'Catégorie';
    return $columns;
}

// 4. Afficher la catégorie dans la colonne
add_action('manage_media_custom_column', 'foyerfsm_show_media_category_column', 10, 2);
function foyerfsm_show_media_category_column($column_name, $post_id)
{
    if ($column_name === 'image_category') {
        $terms = wp_get_object_terms($post_id, 'image_category', array('fields' => 'names'));
        echo !empty($terms) ? implode(', ', $terms) : '—';
    }
}

// 5. Ajouter un filtre rapide dans la bibliothèque média
add_action('restrict_manage_posts', 'foyerfsm_add_media_category_filter');
function foyerfsm_add_media_category_filter()
{
    $screen = get_current_screen();
    if ($screen->id !== 'upload') return;

    $categories = get_terms(array(
        'taxonomy' => 'image_category',
        'hide_empty' => false,
    ));

    if (empty($categories)) return;

    $current = isset($_GET['image_category']) ? $_GET['image_category'] : '';

    echo '<select name="image_category">';
    echo '<option value="">Toutes les catégories</option>';

    foreach ($categories as $cat) {
        $selected = selected($current, $cat->slug, false);
        echo "<option value='{$cat->slug}' {$selected}>{$cat->name}</option>";
    }

    echo '</select>';
}

// 6. Appliquer le filtre
add_filter('parse_query', 'foyerfsm_filter_media_by_category');
function foyerfsm_filter_media_by_category($query)
{
    global $pagenow;

    if ($pagenow !== 'upload.php') return;

    if (isset($_GET['image_category']) && !empty($_GET['image_category'])) {
        $query->query_vars['tax_query'] = array(
            array(
                'taxonomy' => 'image_category',
                'field' => 'slug',
                'terms' => $_GET['image_category'],
            ),
        );
    }
}

// =============================================
// APPLIQUER LES PARAMÈTRES GÉNÉRAUX
// =============================================

// Logo personnalisé
add_action('after_setup_theme', 'foyerfsm_custom_logo_setup');
function foyerfsm_custom_logo_setup()
{
    $logo_id = get_option('site_logo', '');
    if ($logo_id) {
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ));
    }
}

// Favicon
add_action('wp_head', 'foyerfsm_custom_favicon');
function foyerfsm_custom_favicon()
{
    $favicon_id = get_option('site_favicon', '');
    if ($favicon_id) {
        $favicon_url = wp_get_attachment_image_url($favicon_id, 'full');
        echo '<link rel="icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />';
        echo '<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />';
    }
}

// CSS personnalisé
add_action('wp_head', 'foyerfsm_custom_css');
function foyerfsm_custom_css()
{
    $custom_css = get_option('custom_css_code', '');
    if (!empty($custom_css)) {
        echo '<style type="text/css">' . wp_strip_all_tags($custom_css) . '</style>';
    }
}

// Couleurs du footer
add_action('wp_head', 'foyerfsm_footer_colors');
function foyerfsm_footer_colors()
{
    $footer_bg = get_option('footer_background_color', '#2c3e50');
    $footer_text = get_option('footer_text_color', '#ffffff');
?>
    <style>
        .site-footer {
            background-color: <?php echo esc_attr($footer_bg); ?> !important;
            color: <?php echo esc_attr($footer_text); ?> !important;
        }

        .site-footer a,
        .site-footer .footer-menu a {
            color: <?php echo esc_attr($footer_text); ?> !important;
        }

        .site-footer a:hover {
            opacity: 0.8;
        }
    </style>
<?php
}

// Scroll to top button
add_action('wp_footer', 'foyerfsm_scroll_to_top');
function foyerfsm_scroll_to_top()
{
    if (!get_option('show_scroll_to_top', 1)) return;
?>
    <button id="scroll-to-top" aria-label="Retour en haut">
        ↑
    </button>
    <style>
        #scroll-to-top {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--secondary-color, #8b5a2b);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        #scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        #scroll-to-top:hover {
            background: #a8784a;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            #scroll-to-top {
                bottom: 100px;
                right: 15px;
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('scroll-to-top');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    btn.classList.add('visible');
                } else {
                    btn.classList.remove('visible');
                }
            });
            btn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
<?php
}

// Footer avec réseaux sociaux
add_filter('foyerfsm_footer_social', 'foyerfsm_display_social_icons');
function foyerfsm_display_social_icons()
{
    if (!get_option('footer_show_social', 1)) return '';

    $facebook = get_option('site_facebook_url', '');
    $instagram = get_option('site_instagram_url', '');
    $linkedin = get_option('site_linkedin_url', '');

    $output = '<div class="footer-social">';
    if ($facebook) {
        $output .= '<a href="' . esc_url($facebook) . '" target="_blank" rel="noopener" aria-label="Facebook">📘</a>';
    }
    if ($instagram) {
        $output .= '<a href="' . esc_url($instagram) . '" target="_blank" rel="noopener" aria-label="Instagram">📷</a>';
    }
    if ($linkedin) {
        $output .= '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener" aria-label="LinkedIn">🔗</a>';
    }
    $output .= '</div>';

    return $output;
}

// =============================================
// PAGE D'ADMINISTRATION POUR "À PROPOS"
// =============================================
add_action('admin_menu', 'apropos_add_admin_page');
function apropos_add_admin_page()
{
    add_menu_page(
        'Page À propos',        // Titre de la page
        'À propos',             // Titre du menu
        'manage_options',       // Capacité requise
        'apropos-settings',     // Slug
        'apropos_render_admin_page', // Fonction d'affichage
        'dashicons-info',       // Icône
        30                      // Position
    );
}

function apropos_render_admin_page()
{
?>
    <div class="wrap">
        <h1>Gestion de la page "À propos"</h1>
        <p>Modifiez ici tous les textes de la page À propos.</p>

        <form method="post" action="options.php">
            <?php
            settings_fields('apropos_settings_group');
            do_settings_sections('apropos-settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

add_action('admin_init', 'apropos_register_settings');
function apropos_register_settings()
{
    register_setting('apropos_settings_group', 'apropos_hero_title');
    register_setting('apropos_settings_group', 'apropos_hero_subtitle');
    register_setting('apropos_settings_group', 'apropos_hero_image');

    register_setting('apropos_settings_group', 'apropos_superior_title');
    register_setting('apropos_settings_group', 'apropos_superior_message');
    register_setting('apropos_settings_group', 'apropos_superior_signature');
    register_setting('apropos_settings_group', 'apropos_superior_image');

    register_setting('apropos_settings_group', 'apropos_starfish_title');
    register_setting('apropos_settings_group', 'apropos_starfish_text');
    register_setting('apropos_settings_group', 'apropos_starfish_quote');
    register_setting('apropos_settings_group', 'apropos_starfish_quote_author');

    for ($i = 1; $i <= 5; $i++) {
        register_setting('apropos_settings_group', "apropos_history_year_$i");
        register_setting('apropos_settings_group', "apropos_history_title_$i");
        register_setting('apropos_settings_group', "apropos_history_desc_$i");
    }

    register_setting('apropos_settings_group', 'apropos_events_title');
    for ($i = 1; $i <= 4; $i++) {
        register_setting('apropos_settings_group', "apropos_event_{$i}_title");
        register_setting('apropos_settings_group', "apropos_event_{$i}_date");
        register_setting('apropos_settings_group', "apropos_event_{$i}_desc");
    }

    register_setting('apropos_settings_group', 'apropos_missions_title');
    $countries = ['france', 'inde', 'madagascar', 'tchad', 'italie'];
    foreach ($countries as $country) {
        register_setting('apropos_settings_group', "apropos_mission_{$country}_name");
        register_setting('apropos_settings_group', "apropos_mission_{$country}_flag");
        register_setting('apropos_settings_group', "apropos_mission_{$country}_title");
        register_setting('apropos_settings_group', "apropos_mission_{$country}_desc");
    }

    register_setting('apropos_settings_group', 'apropos_support_title');
    register_setting('apropos_settings_group', 'apropos_support_text');
    register_setting('apropos_settings_group', 'apropos_bank_title');
    register_setting('apropos_settings_group', 'apropos_bank_iban');
    register_setting('apropos_settings_group', 'apropos_bank_bic');
    register_setting('apropos_settings_group', 'apropos_contact_title');
    register_setting('apropos_settings_group', 'apropos_contact_address_label');
    register_setting('apropos_settings_group', 'apropos_contact_address');
    register_setting('apropos_settings_group', 'apropos_contact_phone_label');
    register_setting('apropos_settings_group', 'apropos_contact_phone');
    register_setting('apropos_settings_group', 'apropos_contact_email_label');
    register_setting('apropos_settings_group', 'apropos_contact_email');
    register_setting('apropos_settings_group', 'apropos_donation_title');
    register_setting('apropos_settings_group', 'apropos_donation_text');
    register_setting('apropos_settings_group', 'apropos_donation_address');
    register_setting('apropos_settings_group', 'apropos_donation_button');

    // ===== AJOUT DES CHAMPS DANS L'INTERFACE =====
    add_settings_section('apropos_hero_section', '🏠 Section Hero', null, 'apropos-settings');
    add_settings_section('apropos_superior_section', '✉️ Message de la Supérieure', null, 'apropos-settings');
    add_settings_section('apropos_starfish_section', '⭐ Histoire de l\'étoile de mer', null, 'apropos-settings');
    add_settings_section('apropos_history_section', '📜 Notre Histoire (Timeline)', null, 'apropos-settings');
    add_settings_section('apropos_events_section', '📅 Événements récents', null, 'apropos-settings');
    add_settings_section('apropos_missions_section', '🌍 Nos missions dans le monde', null, 'apropos-settings');
    add_settings_section('apropos_support_section', '💝 Soutenir notre mission', null, 'apropos-settings');

    // Champs Hero
    add_settings_field('apropos_hero_title', 'Titre du hero', 'apropos_text_field', 'apropos-settings', 'apropos_hero_section', ['label_for' => 'apropos_hero_title', 'default' => 'À propos de nous']);
    add_settings_field('apropos_hero_subtitle', 'Sous-titre du hero', 'apropos_text_field', 'apropos-settings', 'apropos_hero_section', ['label_for' => 'apropos_hero_subtitle', 'default' => 'Découvrez notre histoire et notre mission']);
    add_settings_field('apropos_hero_image', 'Image de fond (URL)', 'apropos_text_field', 'apropos-settings', 'apropos_hero_section', ['label_for' => 'apropos_hero_image', 'default' => '']);

    // Champs Supérieure
    add_settings_field('apropos_superior_title', 'Titre de la section', 'apropos_text_field', 'apropos-settings', 'apropos_superior_section', ['label_for' => 'apropos_superior_title', 'default' => 'Lettre aux amis et aux familles']);
    add_settings_field('apropos_superior_message', 'Message (HTML autorisé)', 'apropos_textarea_field', 'apropos-settings', 'apropos_superior_section', ['label_for' => 'apropos_superior_message', 'default' => '<p>Chers amis,</p><p>Nous nous préparons à dire au revoir à l\'année 2025...</p>']);
    add_settings_field('apropos_superior_signature', 'Signature', 'apropos_text_field', 'apropos-settings', 'apropos_superior_section', ['label_for' => 'apropos_superior_signature', 'default' => 'Sr Reetha Paul, Supérieure Générale']);
    add_settings_field('apropos_superior_image', 'URL de la photo', 'apropos_text_field', 'apropos-settings', 'apropos_superior_section', ['label_for' => 'apropos_superior_image', 'default' => '']);

    // Champs Étoile de mer
    add_settings_field('apropos_starfish_title', 'Titre', 'apropos_text_field', 'apropos-settings', 'apropos_starfish_section', ['label_for' => 'apropos_starfish_title', 'default' => 'L\'histoire de l\'étoile de mer']);
    add_settings_field('apropos_starfish_text', 'Texte (HTML autorisé)', 'apropos_textarea_field', 'apropos-settings', 'apropos_starfish_section', ['label_for' => 'apropos_starfish_text', 'default' => '<p>« Jim avait l\'habitude de se promener sur la plage...</p>']);
    add_settings_field('apropos_starfish_quote', 'Citation', 'apropos_textarea_field', 'apropos-settings', 'apropos_starfish_section', ['label_for' => 'apropos_starfish_quote', 'default' => '« Nous ne pouvons pas faire de grandes choses, seulement de petites choses avec un grand amour. »']);
    add_settings_field('apropos_starfish_quote_author', 'Auteur de la citation', 'apropos_text_field', 'apropos-settings', 'apropos_starfish_section', ['label_for' => 'apropos_starfish_quote_author', 'default' => 'Mère Teresa']);

    // Timeline (5 entrées)
    for ($i = 1; $i <= 5; $i++) {
        add_settings_field("apropos_history_year_$i", "Année $i", 'apropos_text_field', 'apropos-settings', 'apropos_history_section', ['label_for' => "apropos_history_year_$i", 'default' => $i === 1 ? 'Naissance' : ($i === 2 ? 'Jeunesse' : ($i === 3 ? 'Fondation' : ($i === 4 ? 'Voeux' : 'Aujourd\'hui')))]);
        add_settings_field("apropos_history_title_$i", "Titre $i", 'apropos_text_field', 'apropos-settings', 'apropos_history_section', ['label_for' => "apropos_history_title_$i", 'default' => $i === 1 ? 'Naissance de Marie Virginie Vaslin' : ($i === 2 ? 'Bergère à La Louptière' : ($i === 3 ? 'Premiers pas à Blois' : ($i === 4 ? 'Premiers voeux' : 'Mission dans le monde')))]);
        add_settings_field("apropos_history_desc_$i", "Description $i", 'apropos_text_field', 'apropos-settings', 'apropos_history_section', ['label_for' => "apropos_history_desc_$i", 'default' => $i === 1 ? 'Notre fondatrice est née dans le petit village de Vancé.' : ($i === 2 ? 'Elle travailla comme bergère, vivant dans la simplicité.' : ($i === 3 ? 'Marie Virginie loue une mansarde au 15 rue Beauvoir.' : ($i === 4 ? 'Elle prononce ses premiers voeux à la mairie de Blois.' : 'La Congrégation est aujourd\'hui présente dans le monde.')))]);
    }

    // Événements (4 entrées)
    add_settings_field('apropos_events_title', 'Titre de la section événements', 'apropos_text_field', 'apropos-settings', 'apropos_events_section', ['label_for' => 'apropos_events_title', 'default' => 'Événements récents']);
    for ($i = 1; $i <= 4; $i++) {
        add_settings_field("apropos_event_{$i}_title", "Titre événement $i", 'apropos_text_field', 'apropos-settings', 'apropos_events_section', ['label_for' => "apropos_event_{$i}_title", 'default' => $i === 1 ? 'Inauguration Communauté d\'Allonnes' : ($i === 2 ? 'Visite des sœurs Pèlerines' : ($i === 3 ? 'Jubilés des sœurs' : 'Inauguration école Madagascar'))]);
        add_settings_field("apropos_event_{$i}_date", "Date $i", 'apropos_text_field', 'apropos-settings', 'apropos_events_section', ['label_for' => "apropos_event_{$i}_date", 'default' => $i === 1 ? '8 septembre 2025' : ($i === 2 ? '10 sept - 23 oct 2025' : ($i === 3 ? '14 octobre 2025' : '9 septembre 2025'))]);
        add_settings_field("apropos_event_{$i}_desc", "Description $i", 'apropos_text_field', 'apropos-settings', 'apropos_events_section', ['label_for' => "apropos_event_{$i}_desc", 'default' => $i === 1 ? 'Sr Helan, Sr Irène et Sr Bénédicte commencent leur nouvelle mission.' : ($i === 2 ? 'Accueil de nos sœurs indiennes en pèlerinage en Europe.' : ($i === 3 ? 'Fête du jubilé de Diamant et d\'Argent.' : 'Ouverture de l\'école St François d\'Assise à Antsirabe.'))]);
    }

    // Missions
    add_settings_field('apropos_missions_title', 'Titre de la section missions', 'apropos_text_field', 'apropos-settings', 'apropos_missions_section', ['label_for' => 'apropos_missions_title', 'default' => 'Nos missions dans le monde']);
    $countries = ['france', 'inde', 'madagascar', 'tchad', 'italie'];
    $country_names = ['France', 'Inde', 'Madagascar', 'Tchad', 'Italie'];
    $country_flags = ['🇫🇷', '🇮🇳', '🇲🇬', '🇹🇩', '🇮🇹'];
    $country_titles = ['Maison Mère', 'Provinces', 'École', 'Mission', 'Communautés'];
    $country_descs = ['Communautés à Blois, Tours, Allonnes, Orsay', 'Bangalore et Varanasi', 'Antsirabe', 'N\'Djaména', 'Vérone, Parona, Domegliara'];

    foreach ($countries as $index => $country) {
        add_settings_field("apropos_mission_{$country}_name", "Nom du pays ($country)", 'apropos_text_field', 'apropos-settings', 'apropos_missions_section', ['label_for' => "apropos_mission_{$country}_name", 'default' => $country_names[$index]]);
        add_settings_field("apropos_mission_{$country}_flag", "Drapeau ($country)", 'apropos_text_field', 'apropos-settings', 'apropos_missions_section', ['label_for' => "apropos_mission_{$country}_flag", 'default' => $country_flags[$index]]);
        add_settings_field("apropos_mission_{$country}_title", "Titre ($country)", 'apropos_text_field', 'apropos-settings', 'apropos_missions_section', ['label_for' => "apropos_mission_{$country}_title", 'default' => $country_titles[$index]]);
        add_settings_field("apropos_mission_{$country}_desc", "Description ($country)", 'apropos_text_field', 'apropos-settings', 'apropos_missions_section', ['label_for' => "apropos_mission_{$country}_desc", 'default' => $country_descs[$index]]);
    }

    // Section Soutien
    add_settings_field('apropos_support_title', 'Titre', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_support_title', 'default' => 'Soutenir notre mission']);
    add_settings_field('apropos_support_text', 'Texte d\'introduction', 'apropos_textarea_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_support_text', 'default' => 'La Congrégation peut délivrer des reçus fiscaux pour les dons. Les dons ouvrent droit à une réduction d’impôt sur le revenu égale à 66% de leur montant.']);
    add_settings_field('apropos_bank_title', 'Titre banque', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_bank_title', 'default' => 'Coordonnées bancaires']);
    add_settings_field('apropos_bank_iban', 'IBAN', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_bank_iban', 'default' => 'FR76 3000 3040 9500 0500 0527 047']);
    add_settings_field('apropos_bank_bic', 'BIC', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_bank_bic', 'default' => 'SOGEFRPP']);
    add_settings_field('apropos_contact_title', 'Titre contact', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_contact_title', 'default' => 'Nous contacter']);
    add_settings_field('apropos_contact_address', 'Adresse', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_contact_address', 'default' => '15 rue Monin, 41000 BLOIS']);
    add_settings_field('apropos_contact_phone', 'Téléphone', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_contact_phone', 'default' => '02 54 78 63 97']);
    add_settings_field('apropos_contact_email', 'Email', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_contact_email', 'default' => 'secretariat@congregationfsm.fr']);
    add_settings_field('apropos_donation_title', 'Titre don', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_donation_title', 'default' => 'Faire un don']);
    add_settings_field('apropos_donation_text', 'Texte don', 'apropos_textarea_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_donation_text', 'default' => 'Les dons en espèces, par chèque ou par virement (avec votre adresse pour le reçu) à :']);
    add_settings_field('apropos_donation_address', 'Adresse pour les dons', 'apropos_textarea_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_donation_address', 'default' => "Sœurs Franciscaines Servantes de Marie\n15 rue Monin\n41000 BLOIS"]);
    add_settings_field('apropos_donation_button', 'Texte du bouton', 'apropos_text_field', 'apropos-settings', 'apropos_support_section', ['label_for' => 'apropos_donation_button', 'default' => 'Nous contacter par mail']);
}

// Fonctions auxiliaires pour les champs
function apropos_text_field($args)
{
    $value = get_option($args['label_for'], $args['default']);
    echo "<input type='text' id='{$args['label_for']}' name='{$args['label_for']}' value='" . esc_attr($value) . "' class='regular-text' />";
}

function apropos_textarea_field($args)
{
    $value = get_option($args['label_for'], $args['default']);
    echo "<textarea id='{$args['label_for']}' name='{$args['label_for']}' rows='5' class='large-text'>" . esc_textarea($value) . "</textarea>";
}

// =============================================
// PRÉREMPLISSAGE DES CHAMPS "À PROPOS" AVEC LE CONTENU DU PDF
// =============================================

// Exécuter au chargement du thème
add_action('after_switch_theme', 'apropos_set_default_content');

// Fonction de préremplissage
function apropos_set_default_content()
{
    $defaults = array(
        // Hero
        'apropos_hero_title' => 'À propos de nous',
        'apropos_hero_subtitle' => 'Découvrez l\'histoire et la mission du Foyer Marie Virginie',

        // Supérieure
        'apropos_superior_title' => 'Lettre aux amis et aux familles',
        'apropos_superior_message' => "<p><strong>Chers amis,</strong></p>
<p>Nous nous préparons à dire au revoir à l'année 2025 et attendons avec impatience l'arrivée de la nouvelle année 2026. Oui, dans la joie disons merci pour tout et remplis d'espérance disons oui à tout ce que nous attendons. \"Que ton amour Seigneur soit sur nous comme notre espérance est en toi\" dit le psaume 33/22.</p>
<p>Je voudrais partager avec vous une petite histoire que vous connaissez peut-être déjà « l'histoire de l'étoile de mer ».</p>
<p>« Jim avait l'habitude de se promener sur la plage avant de commencer sa journée de travail. Un jour, alors qu'il marchait le long du rivage, il voit un homme se pencher et ramasser quelque chose par terre puis le jeter aussitôt dans l'océan. Il observa la scène pendant un moment et demanda : « Que faites-vous ? ». L'homme s'arrête, lève les yeux et répond : « Je jette les étoiles de mer dans l'océan, car le soleil est levé et si je ne les jette pas, elles mourront. » Mais, dit Jim : « ne voyez-vous pas qu'il y a des kilomètres et des kilomètres de plage et d'étoiles de mer le long de celles-ci. Vous ne pouvez pas toutes les sauver ». L'homme continue de se baisser, de ramasser les étoiles de mer et de les jeter dans la mer, en disant : « Tu as raison, je fais une différence pour celle-là ».</p>
<p>Chacun d'entre nous est une étoile de mer dans le monde. Parfois, nous sommes rejetés sur le rivage sous la forme de dépression, de déceptions, de stress, de maladie et d'autres problèmes personnels ou collectifs. Nous attendons un geste d'amour, une aide, un mot de réconfort, d'encouragement, un sourire...</p>
<p>Souvent, nous nous plaignons que le monde est ainsi, que les autres sont ainsi, que nous ne pouvons rien y faire… Non, vous et moi pouvons faire la différence. Faisons une différence positive pour la vie de tous ceux qui nous entourent afin que la nouvelle année 2026 soit une année spéciale et différente pour tous !</p>",
        'apropos_superior_signature' => 'Sr Reetha Paul, Supérieure Générale',

        // Étoile de mer
        'apropos_starfish_title' => 'L\'histoire de l\'étoile de mer',
        'apropos_starfish_quote' => '« Nous ne pouvons pas faire de grandes choses, seulement de petites choses avec un grand amour. »',
        'apropos_starfish_quote_author' => 'Mère Teresa',

        // Timeline
        'apropos_history_year_1' => 'Naissance',
        'apropos_history_title_1' => 'Naissance de Marie Virginie Vaslin',
        'apropos_history_desc_1' => 'Notre fondatrice est née dans le petit village de Vancé, dans la Sarthe. Dieu choisit souvent les lieux petits et cachés pour commencer ses grandes œuvres.',

        'apropos_history_year_2' => 'Jeunesse',
        'apropos_history_title_2' => 'Bergère à La Louptière',
        'apropos_history_desc_2' => 'Elle travailla comme bergère, vivant dans la simplicité et la prière, déjà habitée par un profond amour pour Dieu.',

        'apropos_history_year_3' => 'Fondation',
        'apropos_history_title_3' => 'Premiers pas à Blois',
        'apropos_history_desc_3' => 'Marie Virginie loue une mansarde au 15 rue Beauvoir à Blois pour vivre avec les employées de maison et les accompagner spirituellement.',

        'apropos_history_year_4' => 'Voeux',
        'apropos_history_title_4' => 'Premiers voeux',
        'apropos_history_desc_4' => 'À la mairie de Blois, Marie Virginie prononce ses premiers voeux entre les mains de l\'évêque Monseigneur Palu du Parc et devant le Père Venot.',

        'apropos_history_year_5' => 'Aujourd\'hui',
        'apropos_history_title_5' => 'Mission dans le monde',
        'apropos_history_desc_5' => 'La Congrégation est aujourd\'hui présente en France, en Inde, à Madagascar, au Tchad et en Italie, poursuivant la mission d\'accueil et d\'accompagnement.',

        // Événements
        'apropos_events_title' => 'Événements récents',

        'apropos_event_1_title' => 'Inauguration Communauté d\'Allonnes',
        'apropos_event_1_date' => '8 septembre 2025',
        'apropos_event_1_desc' => 'Sr Helan, Sr Irène et Sr Bénédicte commencent leur nouvelle mission à Allonnes, dans la Sarthe. Le 13 septembre, Monseigneur Jean Pierre Vuillemin, évêque du Mans, leur a remis une lettre de Mission pour la charge pastorale d\'une paroisse sans prêtre.',

        'apropos_event_2_title' => 'Visite des sœurs Pèlerines',
        'apropos_event_2_date' => '10 septembre - 23 octobre 2025',
        'apropos_event_2_desc' => 'Accueil à la Maison Mère de nos sœurs indiennes venues en pèlerinage en Europe. Elles ont visité Rome, Assise, Padoue, Lourdes, Paris, Lisieux. À Blois, elles ont marché sur les pas de Marie Virginie.',

        'apropos_event_3_title' => 'Jubilés des sœurs en France',
        'apropos_event_3_date' => '14 octobre 2025',
        'apropos_event_3_desc' => 'Fête du jubilé de Diamant pour Srs Colette et Marie Martine (60 ans) et jubilé d\'Argent pour Sr Archana (25 ans). L\'Eucharistie a été célébrée à la basilique de la Trinité.',

        'apropos_event_4_title' => 'Inauguration école Madagascar',
        'apropos_event_4_date' => '9 septembre 2025',
        'apropos_event_4_desc' => 'L\'école St François d\'Assise ouvre ses portes à Antsirabe avec 370 élèves et 16 salles de classe. Sr Modestine est la Directrice, accompagnée de 12 enseignants.',

        // Missions
        'apropos_missions_title' => 'Nos missions dans le monde',

        'apropos_mission_france_name' => 'France',
        'apropos_mission_france_flag' => '🇫🇷',
        'apropos_mission_france_title' => 'Maison Mère',
        'apropos_mission_france_desc' => 'Communautés à Blois, Tours, Allonnes, Orsay (La Clarté-Dieu)',

        'apropos_mission_inde_name' => 'Inde',
        'apropos_mission_inde_flag' => '🇮🇳',
        'apropos_mission_inde_title' => 'Provinces de Bangalore et Varanasi',
        'apropos_mission_inde_desc' => 'Nombreuses communautés et œuvres éducatives',

        'apropos_mission_madagascar_name' => 'Madagascar',
        'apropos_mission_madagascar_flag' => '🇲🇬',
        'apropos_mission_madagascar_title' => 'Antsirabe',
        'apropos_mission_madagascar_desc' => 'École St François d\'Assise et communautés',

        'apropos_mission_tchad_name' => 'Tchad',
        'apropos_mission_tchad_flag' => '🇹🇩',
        'apropos_mission_tchad_title' => 'N\'Djaména',
        'apropos_mission_tchad_desc' => 'Mission éducative et pastorale. Nouvelles missionnaires malgaches : Sr Joseanne, Sr Nadya',

        'apropos_mission_italie_name' => 'Italie',
        'apropos_mission_italie_flag' => '🇮🇹',
        'apropos_mission_italie_title' => 'Vérone, Parona, Domegliara',
        'apropos_mission_italie_desc' => 'Communautés et missions',

        // Soutien
        'apropos_support_title' => 'Soutenir notre mission',
        'apropos_support_text' => 'La Congrégation peut délivrer des reçus fiscaux pour les dons. Les dons ouvrent droit à une réduction d\'impôt sur le revenu égale à 66% de leur montant.',

        'apropos_bank_title' => 'Coordonnées bancaires',
        'apropos_bank_iban' => 'FR76 3000 3040 9500 0500 0527 047',
        'apropos_bank_bic' => 'SOGEFRPP',

        'apropos_contact_title' => 'Nous contacter',
        'apropos_contact_address' => '15 rue Monin, 41000 BLOIS',
        'apropos_contact_phone' => '02 54 78 63 97',
        'apropos_contact_email' => 'secretariat@congregationfsm.fr',

        'apropos_donation_title' => 'Faire un don',
        'apropos_donation_text' => 'Les dons en espèces, par chèque ou par virement (avec votre adresse pour le reçu) à :',
        'apropos_donation_address' => "Sœurs Franciscaines Servantes de Marie\n15 rue Monin\n41000 BLOIS",
        'apropos_donation_button' => 'Nous contacter par mail',
    );

    foreach ($defaults as $key => $value) {
        if (get_option($key) === false) {
            update_option($key, $value);
        }
    }
}

// Bouton de réinitialisation manuelle (optionnel)
add_action('admin_init', 'apropos_manual_reset');
function apropos_manual_reset()
{
    if (isset($_GET['apropos_reset']) && $_GET['apropos_reset'] === '1' && current_user_can('manage_options')) {
        apropos_set_default_content();
        wp_redirect(admin_url('admin.php?page=apropos-settings&reset=success'));
        exit;
    }
}

// Ajouter un message de succès
add_action('admin_notices', 'apropos_reset_notice');
function apropos_reset_notice()
{
    if (isset($_GET['reset']) && $_GET['reset'] === 'success') {
        echo '<div class="notice notice-success is-dismissible"><p>✅ Tous les champs ont été réinitialisés avec le contenu par défaut.</p></div>';
    }
}

// Ajouter un bouton de réinitialisation dans la page d'admin
add_action('apropos_admin_buttons', 'apropos_add_reset_button');
function apropos_add_reset_button()
{
    $reset_url = admin_url('admin.php?page=apropos-settings&apropos_reset=1');
    echo '<div style="margin: 20px 0; padding: 15px; background: #f0f0f0; border-radius: 5px;">';
    echo '<p>Si vous souhaitez revenir au contenu original du PDF, cliquez sur le bouton ci-dessous :</p>';
    echo '<a href="' . esc_url($reset_url) . '" class="button button-primary" onclick="return confirm(\'Attention : cela va remplacer tous vos textes actuels par ceux du PDF. Continuer ?\');">📄 Restaurer le contenu original du PDF</a>';
    echo '</div>';
}

// Intégrer le bouton dans la page d'admin
add_action('admin_footer', 'apropos_inject_reset_button');
function apropos_inject_reset_button()
{
    $screen = get_current_screen();
    if ($screen->id === 'toplevel_page_apropos-settings') {
        do_action('apropos_admin_buttons');
    }
}

// Charger les scripts pour la page d'options
add_action('admin_enqueue_scripts', 'foyerfsm_admin_scripts');
function foyerfsm_admin_scripts($hook)
{
    if ($hook != 'toplevel_page_foyerfsm-options') return;

    wp_enqueue_media();
    wp_enqueue_script('foyerfsm-admin', get_stylesheet_directory_uri() . '/assets/js/admin-options.js', array('jquery'), '1.0', true);
}

// Options du thème (menu admin)
require_once get_stylesheet_directory() . '/inc/theme-options.php';

/**
 * Chargement des scripts personnalisés
 */
function foyer_enqueue_scripts()
{
    // Charger le custom.js
    wp_enqueue_script(
        'foyer-custom-js',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Ajouter des variables JS si nécessaire
    wp_localize_script('foyer-custom-js', 'foyer_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('foyer_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'foyer_enqueue_scripts');

/**
 * ===== SIMPLIFICATION ADMIN POUR LES SŒURS =====
 */

/**
 * 1. Réorganisation du menu admin pour les non-admins
 */
function simplifier_menu_admin()
{
    if (!current_user_can('administrator')) {
        // Cacher les menus complexes
        remove_menu_page('tools.php');
        remove_menu_page('plugins.php');
        remove_menu_page('themes.php');
        remove_menu_page('options-general.php');

        // Réorganiser l'ordre
        add_menu_page('Accueil', 'Tableau de bord', 'read', 'index.php', '', 'dashicons-admin-home', 2);
    }
}
add_action('admin_menu', 'simplifier_menu_admin', 999);

/**
 * 2. Ajout d'onglets d'aide contextuelle
 */
function ajouter_aide_contextuelle()
{
    $screen = get_current_screen();

    $aide_content = '<h3>📖 Guide d\'utilisation rapide</h3>';
    $aide_content .= '<div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">';
    $aide_content .= '<p><strong>Bienvenue dans l\'interface de gestion du site !</strong></p>';
    $aide_content .= '<ul style="list-style: none; padding-left: 0;">';
    $aide_content .= '<li>✅ <strong>Pages</strong> : Modifiez le contenu des pages (Accueil, À propos, Contact)</li>';
    $aide_content .= '<li>✅ <strong>Articles</strong> : Publiez des actualités et événements</li>';
    $aide_content .= '<li>✅ <strong>Médias</strong> : Ajoutez des photos de la vie au foyer</li>';
    $aide_content .= '<li>✅ <strong>Commentaires</strong> : Répondez aux messages des étudiantes</li>';
    $aide_content .= '</ul>';
    $aide_content .= '<p style="border-top: 1px solid #ddd; padding-top: 10px;">❓ Besoin d\'aide ? Contactez [votre contact]</p>';
    $aide_content .= '</div>';

    $screen->add_help_tab(array(
        'id'      => 'aide-simple',
        'title'   => 'Guide rapide',
        'content' => $aide_content,
    ));

    // Ajouter une deuxième aide spécifique selon la page
    if ($screen->id === 'edit-page' || $screen->id === 'page') {
        $aide_pages = '<h3>📝 Modifier une page</h3>';
        $aide_pages .= '<p>Pour modifier le contenu :</p>';
        $aide_pages .= '<ul>';
        $aide_pages .= '<li>Cliquez sur le texte pour le modifier directement</li>';
        $aide_pages .= '<li>Utilisez le bouton "Mettre à jour" pour enregistrer</li>';
        $aide_pages .= '<li>Pour les photos : utilisez le bouton "Ajouter un média"</li>';
        $aide_pages .= '</ul>';

        $screen->add_help_tab(array(
            'id'      => 'aide-pages',
            'title'   => 'Modifier les pages',
            'content' => $aide_pages,
        ));
    }
}
add_action('current_screen', 'ajouter_aide_contextuelle');

/**
 * 3. Personnalisation du tableau de bord
 */
function personnaliser_tableau_bord()
{
    // Supprimer les widgets inutiles
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');

    // Ajouter un widget personnalisé
    wp_add_dashboard_widget(
        'bienvenue_dashboard',
        'Bienvenue dans votre espace de gestion',
        'afficher_widget_bienvenue'
    );
}
add_action('wp_dashboard_setup', 'personnaliser_tableau_bord');

function afficher_widget_bienvenue()
{
    echo '<div style="text-align: center;">';
    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/logo-foyer.png" style="max-width: 150px; margin-bottom: 15px;">';
    echo '<h3>👋 Bonjour !</h3>';
    echo '<p>Bienvenue dans l\'interface de gestion du site du Foyer.</p>';
    echo '<div style="background: #f0f7f0; padding: 10px; border-radius: 5px; margin: 15px 0;">';
    echo '<strong>📊 Statistiques rapides</strong><br>';
    echo 'Nombre de pages : ' . wp_count_posts('page')->publish . '<br>';
    echo 'Nombre d\'articles : ' . wp_count_posts('post')->publish;
    echo '</div>';
    echo '<p><a href="#" class="button button-primary">➕ Ajouter un contenu</a></p>';
    echo '</div>';
}

/**
 * 4. Simplification de l'éditeur de pages
 */
function simplifier_editeur()
{
    if (!current_user_can('administrator')) {
        // Cacher les metaboxes complexes
        remove_meta_box('postcustom', 'page', 'normal');
        remove_meta_box('commentstatusdiv', 'page', 'normal');
        remove_meta_box('commentsdiv', 'page', 'normal');
        remove_meta_box('slugdiv', 'page', 'normal');
        remove_meta_box('authordiv', 'page', 'normal');
        remove_meta_box('revisionsdiv', 'page', 'normal');
    }
}
add_action('do_meta_boxes', 'simplifier_editeur');

/**
 * 5. Notifications simplifiées
 */
function simplifier_notifications()
{
?>
    <style>
        .notice-info,
        .update-nag {
            display: none !important;
        }

        .updated {
            background: #dff0d8;
            border-left-color: #4CAF50;
        }
    </style>
<?php
}
add_action('admin_head', 'simplifier_notifications');

/**
 * 6. Ajout de champs personnalisés simples pour les pages
 */
function ajouter_champs_simples()
{
    add_meta_box(
        'info_simple',
        'Informations complémentaires',
        'afficher_champs_simples',
        'page',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'ajouter_champs_simples');

function afficher_champs_simples($post)
{
    wp_nonce_field('champs_simples_nonce', 'champs_simples_nonce');
    $sous_titre = get_post_meta($post->ID, '_sous_titre_page', true);
    $couleur = get_post_meta($post->ID, '_couleur_page', true);
?>
    <p>
        <label>Sous-titre :</label>
        <input type="text" name="sous_titre_page" value="<?php echo esc_attr($sous_titre); ?>" style="width: 100%;">
    </p>
    <p>
        <label>Couleur de fond :</label>
        <input type="color" name="couleur_page" value="<?php echo esc_attr($couleur); ?>">
    </p>
<?php
}

function sauvegarder_champs_simples($post_id)
{
    if (
        !isset($_POST['champs_simples_nonce']) ||
        !wp_verify_nonce($_POST['champs_simples_nonce'], 'champs_simples_nonce')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['sous_titre_page'])) {
        update_post_meta($post_id, '_sous_titre_page', sanitize_text_field($_POST['sous_titre_page']));
    }

    if (isset($_POST['couleur_page'])) {
        update_post_meta($post_id, '_couleur_page', sanitize_text_field($_POST['couleur_page']));
    }
}
add_action('save_post', 'sauvegarder_champs_simples');

/**
 * ===== OPTIMISATION SEO ET RÉSEAUX SOCIAUX =====
 */

/**
 * 1. Balises Open Graph pour les réseaux sociaux
 */
function ajouter_open_graph()
{
    if (is_singular()) {
        global $post;
        $excerpt = wp_strip_all_tags(get_the_excerpt());
        $content = wp_strip_all_tags($post->post_content);
        $description = $excerpt ?: mb_substr($content, 0, 155) . '...';
        $image = get_the_post_thumbnail_url($post->ID, 'full');
        $title = get_the_title();
        $url = get_permalink();
    } else {
        $description = get_bloginfo('description');
        $title = get_bloginfo('name');
        $url = home_url();
        $image = get_theme_mod('logo_foyer', '');
    }
?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($description); ?>">
    <?php if ($image): ?>
        <meta property="og:image" content="<?php echo esc_url($image); ?>">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    <?php endif; ?>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($description); ?>">
    <?php if ($image): ?>
        <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'ajouter_open_graph');

/**
 * 2. Balisage Schema.org pour hébergement
 */
function ajouter_schema_org()
{
    if (is_front_page() || is_page('a-propos')) {
        $nom = get_bloginfo('name');
        $description = get_bloginfo('description');
        $ville = get_theme_mod('ville_foyer', 'Ville');
        $telephone = get_theme_mod('telephone_foyer', '');
        $email = get_theme_mod('email_foyer', '');
        $prix = get_theme_mod('prix_chambre', '350');
    ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "LodgingBusiness",
                "name": "<?php echo esc_js($nom); ?>",
                "description": "<?php echo esc_js($description); ?>",
                "image": "<?php echo esc_js(get_theme_mod('image_foyer', '')); ?>",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo esc_js($ville); ?>",
                    "addressCountry": "FR"
                },
                "priceRange": "€€",
                "telephone": "<?php echo esc_js($telephone); ?>",
                "email": "<?php echo esc_js($email); ?>",
                "amenityFeature": [{
                        "@type": "LocationFeatureSpecification",
                        "name": "Chambre pour étudiantes",
                        "value": true
                    },
                    {
                        "@type": "LocationFeatureSpecification",
                        "name": "Cuisine partagée",
                        "value": true
                    },
                    {
                        "@type": "LocationFeatureSpecification",
                        "name": "Espace détente",
                        "value": true
                    },
                    {
                        "@type": "LocationFeatureSpecification",
                        "name": "Wi-Fi inclus",
                        "value": true
                    }
                ],
                "offers": {
                    "@type": "Offer",
                    "price": "<?php echo esc_js($prix); ?>",
                    "priceCurrency": "EUR",
                    "availability": "https://schema.org/InStock",
                    "validFrom": "<?php echo date('Y-m-d'); ?>"
                }
            }
        </script>
    <?php
    }
}
add_action('wp_head', 'ajouter_schema_org');

/**
 * 3. Amélioration du titre SEO
 */
function foyer_wp_title($title, $sep)
{
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if (($paged >= 2 || $page >= 2) && !is_404()) {
        $title = "$title $sep " . sprintf('Page %s', max($paged, $page));
    }

    return $title;
}
add_filter('wp_title', 'foyer_wp_title', 10, 2);

/**
 * 4. URLs canoniques
 */
function ajouter_canonical()
{
    if (is_singular()) {
        echo '<link rel="canonical" href="' . get_permalink() . '" />' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<link rel="canonical" href="' . home_url() . '" />' . "\n";
    } elseif (is_category() || is_tag()) {
        echo '<link rel="canonical" href="' . get_term_link(get_queried_object()) . '" />' . "\n";
    }
}
add_action('wp_head', 'ajouter_canonical');

/**
 * 5. Meta description automatique
 */
function ajouter_meta_description()
{
    if (is_singular()) {
        global $post;
        $excerpt = wp_strip_all_tags(get_the_excerpt());
        if (empty($excerpt)) {
            $content = wp_strip_all_tags($post->post_content);
            $excerpt = mb_substr($content, 0, 155) . '...';
        }
        echo '<meta name="description" content="' . esc_attr($excerpt) . '" />' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<meta name="description" content="' . esc_attr(get_bloginfo('description')) . '" />' . "\n";
    } elseif (is_category()) {
        echo '<meta name="description" content="' . esc_attr(category_description()) . '" />' . "\n";
    }
}
add_action('wp_head', 'ajouter_meta_description', 1);

/**
 * 6. Sitemap simple
 */
function generer_sitemap()
{
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => array('post', 'page'),
        'post_status' => 'publish'
    ));

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    $sitemap .= '<url>';
    $sitemap .= '<loc>' . home_url() . '</loc>';
    $sitemap .= '<priority>1.0</priority>';
    $sitemap .= '</url>';

    foreach ($posts as $post) {
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . get_permalink($post->ID) . '</loc>';
        $sitemap .= '<lastmod>' . get_the_modified_date('Y-m-d', $post->ID) . '</lastmod>';
        $sitemap .= '<priority>0.8</priority>';
        $sitemap .= '</url>';
    }

    $sitemap .= '</urlset>';

    file_put_contents(ABSPATH . 'sitemap.xml', $sitemap);
}
add_action('save_post', 'generer_sitemap');
add_action('publish_post', 'generer_sitemap');

/**
 * Charger les styles dans l'administration
 */
function foyerfsm_admin_styles()
{
    $screen = get_current_screen();

    // Charger uniquement sur notre page d'options
    if ($screen->id === 'toplevel_page_foyerfsm-options') {
        wp_enqueue_style(
            'foyerfsm-admin-css',
            get_stylesheet_directory_uri() . '/assets/css/admin-style.css',
            array(),
            '1.0.0'
        );
    }

    // Charger aussi sur l'éditeur de pages pour les champs personnalisés
    if ($screen->post_type === 'page' && $screen->base === 'post') {
        wp_enqueue_style(
            'foyerfsm-admin-editor-css',
            get_stylesheet_directory_uri() . '/assets/css/admin-style.css',
            array(),
            '1.0.0'
        );
    }
}
add_action('admin_enqueue_scripts', 'foyerfsm_admin_styles');

// =============================================
// CHAMPS PERSONNALISÉS POUR LES CHAMBRES (GUTENBERG)
// =============================================

/**
 * Ajouter les meta boxes pour les chambres
 */
function foyerfsm_ajouter_metaboxes_chambres()
{
    add_meta_box(
        'foyerfsm_chambre_details',
        '🛏️ Détails de la chambre',
        'foyerfsm_metaboxe_chambre_html',
        'chambre',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'foyerfsm_ajouter_metaboxes_chambres');

/**
 * Affichage du contenu de la meta box
 */
function foyerfsm_metaboxe_chambre_html($post)
{
    wp_nonce_field('foyerfsm_sauvegarder_chambre', 'foyerfsm_chambre_nonce');

    $prix = get_post_meta($post->ID, '_chambre_prix', true);
    $surface = get_post_meta($post->ID, '_chambre_surface', true);
    $equipements = get_post_meta($post->ID, '_chambre_equipements', true);
    ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f9f9f9; padding: 20px; border-radius: 8px;">

        <!-- Colonne gauche -->
        <div>
            <h3 style="margin-top: 0; color: #b75b7d;">💰 Tarifs et dimensions</h3>

            <p>
                <label for="chambre_prix" style="display: block; font-weight: 600; margin-bottom: 5px;">Prix mensuel (€) :</label>
                <input type="text" id="chambre_prix" name="chambre_prix" value="<?php echo esc_attr($prix); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Ex: 350">
                <span style="color: #666; font-size: 0.9rem;">Indiquez le prix par mois</span>
            </p>

            <p>
                <label for="chambre_surface" style="display: block; font-weight: 600; margin-bottom: 5px;">Surface (m²) :</label>
                <input type="text" id="chambre_surface" name="chambre_surface" value="<?php echo esc_attr($surface); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Ex: 12">
                <span style="color: #666; font-size: 0.9rem;">Indiquez la surface en m²</span>
            </p>
        </div>

        <!-- Colonne droite -->
        <div>
            <h3 style="margin-top: 0; color: #b75b7d;">📋 Équipements</h3>

            <p>
                <label for="chambre_equipements" style="display: block; font-weight: 600; margin-bottom: 5px;">Liste des équipements :</label>
                <textarea id="chambre_equipements" name="chambre_equipements" rows="6" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: monospace;" placeholder="Lit confortable&#10;Bureau de travail&#10;Armoire&#10;Wi-Fi"><?php echo esc_textarea($equipements); ?></textarea>
                <span style="color: #666; font-size: 0.9rem;">✏️ Un équipement par ligne</span>
            </p>
        </div>

    </div>

    <div style="margin-top: 15px; padding: 10px; background: #f0f6fc; border-left: 4px solid #b75b7d; border-radius: 4px;">
        <p style="margin: 0; color: #333;">
            <strong>📝 Comment remplir :</strong> Ces informations apparaîtront sur la page de présentation des chambres.
        </p>
    </div>
<?php
}

/**
 * Sauvegarder les données de la meta box
 */
function foyerfsm_sauvegarder_chambre($post_id)
{
    // Vérification de sécurité
    if (!isset($_POST['foyerfsm_chambre_nonce']) || !wp_verify_nonce($_POST['foyerfsm_chambre_nonce'], 'foyerfsm_sauvegarder_chambre')) {
        return;
    }

    // Éviter les sauvegardes automatiques
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Vérifier les permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sauvegarder le prix
    if (isset($_POST['chambre_prix'])) {
        update_post_meta($post_id, '_chambre_prix', sanitize_text_field($_POST['chambre_prix']));
    }

    // Sauvegarder la surface
    if (isset($_POST['chambre_surface'])) {
        update_post_meta($post_id, '_chambre_surface', sanitize_text_field($_POST['chambre_surface']));
    }

    // Sauvegarder les équipements
    if (isset($_POST['chambre_equipements'])) {
        update_post_meta($post_id, '_chambre_equipements', sanitize_textarea_field($_POST['chambre_equipements']));
    }
}
add_action('save_post', 'foyerfsm_sauvegarder_chambre');

// =============================================
// SECTION CHAMBRES (NOUVEL ONGLET)
// =============================================

// Ajouter l'onglet
add_action('admin_menu', function () {
    add_submenu_page(
        'foyerfsm-options',
        'Chambres',
        '🛏️ Chambres',
        'manage_options',
        'foyerfsm-options&tab=chambres',
        '__return_false'
    );
}, 999);

// Enregistrer les options
add_action('admin_init', 'foyerfsm_register_chambres_options');
function foyerfsm_register_chambres_options()
{

    // Paramètres généraux
    register_setting('foyerfsm_chambres_options', 'chambres_hero_image');
    register_setting('foyerfsm_chambres_options', 'chambres_hero_title');
    register_setting('foyerfsm_chambres_options', 'chambres_hero_subtitle');
    register_setting('foyerfsm_chambres_options', 'chambres_intro_title');
    register_setting('foyerfsm_chambres_options', 'chambres_intro_text');
    register_setting('foyerfsm_chambres_options', 'chambres_show_button');
    register_setting('foyerfsm_chambres_options', 'chambres_button_text');
    register_setting('foyerfsm_chambres_options', 'chambres_button_link');
    register_setting('foyerfsm_chambres_options', 'chambres_cta_title');
    register_setting('foyerfsm_chambres_options', 'chambres_cta_text');
    register_setting('foyerfsm_chambres_options', 'chambres_cta_button_text');
    register_setting('foyerfsm_chambres_options', 'chambres_cta_button_link');

    // Options pour chaque chambre (jusqu'à 6)
    for ($i = 1; $i <= 6; $i++) {
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_active");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_titre");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_description");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_prix");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_surface");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_image");
        register_setting('foyerfsm_chambres_options', "chambre_{$i}_equipements");
    }

    add_settings_section('foyerfsm_chambres_hero', '🎠 Hero de la page', '__return_empty_string', 'foyerfsm-chambres');
    add_settings_section('foyerfsm_chambres_intro', '📝 Introduction', '__return_empty_string', 'foyerfsm-chambres');
    add_settings_section('foyerfsm_chambres_liste', '🛏️ Liste des chambres (6 maximum)', '__return_empty_string', 'foyerfsm-chambres');
    add_settings_section('foyerfsm_chambres_cta', '🎯 Appel à l\'action final', '__return_empty_string', 'foyerfsm-chambres');

    // === HERO ===
    add_settings_field(
        'chambres_hero_image',
        'Image du hero',
        'foyerfsm_media_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_hero',
        array('name' => 'chambres_hero_image')
    );

    add_settings_field(
        'chambres_hero_title',
        'Titre du hero',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_hero',
        array('name' => 'chambres_hero_title', 'default' => 'Nos chambres')
    );

    add_settings_field(
        'chambres_hero_subtitle',
        'Sous-titre du hero',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_hero',
        array('name' => 'chambres_hero_subtitle', 'default' => 'Des chambres confortables pour étudier dans de bonnes conditions')
    );

    // === INTRODUCTION ===
    add_settings_field(
        'chambres_intro_title',
        'Titre de l\'introduction',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_intro',
        array('name' => 'chambres_intro_title', 'default' => 'Découvrez nos chambres')
    );

    add_settings_field(
        'chambres_intro_text',
        'Texte d\'introduction',
        'foyerfsm_wysiwyg_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_intro',
        array('name' => 'chambres_intro_text', 'default' => '<p>Chaque chambre est unique et dispose de tout le confort nécessaire pour vos études. Découvrez-les ci-dessous.</p>')
    );

    // === CHAMBRES ===
    for ($i = 1; $i <= 6; $i++) {
        add_settings_field(
            "chambre_{$i}_active",
            "Chambre $i - Activer",
            'foyerfsm_checkbox_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_active", 'default' => $i <= 3 ? 1 : 0)
        );

        add_settings_field(
            "chambre_{$i}_titre",
            "Chambre $i - Titre",
            'foyerfsm_text_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_titre", 'default' => $i == 1 ? 'Chambre Douillette' : ($i == 2 ? 'Chambre Confort' : ($i == 3 ? 'Chambre Spacieuse' : "Chambre $i")))
        );

        add_settings_field(
            "chambre_{$i}_description",
            "Chambre $i - Description",
            'foyerfsm_wysiwyg_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_description", 'default' => '<p>Une chambre agréable avec vue sur le jardin.</p>')
        );

        add_settings_field(
            "chambre_{$i}_prix",
            "Chambre $i - Prix mensuel",
            'foyerfsm_text_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_prix", 'default' => $i == 1 ? '350€' : ($i == 2 ? '400€' : ($i == 3 ? '450€' : '350€')))
        );

        add_settings_field(
            "chambre_{$i}_surface",
            "Chambre $i - Surface",
            'foyerfsm_text_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_surface", 'default' => $i == 1 ? '12m²' : ($i == 2 ? '14m²' : ($i == 3 ? '16m²' : '12m²')))
        );

        add_settings_field(
            "chambre_{$i}_image",
            "Chambre $i - Image principale",
            'foyerfsm_media_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_image")
        );

        add_settings_field(
            "chambre_{$i}_equipements",
            "Chambre $i - Équipements (un par ligne)",
            'foyerfsm_textarea_field',
            'foyerfsm-chambres',
            'foyerfsm_chambres_liste',
            array('name' => "chambre_{$i}_equipements", 'default' => "Lit confortable\nBureau de travail\nArmoire\nWi-Fi haut débit")
        );
    }

    // === BOUTON SUR LES CHAMBRES ===
    add_settings_field(
        'chambres_show_button',
        'Afficher le bouton "Demander cette chambre"',
        'foyerfsm_checkbox_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_liste',
        array('name' => 'chambres_show_button', 'default' => 1)
    );

    add_settings_field(
        'chambres_button_text',
        'Texte du bouton',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_liste',
        array('name' => 'chambres_button_text', 'default' => 'Demander cette chambre')
    );

    add_settings_field(
        'chambres_button_link',
        'Lien du bouton',
        'foyerfsm_page_dropdown',
        'foyerfsm-chambres',
        'foyerfsm_chambres_liste',
        array('name' => 'chambres_button_link')
    );

    // === CTA FINAL ===
    add_settings_field(
        'chambres_cta_title',
        'Titre du CTA',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_cta',
        array('name' => 'chambres_cta_title', 'default' => 'Prête à rejoindre notre foyer ?')
    );

    add_settings_field(
        'chambres_cta_text',
        'Texte du CTA',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_cta',
        array('name' => 'chambres_cta_text', 'default' => 'Contactez-nous pour plus d\'informations ou pour organiser une visite.')
    );

    add_settings_field(
        'chambres_cta_button_text',
        'Texte du bouton CTA',
        'foyerfsm_text_field',
        'foyerfsm-chambres',
        'foyerfsm_chambres_cta',
        array('name' => 'chambres_cta_button_text', 'default' => 'Nous contacter')
    );

    add_settings_field(
        'chambres_cta_button_link',
        'Lien du bouton CTA',
        'foyerfsm_page_dropdown',
        'foyerfsm-chambres',
        'foyerfsm_chambres_cta',
        array('name' => 'chambres_cta_button_link')
    );
}


/**
 * Intro pour le pied de page
 */
function foyerfsm_footer_intro()
{
    echo '<p class="description">Configurez les informations affichées dans le pied de page.</p>';
}

// =============================================
// FONCTIONS DE CHAMPS GÉNÉRIQUES
// =============================================

/**
 * Champ texte
 */
function foyerfsm_text_field_cb($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value = get_option($name, $default);

    echo "<input type='text' 
                 name='$name' 
                 value='" . esc_attr($value) . "' 
                 placeholder='" . esc_attr($placeholder) . "'
                 class='regular-text' />";
}

/**
 * Champ textarea
 */
function foyerfsm_textarea_field_cb($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value = get_option($name, $default);

    echo "<textarea name='$name' 
                    rows='4' 
                    class='large-text' 
                    placeholder='" . esc_attr($placeholder) . "'>" . esc_textarea($value) . "</textarea>";
}

/**
 * Case à cocher
 */
function foyerfsm_checkbox_field_cb($args)
{
    $name = $args['name'];
    $label = isset($args['label']) ? $args['label'] : 'Activer';
    $default = isset($args['default']) ? $args['default'] : 0;
    $value = get_option($name, $default);
    $checked = checked(1, $value, false);

    echo "<label>";
    echo "<input type='checkbox' name='$name' value='1' $checked /> ";
    echo esc_html($label);
    echo "</label>";
}

/**
 * Liste déroulante des pages
 */
function foyerfsm_page_dropdown_cb($args)
{
    $name = $args['name'];
    $value = get_option($name, '');

    $pages = get_pages();
    if (empty($pages)) {
        echo '<p>Aucune page trouvée.</p>';
        return;
    }

    echo "<select name='$name'>";
    echo "<option value=''>— Aucun lien —</option>";

    foreach ($pages as $page) {
        $selected = selected($value, $page->ID, false);
        echo "<option value='{$page->ID}' $selected>{$page->post_title}</option>";
    }
    echo "</select>";
}

// =============================================
// SOUS-MENU : CONTACT & BARRE (SOUS OPTIONS FOYER)
// =============================================

/**
 * Ajouter un sous-menu dans Options Foyer
 */
add_action('admin_menu', 'foyerfsm_add_contact_submenu');
function foyerfsm_add_contact_submenu()
{
    add_submenu_page(
        'foyerfsm-options',           // Menu parent (Options Foyer)
        'Contact & Barre',             // Titre de la page
        '📞 Contact & Barre',           // Titre du sous-menu
        'manage_options',               // Capacité requise
        'foyerfsm-contact-bar',         // Slug
        'foyerfsm_render_contact_page'  // Fonction d'affichage
    );
}

/**
 * Enregistrer les options
 */
add_action('admin_init', 'foyerfsm_register_contact_options');
function foyerfsm_register_contact_options()
{

    register_setting('foyerfsm_contact_group', 'contact_adresse');
    register_setting('foyerfsm_contact_group', 'contact_telephone');
    register_setting('foyerfsm_contact_group', 'contact_email');
    register_setting('foyerfsm_contact_group', 'contact_bar_activer');

    add_settings_section(
        'foyerfsm_contact_section',
        '📋 Barre d\'informations (sous le slider)',
        'foyerfsm_contact_intro',
        'foyerfsm-contact-bar'
    );

    add_settings_field(
        'contact_bar_activer',
        'Activer la barre',
        'foyerfsm_checkbox_cb',
        'foyerfsm-contact-bar',
        'foyerfsm_contact_section',
        array(
            'name' => 'contact_bar_activer',
            'label' => 'Afficher la barre de contact sous le slider',
            'default' => 1
        )
    );

    add_settings_field(
        'contact_adresse',
        'Adresse',
        'foyerfsm_text_cb',
        'foyerfsm-contact-bar',
        'foyerfsm_contact_section',
        array(
            'name' => 'contact_adresse',
            'default' => '29 Rue place Coty, Tours 37100',
            'placeholder' => 'Ex: 15 rue Monin, 41000 BLOIS'
        )
    );

    add_settings_field(
        'contact_telephone',
        'Téléphone',
        'foyerfsm_text_cb',
        'foyerfsm-contact-bar',
        'foyerfsm_contact_section',
        array(
            'name' => 'contact_telephone',
            'default' => '01 23 45 67 89',
            'placeholder' => 'Ex: 02 54 78 63 97'
        )
    );

    add_settings_field(
        'contact_email',
        'Email',
        'foyerfsm_text_cb',
        'foyerfsm-contact-bar',
        'foyerfsm_contact_section',
        array(
            'name' => 'contact_email',
            'default' => 'contact@foyer.valkoprod.com',
            'placeholder' => 'Ex: secretariat@foyer.fr'
        )
    );
}

/**
 * Intro pour la section
 */
function foyerfsm_contact_intro()
{
    echo '<p class="description">Ces informations apparaîtront dans la barre colorée sous le slider.</p>';
}

/**
 * Rendu de la page
 */
function foyerfsm_render_contact_page()
{
?>
    <div class="wrap">
        <h1>📞 Contact & Barre d'informations</h1>

        <div class="notice notice-info" style="margin-top: 20px;">
            <p>Configurez ici les informations qui apparaissent dans la barre de contact sous le slider.</p>
        </div>

        <form method="post" action="options.php" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <?php
            settings_fields('foyerfsm_contact_group');
            do_settings_sections('foyerfsm-contact-bar');
            submit_button('Enregistrer les modifications');
            ?>
        </form>

        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-left: 4px solid #b75b7d; border-radius: 5px;">
            <h3>📋 Aperçu</h3>
            <?php
            $adresse = get_option('contact_adresse', '29 Rue place Coty, Tours 37100');
            $telephone = get_option('contact_telephone', '01 23 45 67 89');
            $email = get_option('contact_email', 'contact@foyer.valkoprod.com');
            ?>
            <div style="background: #2c3e50; color: white; padding: 15px; border-radius: 8px;">
                📍 <?php echo esc_html($adresse); ?> |
                📞 <?php echo esc_html($telephone); ?> |
                ✉️ <?php echo esc_html($email); ?>
            </div>
        </div>
    </div>
<?php
}

// =============================================
// FONCTIONS DE CHAMPS
// =============================================

function foyerfsm_text_cb($args)
{
    $name = $args['name'];
    $default = isset($args['default']) ? $args['default'] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    $value = get_option($name, $default);
    echo "<input type='text' name='$name' value='" . esc_attr($value) . "' placeholder='" . esc_attr($placeholder) . "' class='regular-text' />";
}

function foyerfsm_checkbox_cb($args)
{
    $name = $args['name'];
    $label = isset($args['label']) ? $args['label'] : 'Activer';
    $default = isset($args['default']) ? $args['default'] : 0;
    $value = get_option($name, $default);
    $checked = checked(1, $value, false);
    echo "<label><input type='checkbox' name='$name' value='1' $checked /> $label</label>";
}

// =============================================
// DÉSACTIVER LA CONVERSION DES EMOJIS EN IMAGES
// =============================================
add_action('init', 'desactiver_emojis');
function desactiver_emojis()
{
    // Supprimer les actions qui convertissent les emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Supprimer les filtres
    add_filter('emoji_svg_url', '__return_false');
    add_filter('wp_resource_hints', function ($urls, $relation_type) {
        if ($relation_type === 'dns-prefetch') {
            $urls = array_diff($urls, array('https://s.w.org/images/core/emoji/'));
        }
        return $urls;
    }, 10, 2);
}

// =============================================
// ESPACEMENT HOMOGÈNE DU TITRE SUR TOUTES LES PAGES
// =============================================
add_action('wp_head', 'foyerfsm_unified_title_spacing');
function foyerfsm_unified_title_spacing()
{
?>
    <style>
        /* Variables de base */
        :root {
            --header-height: 80px;
            --title-top-space: 30px;
            --title-bottom-space: 20px;
        }

        @media (max-width: 992px) {
            :root {
                --header-height: 70px;
                --title-top-space: 25px;
            }
        }

        @media (max-width: 768px) {
            :root {
                --header-height: 60px;
                --title-top-space: 20px;
            }
        }

        /* TITRES DE PAGE - UNIFICATION */

        /* Pour toutes les pages intérieures */
        body:not(.home) .page-title,
        body:not(.home) h1:first-of-type:not(.hero-title):not(.slide-title) {
            /* margin-top: calc(var(--header-height) + var(--title-top-space)) !important;*/
            margin-top: 85px !important;
            margin-bottom: var(--title-bottom-space) !important;
            text-align: center;
            color: #b75b7d;
            font-size: 2.5rem;
            position: relative;
            padding-bottom: 15px;
        }

        /* Ligne décorative sous le titre */
        body:not(.home) .page-title::after,
        body:not(.home) h1:first-of-type:not(.hero-title):not(.slide-title)::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #b75b7d;
            border-radius: 3px;
        }

        /* Pages spécifiques avec héros */
        .page-hero+.container .page-title,
        .hero-section+.container .page-title,
        .wp-block-cover+.container .page-title {
            margin-top: var(--title-top-space) !important;
        }

        /* Ajustement pour mobile */
        @media (max-width: 768px) {

            body:not(.home) .page-title,
            body:not(.home) h1:first-of-type:not(.hero-title):not(.slide-title) {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {

            body:not(.home) .page-title,
            body:not(.home) h1:first-of-type:not(.hero-title):not(.slide-title) {
                font-size: 1.8rem;
                margin-top: calc(var(--header-height) + 15px) !important;
            }
        }
    </style>
<?php
}

// =============================================
// GALERIE D'IMAGES POUR LES CHAMBRES
// =============================================

/**
 * Ajouter un champ pour la galerie d'images dans les chambres
 */
function foyerfsm_ajouter_metaboxe_galerie()
{
    add_meta_box(
        'foyerfsm_chambre_gallery',
        '📸 Galerie d\'images de la chambre',
        'foyerfsm_metaboxe_gallery_html',
        'chambre',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'foyerfsm_ajouter_metaboxe_galerie');

/**
 * Affichage de la metaboxe galerie
 */
function foyerfsm_metaboxe_gallery_html($post)
{
    wp_nonce_field('foyerfsm_gallery_nonce', 'foyerfsm_gallery_nonce');

    $gallery_images = get_post_meta($post->ID, '_chambre_gallery', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
?>
    <div style="margin: 15px 0;">
        <p><strong>Images supplémentaires de la chambre</strong> (cliquez sur "Ajouter des images" pour sélectionner plusieurs photos)</p>

        <div id="chambre-gallery-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
            <?php foreach ($gallery_images as $image_id) :
                $image_url = wp_get_attachment_image_url($image_id, 'medium');
                if ($image_url) : ?>
                    <div class="gallery-item" data-id="<?php echo $image_id; ?>" style="position: relative; width: 100px; height: 100px;">
                        <img src="<?php echo esc_url($image_url); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">
                        <button type="button" class="remove-gallery-image" data-id="<?php echo $image_id; ?>" style="position: absolute; top: -8px; right: -8px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <input type="hidden" id="chambre_gallery" name="chambre_gallery" value="<?php echo esc_attr(implode(',', $gallery_images)); ?>">

        <button type="button" class="button" id="add-gallery-images">+ Ajouter des images</button>
        <p class="description">Ces images apparaîtront dans le diaporama avec loupe sur la page de présentation.</p>
    </div>

    <style>
        .gallery-item:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        .remove-gallery-image:hover {
            background: #a00 !important;
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            var galleryContainer = $('#chambre-gallery-container');
            var galleryInput = $('#chambre_gallery');
            var frame;

            $('#add-gallery-images').on('click', function(e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Sélectionner les images de la chambre',
                    button: {
                        text: 'Ajouter à la galerie'
                    },
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });

                frame.on('select', function() {
                    var selection = frame.state().get('selection');
                    var currentImages = galleryInput.val() ? galleryInput.val().split(',') : [];

                    selection.each(function(attachment) {
                        var id = attachment.id;
                        var url = attachment.attributes.url;

                        if (!currentImages.includes(id.toString())) {
                            currentImages.push(id);
                            galleryContainer.append(`
                            <div class="gallery-item" data-id="${id}" style="position: relative; width: 100px; height: 100px;">
                                <img src="${url}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px;">
                                <button type="button" class="remove-gallery-image" data-id="${id}" style="position: absolute; top: -8px; right: -8px; background: #dc3232; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">×</button>
                            </div>
                        `);
                        }
                    });

                    galleryInput.val(currentImages.join(','));
                });

                frame.open();
            });

            $(document).on('click', '.remove-gallery-image', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var currentImages = galleryInput.val() ? galleryInput.val().split(',') : [];
                var newImages = currentImages.filter(function(imgId) {
                    return imgId != id;
                });
                galleryInput.val(newImages.join(','));
                $(this).closest('.gallery-item').remove();
            });
        });
    </script>
<?php
}

/**
 * Sauvegarder la galerie
 */
function foyerfsm_sauvegarder_galerie($post_id)
{
    if (!isset($_POST['foyerfsm_gallery_nonce']) || !wp_verify_nonce($_POST['foyerfsm_gallery_nonce'], 'foyerfsm_gallery_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['chambre_gallery'])) {
        $gallery = explode(',', sanitize_text_field($_POST['chambre_gallery']));
        $gallery = array_filter($gallery, 'is_numeric');
        update_post_meta($post_id, '_chambre_gallery', $gallery);
    }
}
add_action('save_post', 'foyerfsm_sauvegarder_galerie');

/**
 * Enqueue des scripts pour la galerie
 */
function foyerfsm_enqueue_gallery_scripts()
{
    // Charger sur les pages qui ont besoin de la galerie
    if (is_front_page() || is_page_template('page-chambres.php') || is_singular('chambre')) {
        wp_enqueue_style(
            'foyerfsm-gallery-css',
            get_stylesheet_directory_uri() . '/assets/css/gallery.css',
            array(),
            '3.0.0'
        );

        wp_enqueue_script(
            'foyerfsm-gallery-js',
            get_stylesheet_directory_uri() . '/assets/js/gallery.js',
            array(),
            '3.0.0',
            true
        );

        wp_localize_script('foyerfsm-gallery-js', 'gallery_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gallery_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'foyerfsm_enqueue_gallery_scripts', 100);

// =============================================
// GESTION DES DISPONIBILITÉS DES CHAMBRES
// =============================================

/**
 * Récupère la liste des chambres disponibles selon l'inventaire
 * @return array Liste des chambres disponibles
 */
function foyerfsm_get_chambres_disponibles()
{
    // Définition des types de chambres (sans prix)
    $types_chambres = array(
        'chambre_9m2' => array(
            'nom' => 'Chambre 9m²',
            'surface' => '9',
            'quantite_totale' => 1
        ),
        'chambre_11m2' => array(
            'nom' => 'Chambre 11m²',
            'surface' => '11',
            'quantite_totale' => 3
        ),
        'chambre_12m2' => array(
            'nom' => 'Chambre 12m²',
            'surface' => '12',
            'quantite_totale' => 2
        ),
        'chambre_14m2' => array(
            'nom' => 'Chambre 14m²',
            'surface' => '14',
            'quantite_totale' => 1
        ),
        'chambre_16m2' => array(
            'nom' => 'Chambre 16m²',
            'surface' => '16',
            'quantite_totale' => 1
        ),
        'chambre_17m2' => array(
            'nom' => 'Chambre 17m²',
            'surface' => '17',
            'quantite_totale' => 1
        )
    );

    $disponibles = array();
    $index = 1;

    foreach ($types_chambres as $key => $config) {
        // Récupérer le nombre de chambres disponibles pour ce type
        $disponible = get_option("disponible_{$key}", $config['quantite_totale']);

        // Créer autant d'objets chambre que de disponibilités
        for ($i = 1; $i <= $disponible; $i++) {
            $chambre = new stdClass();
            $chambre->ID = $key . '_' . $i;
            $chambre->post_title = $config['nom'] . ' - n°' . $index;
            $chambre->post_content = '';
            $chambre->surface = $config['surface'];
            $disponibles[] = $chambre;
            $index++;
        }
    }

    return $disponibles;
}

/**
 * Récupère la surface d'une chambre
 * @param string $chambre_id L'ID de la chambre
 * @return string La surface ou chaîne vide
 */
function foyerfsm_get_chambre_surface($chambre_id)
{
    if (empty($chambre_id)) return '';

    // Extraire le type de chambre depuis l'ID (ex: chambre_9m2_1)
    $parts = explode('_', $chambre_id);
    if (count($parts) >= 2) {
        $type = $parts[0] . '_' . $parts[1]; // chambre_9m2

        $types_surface = array(
            'chambre_9m2' => '9',
            'chambre_11m2' => '11',
            'chambre_12m2' => '12',
            'chambre_14m2' => '14',
            'chambre_16m2' => '16',
            'chambre_17m2' => '17'
        );

        if (isset($types_surface[$type])) {
            return $types_surface[$type];
        }
    }

    return '';
}

// Gestion des disponibilités (menu indépendant)
require_once get_stylesheet_directory() . '/inc/disponibilites-admin.php';

// Ajouter dans functions.php

// 1. Balises meta de base (indispensable)
add_action('wp_head', 'foyerfsm_basic_meta_tags');
function foyerfsm_basic_meta_tags()
{
    // Meta charset et viewport sont déjà dans header.php
?>
    <meta name="author" content="Foyer Marie Virginie - Tours" />
    <meta name="copyright" content="Foyer Marie Virginie" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="French" />
    <meta name="revisit-after" content="7 days" />
    <?php
}

// 2. Données structurées pour le référencement local (TRÈS IMPORTANT)
add_action('wp_footer', 'foyerfsm_schema_local_business');
function foyerfsm_schema_local_business()
{
    if (is_front_page() || is_page(array('contact', 'demander-une-chambre', 'services', 'informations'))) {
        $phone = get_option('foyer_contact_phone', '02 46 99 15 64');
        $email = get_option('foyer_contact_email', 'contact@foyer.fr');
        $address = get_option('foyer_footer_address', '29 Rue Président Coty, Tours 37100');
    ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "StudentAccommodation",
                "name": "Foyer Marie Virginie",
                "description": "Foyer étudiant géré par les Sœurs Franciscaines Servantes de Marie à Tours. Chambres meublées pour étudiantes, cadre calme et sécurisé.",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "<?php echo esc_js($address); ?>",
                    "addressLocality": "Tours",
                    "addressRegion": "Centre-Val de Loire",
                    "postalCode": "37100",
                    "addressCountry": "FR"
                },
                "telephone": "<?php echo esc_js($phone); ?>",
                "email": "<?php echo esc_js($email); ?>",
                "url": "<?php echo esc_url(home_url()); ?>",
                "priceRange": "€€",
                "amenities": ["Douche privative", "Toilettes privatives", "Cuisine commune", "WiFi", "Accès sécurisé"],
                "audience": {
                    "@type": "Audience",
                    "audienceType": "Étudiantes"
                },
                "availableLanguage": ["French"],
                "openingHours": "Mo,Tu,We,Th,Fr 09:00-17:00"
            }
        </script>
    <?php
    }
}

// 3. Données structurées pour les chambres
add_action('wp_footer', 'foyerfsm_schema_chambres');
function foyerfsm_schema_chambres()
{
    if (is_singular('chambre')) {
        $chambre = get_post();
        $surface = get_post_meta(get_the_ID(), '_chambre_surface', true);
        $prix = get_post_meta(get_the_ID(), '_chambre_prix', true);
    ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Product",
                "name": "<?php echo esc_js(get_the_title()); ?>",
                "description": "<?php echo esc_js(get_the_excerpt() ?: 'Chambre étudiante au Foyer Marie Virginie à Tours.'); ?>",
                "offers": {
                    "@type": "Offer",
                    "price": "<?php echo esc_js($prix ?: '350'); ?>",
                    "priceCurrency": "EUR",
                    "availability": "https://schema.org/InStock",
                    "validFrom": "<?php echo date('Y-m-d'); ?>"
                },
                "additionalProperty": [{
                    "@type": "PropertyValue",
                    "name": "Surface",
                    "value": "<?php echo esc_js($surface ?: '12'); ?> m²"
                }]
            }
        </script>
    <?php
    }
}

// 4. Optimisation des titres SEO
add_filter('pre_get_document_title', 'foyerfsm_seo_title');
function foyerfsm_seo_title($title)
{
    if (is_front_page() || is_home()) {
        return 'Foyer Marie Virginie - Chambres étudiantes Tours | Logement meublé pour étudiantes';
    }
    if (is_page('demander-une-chambre')) {
        return 'Demander une chambre étudiante à Tours - Foyer Marie Virginie';
    }
    if (is_page('services')) {
        return 'Services du foyer étudiant Marie Virginie à Tours | Chambres étudiantes';
    }
    if (is_page('informations')) {
        return 'Informations pratiques logement étudiant Tours | Règlement et caution';
    }
    if (is_singular('chambre')) {
        $title = get_the_title();
        return $title . ' - Chambre étudiante meublée Tours - Foyer Marie Virginie';
    }
    if (is_search()) {
        return 'Résultats de recherche - Foyer Marie Virginie Tours';
    }
    if (is_404()) {
        return 'Page non trouvée - Foyer Marie Virginie Tours';
    }
    return $title . ' - Foyer Marie Virginie Tours';
}

// 5. Meta description automatique
add_action('wp_head', 'foyerfsm_meta_description');
function foyerfsm_meta_description()
{
    $description = '';

    if (is_front_page() || is_home()) {
        $description = 'Foyer Marie Virginie à Tours - Chambres étudiantes meublées 9m² à 17m² avec douche privative. Cadre calme et sécurisé géré par les Sœurs Franciscaines. Proche tramway et commodités.';
    } elseif (is_page('demander-une-chambre')) {
        $description = 'Demandez votre chambre étudiante au Foyer Marie Virginie à Tours. Remplissez notre formulaire en ligne pour réserver votre logement meublé.';
    } elseif (is_page('services')) {
        $description = 'Découvrez les services du Foyer Marie Virginie : chambres équipées, espaces communs, sécurité, accompagnement personnalisé. Logement étudiant idéal à Tours.';
    } elseif (is_page('informations')) {
        $description = 'Règlement, caution et conditions de location au Foyer Marie Virginie. Toutes les informations pratiques pour votre logement étudiant à Tours.';
    } elseif (is_singular('chambre')) {
        $surface = get_post_meta(get_the_ID(), '_chambre_surface', true);
        $description = 'Chambre étudiante de ' . ($surface ?: '12') . 'm² au Foyer Marie Virginie à Tours. Meublée, équipée, proche tramway. Logement pour étudiante.';
    } else {
        $description = get_bloginfo('description');
    }

    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    }
}

// 6. Empêcher l'indexation des pages non nécessaires
add_action('wp_head', 'foyerfsm_noindex_pages');
function foyerfsm_noindex_pages()
{
    if (is_search() || is_404() || is_attachment()) {
        echo '<meta name="robots" content="noindex, follow" />' . "\n";
    }
}

// ============================================
// LIEN INVISIBLE POUR LE SEO (VERSION UNIQUE)
// ============================================

add_action('wp_footer', 'foyerfsm_faq_invisible_seo_link');
function foyerfsm_faq_invisible_seo_link()
{
    if (is_front_page()) {
        $faq_page = get_page_by_path('faq-logement-etudiant-tours');
        if ($faq_page) {
            // Lien invisible - uniquement pour les moteurs de recherche
            echo '<div style="display: none; visibility: hidden; position: absolute; z-index: -1;" aria-hidden="true">';
            echo '<a href="' . get_permalink($faq_page->ID) . '">FAQ logement étudiant Tours Foyer Marie Virginie - Chambre étudiante meublée - Demande en ligne</a>';
            echo '</div>';
        }
    }
}

// ============================================
// DONNÉES STRUCTURÉES FAQ (SCHEMA.ORG)
// ============================================

add_action('wp_head', 'foyerfsm_faq_schema');
function foyerfsm_faq_schema()
{
    $faq_page = get_page_by_path('faq-logement-etudiant-tours');

    if ($faq_page && is_page($faq_page->ID)) {
    ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [{
                        "@type": "Question",
                        "name": "Comment faire une demande de chambre étudiante ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Les demandes de chambre se font exclusivement en ligne via le formulaire de demande de chambre sur notre site. Vous serez recontactée dans les plus brefs délais."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Quel est le prix d'une chambre étudiante au Foyer Marie Virginie ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Nos chambres sont disponibles à partir de 350€ par mois, charges comprises (eau, électricité, chauffage, WiFi). Le prix varie selon la surface de la chambre (9m² à 17m²)."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Où se situe le Foyer Marie Virginie à Tours ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Notre foyer est situé au 29 Rue Président Coty, 37100 Tours. Il se trouve à 5 minutes à pied de la station de tramway Christ Roi et à 15 minutes de la gare SNCF."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Les chambres sont-elles équipées ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Chaque chambre est meublée (lit confortable, bureau de travail, armoire de rangement) et dispose d'une connexion WiFi haut débit. Chaque chambre a sa douche et ses toilettes privatives."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Y a-t-il une cuisine dans le foyer ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Oui, une grande cuisine commune entièrement équipée est disponible au 2ème étage, avec une salle à manger conviviale."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Le foyer est-il sécurisé ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Oui, l'accès au bâtiment se fait par badge sécurisé. Une présence rassurante est assurée par les Sœurs Franciscaines."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Peut-on visiter le foyer avant de s'engager ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Oui, les visites sont possibles sur rendez-vous. Contactez-nous via notre page de contact pour planifier votre visite."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Le foyer accepte-t-il les garçons ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Non, le Foyer Marie Virginie est exclusivement dédié aux étudiantes."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Quels sont les horaires de retour le soir ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Le retour est possible jusqu'à 21h. Le silence est recommandé après cette heure pour respecter le repos de toutes."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Comment contacter le foyer ?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Vous pouvez nous contacter par téléphone au 02 46 99 15 64 ou par email à foyerfsmmv@gmail.com."
                        }
                    }
                ]
            }
        </script>
    <?php
    }
}

// Ajouter également le schéma LocalBusiness sur toutes les pages
add_action('wp_head', 'foyerfsm_local_business_schema');
function foyerfsm_local_business_schema()
{
    if (!is_page('faq-logement-etudiant-tours')) {
        $phone = get_option('foyer_contact_phone', '02 46 99 15 64');
        $email = get_option('foyer_contact_email', 'foyerfsmmv@gmail.com');
        $address = get_option('foyer_footer_address', '29 Rue Président Coty, Tours 37100');
    ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "StudentAccommodation",
                "name": "Foyer Marie Virginie",
                "description": "Foyer étudiant géré par les Sœurs Franciscaines Servantes de Marie à Tours. Chambres meublées pour étudiantes avec douche privative.",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "<?php echo esc_js($address); ?>",
                    "addressLocality": "Tours",
                    "addressRegion": "Centre-Val de Loire",
                    "postalCode": "37100",
                    "addressCountry": "FR"
                },
                "telephone": "<?php echo esc_js($phone); ?>",
                "email": "<?php echo esc_js($email); ?>",
                "url": "<?php echo esc_url(home_url()); ?>",
                "priceRange": "€€",
                "amenities": ["Douche privative", "Toilettes privatives", "Cuisine commune", "WiFi", "Accès sécurisé"],
                "audience": {
                    "@type": "Audience",
                    "audienceType": "Étudiantes"
                }
            }
        </script>
<?php
    }
}

// Forcer l'inclusion de la page FAQ dans le sitemap Yoast
add_filter('wpseo_sitemap_exclude_post_type', 'foyerfsm_exclude_nothing', 10, 2);
function foyerfsm_exclude_nothing($exclude, $post_type)
{
    return $exclude;
}

// S'assurer que toutes les pages sont incluses
add_filter('wpseo_sitemap_page_content', 'foyerfsm_ensure_faq_in_sitemap');
function foyerfsm_ensure_faq_in_sitemap($content)
{
    $faq_page = get_page_by_path('faq-logement-etudiant-tours');
    if ($faq_page) {
        $faq_url = get_permalink($faq_page->ID);
        if (strpos($content, $faq_url) === false) {
            // La page n'est pas dans le sitemap, forcer son ajout
            $additional = '<url><loc>' . $faq_url . '</loc><priority>0.6</priority></url>';
            $content = str_replace('</urlset>', $additional . '</urlset>', $content);
        }
    }
    return $content;
}

// ============================================
// ENREGISTRER UN MENU PIED DE PAGE
// ============================================

add_action('after_setup_theme', 'foyerfsm_footer_menu_setup');
function foyerfsm_footer_menu_setup()
{
    register_nav_menus(array(
        'footer-menu' => __('Menu Pied de Page', 'foyerfsm'),
    ));
}

?>