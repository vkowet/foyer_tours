<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
<div class="wv-page">
  <div class="wv-boxed wv-spacer">
    <div class="inner">
      <div class="ed-element ed-headline custom-theme">
        <h1><?php echo esc_html(get_the_title(get_option('page_for_posts')) ?: 'Actualités'); ?></h1>
      </div>
      <div class="ed-element ed-spacer"><div class="space"></div></div>

      <?php if (have_posts()): ?>
        <div class="ed-element ed-container wv-boxed wv-spacer">
          <div class="inner">
            <?php while (have_posts()): the_post(); ?>
              <div class="ed-element ed-container image-boxes-box wv-overflow_visible">
                <div class="inner">
                  <?php if (has_post_thumbnail()): ?>
                    <figure class="ed-element ed-image">
                      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', array('style'=>'object-fit:cover;width:100%;height:auto;')); ?></a>
                    </figure>
                  <?php endif; ?>
                  <div class="ed-element ed-headline custom-theme">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  </div>
                  <div class="ed-element ed-text custom-theme">
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                  </div>
                </div>
              </div>
              <div class="ed-element ed-spacer"><div class="space" style="height: 20px;"></div></div>
            <?php endwhile; ?>
          </div>
        </div>

        <div class="ed-element ed-text custom-theme">
          <?php the_posts_pagination(); ?>
        </div>
      <?php else: ?>
        <div class="ed-element ed-text custom-theme"><p>Aucun article.</p></div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
