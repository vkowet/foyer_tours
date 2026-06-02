<?php
/**
 * Réglages Customizer - Slider, À propos et Nos Valeurs
 */

// =============================================
// SECTION SLIDER
// =============================================
add_action('customize_register', 'foyerfsm_slider_settings');
function foyerfsm_slider_settings($wp_customize) {
    $wp_customize->add_section('foyerfsm_slider_section', array(
        'title'    => '🎠 Slider accueil',
        'priority' => 35,
    ));
    // ... (ton code existant pour le slider)
}

// =============================================
// SECTION À PROPOS
// =============================================
add_action('customize_register', 'foyerfsm_about_settings');
function foyerfsm_about_settings($wp_customize) {
    $wp_customize->add_section('foyerfsm_about_section', array(
        'title'    => '🏠 À propos',
        'priority' => 45,
    ));
    // ... (ton code existant pour "À propos")
}

// =============================================
// SECTION NOS VALEURS (L'ANCIENNE QUI FONCTIONNE)
// =============================================
add_action('customize_register', 'foyerfsm_values_settings');
function foyerfsm_values_settings($wp_customize) {
    
    $wp_customize->add_section('foyerfsm_values_section', array(
        'title'    => '✨ Nos Valeurs',
        'priority' => 50,
        'description' => 'Modifiez les 3 valeurs principales.',
    ));

    for ($i = 1; $i <= 3; $i++) {
        // Activation
        $wp_customize->add_setting("value_{$i}_active", array(
            'default' => 1,
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