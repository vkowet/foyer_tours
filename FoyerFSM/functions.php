<?php
/**
 * Foyer Sitejet – functions.php (PRO, clean & stable)
 */

if (!defined('ABSPATH')) {
    exit;
}

/* =========================================================
   CONSTANTES
   ========================================================= */

define('FOYER_SITEJET_VERSION', '1.0.0');
define('FOYER_SITEJET_URI', get_template_directory_uri());
define('FOYER_SITEJET_DIR', get_template_directory());

/* =========================================================
   SETUP DU THÈME
   ========================================================= */

function foyer_sitejet_setup() {

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Menu principal', 'foyer-sitejet'),
        'footer'  => __('Menu pied de page', 'foyer-sitejet'),
    ]);
}
add_action('after_setup_theme', 'foyer_sitejet_setup');

/* =========================================================
   ENQUEUE CSS & JS (UNIFIÉ)
   ========================================================= */

function foyer_sitejet_enqueue_assets() {

    /* ---------- CSS ---------- */

    wp_enqueue_style(
        'foyer-sitejet-style',
        get_stylesheet_uri(),
        [],
        FOYER_SITEJET_VERSION
    );

    wp_enqueue_style(
        'sitejet-app',
        FOYER_SITEJET_URI . '/assets/webcard/static/app.min.1768398951.css',
        [],
        FOYER_SITEJET_VERSION
    );

    wp_enqueue_style(
        'sitejet-custom',
        FOYER_SITEJET_URI . '/assets/css/custom.260127223850.css',
        ['sitejet-app'],
        FOYER_SITEJET_VERSION
    );

    wp_enqueue_style(
        'sitejet-fonts',
        FOYER_SITEJET_URI . '/assets/g/fonts.css',
        [],
        FOYER_SITEJET_VERSION
    );

    /* ---------- JS ---------- */

    wp_enqueue_script(
        'sitejet-app',
        FOYER_SITEJET_URI . '/assets/webcard/static/app.bundle.1768398969.js',
        [],
        FOYER_SITEJET_VERSION,
        true
    );

    wp_enqueue_script(
        'sitejet-custom',
        FOYER_SITEJET_URI . '/assets/js/custom.260127211834.js',
        ['sitejet-app'],
        FOYER_SITEJET_VERSION,
        true
    );

    // Header scroll (desktop)
    wp_enqueue_script(
        'foyer-header-scroll',
        FOYER_SITEJET_URI . '/assets/js/header-scroll.js',
        [],
        FOYER_SITEJET_VERSION,
        true
    );

    // Menu mobile (burger + overlay)
    wp_enqueue_script(
        'foyer-mobile-menu',
        FOYER_SITEJET_URI . '/assets/js/mobile-menu.js',
        [],
        FOYER_SITEJET_VERSION,
        true
    );

    // Barre contact mobile (après scroll)
    wp_enqueue_script(
        'foyer-mobile-contact-bar',
        FOYER_SITEJET_URI . '/assets/js/mobile-contact-bar.js',
        [],
        FOYER_SITEJET_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'foyer_sitejet_enqueue_assets');

/* =========================================================
   DÉSACTIVER STYLES GUTENBERG (FRONT)
   ========================================================= */

add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('global-styles');
}, 100);

/* =========================================================
   CPT – CHAMBRES
   ========================================================= */

function foyer_sitejet_register_cpt_chambre() {

    register_post_type('chambre', [
        'labels' => [
            'name'          => __('Chambres', 'foyer-sitejet'),
            'singular_name' => __('Chambre', 'foyer-sitejet'),
            'add_new_item'  => __('Ajouter une chambre', 'foyer-sitejet'),
            'edit_item'     => __('Modifier la chambre', 'foyer-sitejet'),
        ],
        'public'       => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => ['title', 'editor', 'excerpt', 'thumbnail'],
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'chambres'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'foyer_sitejet_register_cpt_chambre');

/* =========================================================
   FOOTER – WIDGETS
   ========================================================= */

function foyer_sitejet_register_footer_widgets() {

    $columns = [
        'footer-1' => 'Footer – Colonne 1',
        'footer-2' => 'Footer – Colonne 2',
        'footer-3' => 'Footer – Colonne 3',
    ];

    foreach ($columns as $id => $name) {
        register_sidebar([
            'name'          => $name,
            'id'            => $id,
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
        ]);
    }
}
add_action('widgets_init', 'foyer_sitejet_register_footer_widgets');

/* =========================================================
   CUSTOMIZER – FOOTER
   ========================================================= */

function foyer_sitejet_customize_footer($wp_customize) {

    $wp_customize->add_section('foyer_footer_section', [
        'title'    => 'Pied de page – Coordonnées',
        'priority' => 160,
    ]);

    $wp_customize->add_setting('foyer_footer_address', [
        'default' => '29 Rue place Coty, 37100 Tours',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('foyer_footer_address', [
        'label'   => 'Adresse',
        'section' => 'foyer_footer_section',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('foyer_footer_map_enabled', [
        'default' => true,
        'sanitize_callback' => function ($v) { return $v ? true : false; },
    ]);

    $wp_customize->add_control('foyer_footer_map_enabled', [
        'label'   => 'Afficher la carte Google',
        'section' => 'foyer_footer_section',
        'type'    => 'checkbox',
    ]);
}
add_action('customize_register', 'foyer_sitejet_customize_footer');

/* =========================================================
   CUSTOMIZER – CONTACT MOBILE
   ========================================================= */

function foyer_sitejet_customize_contact($wp_customize) {

    $wp_customize->add_section('foyer_contact_section', [
        'title'    => 'Contact rapide (mobile)',
        'priority' => 165,
    ]);

    $fields = [
        'foyer_mobile_bar_enabled' => ['Afficher la barre contact mobile', true, 'checkbox'],
        'foyer_contact_phone'      => ['Téléphone', '0123456789', 'text'],
        'foyer_contact_email'      => ['Email', 'contact@foyer.fr', 'email'],
        'foyer_request_room_url'   => ['Lien – Demander une chambre', '#demande-chambre', 'url'],
    ];

    foreach ($fields as $id => [$label, $default, $type]) {
        $wp_customize->add_setting($id, [
            'default' => $default,
            'sanitize_callback' => $type === 'email' ? 'sanitize_email' : 'sanitize_text_field',
        ]);

        $wp_customize->add_control($id, [
            'label'   => $label,
            'section' => 'foyer_contact_section',
            'type'    => $type,
        ]);
    }
}
add_action('customize_register', 'foyer_sitejet_customize_contact');

/* =========================================================
   MENU RAPIDE – BARRE ADMIN
   ========================================================= */

function foyer_sitejet_admin_bar_menu($wp_admin_bar) {

    if (!current_user_can('edit_theme_options')) return;

    $wp_admin_bar->add_node([
        'id'    => 'foyer-theme-settings',
        'title' => '⚙️ Foyer – Réglages',
        'href'  => admin_url('customize.php'),
    ]);

    $wp_admin_bar->add_node([
        'id'     => 'foyer-theme-contact',
        'parent' => 'foyer-theme-settings',
        'title'  => '📱 Contact mobile',
        'href'   => admin_url('customize.php?autofocus[section]=foyer_contact_section'),
    ]);

    $wp_admin_bar->add_node([
        'id'     => 'foyer-theme-footer',
        'parent' => 'foyer-theme-settings',
        'title'  => '🗺️ Pied de page',
        'href'   => admin_url('customize.php?autofocus[section]=foyer_footer_section'),
    ]);
}
add_action('admin_bar_menu', 'foyer_sitejet_admin_bar_menu', 100);


class Foyer_Mobile_Menu_Walker extends Walker_Nav_Menu {

  public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {

    // Slug de la page à EXCLURE du menu mobile
    if ($item->url === home_url('/demander-une-chambre/') || $item->title === 'Demander une chambre') {
      return;
    }

    parent::start_el($output, $item, $depth, $args, $id);
  }
}
add_action('add_meta_boxes', function () {
  add_meta_box(
    'foyer_chambre_slider',
    'Diaporama (MetaSlider)',
    function ($post) {
      wp_nonce_field('foyer_chambre_slider_save', 'foyer_chambre_slider_nonce');
      $val = get_post_meta($post->ID, '_foyer_slider_shortcode', true);
      echo '<p>Colle ici le shortcode MetaSlider (ex: <code>[metaslider id="123"]</code>)</p>';
      echo '<input type="text" style="width:100%;" name="foyer_slider_shortcode" value="' . esc_attr($val) . '" />';
    },
    'chambre',
    'normal',
    'default'
  );
});

add_action('save_post_chambre', function ($post_id) {
  if (!isset($_POST['foyer_chambre_slider_nonce']) || !wp_verify_nonce($_POST['foyer_chambre_slider_nonce'], 'foyer_chambre_slider_save')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  if (isset($_POST['foyer_slider_shortcode'])) {
    update_post_meta($post_id, '_foyer_slider_shortcode', sanitize_text_field($_POST['foyer_slider_shortcode']));
  }
});

add_action('customize_register', function ($wp_customize) {

  $wp_customize->add_setting('foyer_chambre_flip_enabled', [
    'default' => true,
    'sanitize_callback' => 'wp_validate_boolean',
  ]);

  $wp_customize->add_control('foyer_chambre_flip_enabled', [
    'label'   => 'Activer l’effet de retournement des chambres',
    'section' => 'foyer_contact_section', // ou une section "Chambres" si tu veux
    'type'    => 'checkbox',
  ]);

});

add_filter('body_class', function ($classes) {
  if (!get_theme_mod('foyer_chambre_flip_enabled', true)) {
    $classes[] = 'flip-disabled';
  }
  return $classes;
});
