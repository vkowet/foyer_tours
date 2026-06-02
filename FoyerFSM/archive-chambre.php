<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
<div class="wv-page">
  <div class="wv-boxed wv-spacer">
    <div class="inner">
      <div class="ed-element ed-headline custom-theme">
        <h1>Chambres</h1>
      </div>
      <div class="ed-element ed-spacer"><div class="space"></div></div>

      <?php if (have_posts()): ?>
        <div class="ed-element ed-container wv-boxed wv-spacer preset-image-boxes-v3-values-2">
          <div class="inner">
            <?php while (have_posts()): the_post(); ?>
              <div class="ed-element ed-container image-boxes-box wv-overflow_visible">
                <div class="inner">
                  <?php
                    $img_url = '';
                    if (has_post_thumbnail()) {
                      $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    } else {
                      $gallery = foyer_sitejet_get_chambre_gallery_urls(get_the_ID());
                      if (!empty($gallery)) $img_url = $gallery[0];
                    }
                  ?>
                  <?php if ($img_url): ?>
                    <figure class="ed-element ed-image">
                      <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" style="object-fit:cover;width:100%;height:auto;"></a>
                    </figure>
                  <?php endif; ?>
                  <div class="ed-element ed-headline custom-theme">
                    <h3 class="center"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  </div>
                  <div class="ed-element ed-text custom-theme">
                    <p style="text-align:center;"><?php echo esc_html(get_the_excerpt()); ?></p>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>

        <div class="ed-element ed-text custom-theme">
          <?php the_posts_pagination(); ?>
        </div>
      <?php else: ?>
        <div class="ed-element ed-text custom-theme"><p>Aucune chambre.</p></div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
