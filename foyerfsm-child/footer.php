<footer class="site-footer" style="background-color: <?php echo esc_attr(get_option('footer_background_color', '#2c3e50')); ?>; color: <?php echo esc_attr(get_option('footer_text_color', '#ffffff')); ?>;">
  <div class="site-footer-inner">

    <!-- Colonnes footer -->
    <div class="footer-columns" style="grid-template-columns: repeat(<?php echo get_option('footer_columns_layout', 3); ?>, 1fr);">
      <?php for ($i = 1; $i <= 3; $i++) : ?>
        <div class="footer-col">
          <?php if (is_active_sidebar('footer-' . $i)) dynamic_sidebar('footer-' . $i); ?>
        </div>
      <?php endfor; ?>
    </div>

    <!-- Carte Google Maps -->
    <?php
    $show_map = get_option('footer_show_map', 0);
    $map_address = trim(get_option('footer_map_address', '29 Rue place Coty, Tours 37100'));

    if ($show_map && !empty($map_address)) :
      $map_url = 'https://www.google.com/maps?q=' . urlencode($map_address) . '&output=embed';
    ?>
      <div class="footer-map">
        <iframe
          src="<?php echo esc_url($map_url); ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Carte de localisation du Foyer">
        </iframe>
      </div>

      <!-- Lien itinéraire (mobile) -->
      <div class="footer-map-link">
        <a href="https://www.google.com/maps?q=<?php echo urlencode($map_address); ?>" target="_blank" rel="noopener">
          📍 Voir l’itinéraire
        </a>
      </div>
    <?php endif; ?>

    <!-- Bas de footer -->
    <div class="footer-bottom">

      <!-- Menu footer (visible) -->
      <div class="footer-menu-wrapper">
        <?php
        wp_nav_menu([
          'theme_location' => 'footer-menu',
          'container'      => false,
          'menu_class'     => 'footer-menu',
          'fallback_cb'    => false,
          'depth'          => 1,
        ]);
        ?>
      </div>

      <!-- Copyright -->
      <p class="footer-copy">
        <?php
        $copyright_text = get_option('footer_copyright_text', '© ' . date('Y') . ' – Foyer Marie-Virginie');
        $copyright_link = get_option('footer_copyright_link', '');

        if ($copyright_link) {
          echo '<a href="' . esc_url($copyright_link) . '" style="color: ' . esc_attr(get_option('footer_text_color', '#ffffff')) . ';">' . esc_html($copyright_text) . '</a>';
        } else {
          echo esc_html($copyright_text);
        }
        ?>
      </p>

      <!-- Réseaux sociaux -->
      <?php if (get_option('footer_show_social', 1)) :
        $facebook = get_option('footer_facebook_url', '');
        $instagram = get_option('footer_instagram_url', '');
        $linkedin = get_option('footer_linkedin_url', '');

        if ($facebook || $instagram || $linkedin) : ?>
          <div class="footer-social">
            <?php if ($facebook) : ?>
              <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook" class="social-icon">📘</a>
            <?php endif; ?>

            <?php if ($instagram) : ?>
              <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram" class="social-icon">📷</a>
            <?php endif; ?>

            <?php if ($linkedin) : ?>
              <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn" class="social-icon">🔗</a>
            <?php endif; ?>
          </div>
      <?php endif;
      endif; ?>

    </div>

  </div>
</footer>

<?php wp_footer(); ?>

<!-- Barre mobile -->
<?php
$mobile_enabled = get_option('foyer_mobile_bar_enabled', 1);
$request_url_raw = get_option('foyer_request_room_url', '#contact');
$phone = get_option('foyer_contact_phone', '01 23 45 67 89');
$email = get_option('foyer_contact_email', 'contact@foyer.valkoprod.com');

if (is_numeric($request_url_raw) && $request_url_raw > 0) {
  $request_url = get_permalink($request_url_raw);
} else {
  $request_url = $request_url_raw;
}
?>

<?php if ($mobile_enabled) : ?>
  <div class="mobile-contact-bar">
    <?php if (!empty($request_url)) : ?>
      <a href="<?php echo esc_url($request_url); ?>" class="mobile-cta">
        <span>Demander une chambre</span>
      </a>
    <?php endif; ?>

    <?php if (!empty($phone)) : ?>
      <a href="tel:<?php echo preg_replace('/\s+/', '', esc_attr($phone)); ?>">
        📞 <span>Appeler</span>
      </a>
    <?php endif; ?>

    <?php if (!empty($email)) : ?>
      <a href="mailto:<?php echo esc_attr($email); ?>">
        ✉️ <span>Nous écrire</span>
      </a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<!-- Bouton scroll to top -->
<?php if (get_option('footer_show_scroll_top', 1)) : ?>
  <button id="scroll-to-top" aria-label="Retour en haut">↑</button>
  <style>
    #scroll-to-top {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: #8b5a2b;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 24px;
      box-shadow: 0 4px 15px rgba(139, 90, 43, 0.3);
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
      box-shadow: 0 6px 20px rgba(139, 90, 43, 0.4);
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
      if (btn) {
        window.addEventListener('scroll', function() {
          btn.classList.toggle('visible', window.scrollY > 300);
        });
        btn.addEventListener('click', function() {
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }
    });
  </script>
<?php endif; ?>

<!-- Script barre mobile -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileBar = document.querySelector('.mobile-contact-bar');
    if (mobileBar && window.innerWidth <= 768) {
      mobileBar.style.display = 'flex';
      mobileBar.style.transform = 'translateY(0)';
      mobileBar.style.opacity = '1';
      mobileBar.style.visibility = 'visible';
      mobileBar.style.position = 'fixed';
      mobileBar.style.bottom = '0';
      mobileBar.style.left = '0';
      mobileBar.style.right = '0';
      mobileBar.style.zIndex = '999999';
      mobileBar.style.background = '#2c3e50';
      mobileBar.style.padding = '10px 15px';
      mobileBar.style.borderTop = '2px solid #8b5a2b';
      document.body.style.paddingBottom = '80px';
    }
  });
</script>

</body>
</html>