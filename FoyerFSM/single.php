<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
<div class="wv-page">
  <div class="wv-boxed wv-spacer">
    <div class="inner">
      <?php while (have_posts()): the_post(); ?>
        <div class="ed-element ed-headline custom-theme">
          <h1><?php the_title(); ?></h1>
        </div>
        <div class="ed-element ed-text custom-theme">
          <p><small><?php echo esc_html(get_the_date()); ?></small></p>
        </div>
        <div class="ed-element ed-spacer"><div class="space"></div></div>

        <?php if (has_post_thumbnail()): ?>
          <figure class="ed-element ed-image">
            <?php the_post_thumbnail('large', array('style'=>'width:100%;height:auto;object-fit:cover;')); ?>
          </figure>
          <div class="ed-element ed-spacer"><div class="space"></div></div>
        <?php endif; ?>

        <div class="ed-element ed-text custom-theme">
          <?php the_content(); ?>
        </div>

      <?php endwhile; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
