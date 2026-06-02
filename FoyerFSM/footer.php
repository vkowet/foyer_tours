<footer class="site-footer">
  <div class="site-footer-inner">

    <!-- Colonnes footer -->
    <div class="footer-columns">

      <div class="footer-col">
        <?php if (is_active_sidebar('footer-1')) dynamic_sidebar('footer-1'); ?>
      </div>

      <div class="footer-col">
        <?php if (is_active_sidebar('footer-2')) dynamic_sidebar('footer-2'); ?>
      </div>

      <div class="footer-col">
        <?php if (is_active_sidebar('footer-3')) dynamic_sidebar('footer-3'); ?>
      </div>

    </div>

    <!-- 👇 ICI LA CARTE GOOGLE (JUSTE APRÈS LES COLONNES) -->
    <?php
    $address = trim(get_theme_mod('foyer_footer_address'));
    $map_enabled = get_theme_mod('foyer_footer_map_enabled', true);

    if ($map_enabled && $address !== '') :
      $map_url = 'https://www.google.com/maps?q=' . urlencode($address) . '&output=embed';
    ?>
      <div class="footer-map">
        <iframe
          src="<?php echo esc_url($map_url); ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    <?php endif; ?>


    <!-- Bas de footer -->
    <div class="footer-bottom">

      <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'container'      => false,
        'menu_class'     => 'footer-menu',
        'fallback_cb'    => false,
      ]);
      ?>

      <?php if ($address): ?>
        <div class="footer-map-link">
          <a href="https://www.google.com/maps?q=<?php echo urlencode($address); ?>" target="_blank" rel="noopener">
            📍 Voir l’itinéraire
          </a>
        </div>
      <?php endif; ?>


      <p class="footer-copy">
        © <?php echo date('Y'); ?> – Foyer Marie-Virgnie
      </p>

    </div>

  </div>
</footer>

<?php wp_footer(); ?>

<!-- barre footer mobile -->
<?php
$mobile_enabled = get_theme_mod('foyer_mobile_bar_enabled', false);
$request_url = get_theme_mod('foyer_request_room_url');
$phone  = get_theme_mod('foyer_contact_phone');
$email  = get_theme_mod('foyer_contact_email');
?>

<?php if ($mobile_enabled == true): ?>
  <div class="mobile-contact-bar">

    <?php if (!empty($request_url)): ?>
      <a href="<?php echo esc_url($request_url); ?>" class="mobile-cta" aria-label="Demander une chambre">
        <span>Demander une chambre</span>
      </a>

    <?php endif; ?>

    <?php if (!empty($phone)): ?>
      <a href="tel:<?php echo preg_replace('/\s+/', '', esc_attr($phone)); ?>" aria-label="Appeler">
        📞
        <span>Appeler</span>
      </a>
    <?php endif; ?>

    <?php if (!empty($email)): ?>
      <a href="mailto:<?php echo esc_attr($email); ?>" aria-label="Envoyer un mail">
        ✉️
        <span>Nous ecrire</span>
      </a>
    <?php endif; ?>

  </div>
<?php endif; ?>

<!-- SCRIPT DE FORÇAGE DE LA BARRE MOBILE -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si la barre existe
    const mobileBar = document.querySelector('.mobile-contact-bar');

    if (mobileBar) {
      // Forcer l'affichage sur mobile
      if (window.innerWidth <= 768) {
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

        // Ajouter padding au body
        document.body.style.paddingBottom = '80px';
      }
    } else {
      // Si la barre n'existe pas, on la crée
      if (window.innerWidth <= 768) {
        const newBar = document.createElement('div');
        newBar.className = 'mobile-contact-bar force-visible';
        newBar.innerHTML = `
                <a href="<?php echo esc_url(get_theme_mod('foyer_request_room_url', '#contact')); ?>" class="mobile-cta">
                    <span>Demander une chambre</span>
                </a>
                <a href="tel:<?php echo esc_attr(get_theme_mod('foyer_contact_phone', '0123456789')); ?>">
                    📞 <span>Appeler</span>
                </a>
                <a href="mailto:<?php echo esc_attr(get_theme_mod('foyer_contact_email', 'contact@foyer.valkoprod.com')); ?>">
                    ✉️ <span>Nous écrire</span>
                </a>
            `;
        document.body.appendChild(newBar);
        document.body.style.paddingBottom = '80px';
      }
    }
  });
</script>
</body>

</html>