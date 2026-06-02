<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header class="site-header is-hero">
    <div class="site-header-inner">

      <!-- LOGO -->
      <div class="site-logo">
        <?php
        if (has_custom_logo()) {
          the_custom_logo();
        } else {
          echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
        }
        ?>
      </div>

      <!-- MENU DESKTOP -->
      <nav class="site-navigation desktop-nav">
        <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'mobile-menu-list',
          'walker'         => new Foyer_Mobile_Menu_Walker(),
        ]);

        ?>
      </nav>

      <!-- BURGER MOBILE -->
      <button class="mobile-menu-toggle" aria-label="Ouvrir le menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

    </div>
  </header>

  <!-- MENU MOBILE OVERLAY -->
  <div class="mobile-menu-overlay">
    <nav class="mobile-menu">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'mobile-menu-list',
      ]);
      ?>
      <a href="#contact-us-1" class="mobile-menu-cta">
        Demander une chambre
      </a>

    </nav>
  </div>