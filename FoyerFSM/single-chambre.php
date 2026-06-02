<?php get_header(); ?>

<main class="single-chambre">
  <div class="container">

    <h1><?php the_title(); ?></h1>

    <?php
      $slider = get_post_meta(get_the_ID(), '_foyer_slider_shortcode', true);
      if ($slider) {
        echo '<div class="chambre-slider">';
        echo do_shortcode($slider);
        echo '</div>';
      } elseif (has_post_thumbnail()) {
        echo '<div class="chambre-hero">';
        the_post_thumbnail('large');
        echo '</div>';
      }
    ?>

    <div class="chambre-description">
      <?php the_content(); ?>
    </div>

    <?php if (get_the_excerpt()) : ?>
      <div class="chambre-features">
        <h2>Caractéristiques</h2>
        <p><?php echo esc_html(get_the_excerpt()); ?></p>
      </div>
    <?php endif; ?>

    <div class="chambre-cta">
      <a href="#contact-us-1" class="btn-sitejet">Demander une chambre</a>
    </div>

  </div>
</main>

<?php get_footer(); ?>
