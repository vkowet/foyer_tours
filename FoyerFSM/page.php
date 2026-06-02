<?php
if (!defined('ABSPATH')) { exit; }
get_header();
?>
<div class="wv-page">
  <div class="wv-boxed wv-spacer">
    <div class="inner">
      <div class="ed-element ed-headline custom-theme">
        <h1><?php the_title(); ?></h1>
      </div>
      <div class="ed-element ed-spacer"><div class="space"></div></div>
      <div class="ed-element ed-text custom-theme">
        <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
