<?php
/**
 * SECTION GALERIE - Photos des chambres et espaces communs
 */
$gallery_title = get_theme_mod('gallery_title', 'Découvrez notre foyer');
$gallery_subtitle = get_theme_mod('gallery_subtitle', 'Photos des chambres et espaces de vie');
$gallery_count = get_theme_mod('gallery_count', 9);
$show_filters = get_theme_mod('gallery_show_filters', true);
$gallery_style = get_theme_mod('gallery_style', 'grid');

// Récupérer les images de la bibliothèque média
// On prend les dernières images uploadées (ordre chronologique inverse)
$args = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => $gallery_count,
    'orderby' => 'date',
    'order' => 'DESC',
);

$images = get_posts($args);

// Si pas d'images, on ne montre rien
if (empty($images)) return;
?>

<section class="gallery-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($gallery_title); ?></h2>
            <?php if ($gallery_subtitle) : ?>
                <p class="section-subtitle"><?php echo esc_html($gallery_subtitle); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($show_filters) : ?>
        <!-- Filtres par catégorie (optionnel) -->
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all">Toutes</button>
            <button class="filter-btn" data-filter="chambre">Chambres</button>
            <button class="filter-btn" data-filter="commun">Espaces communs</button>
            <button class="filter-btn" data-filter="exterieur">Extérieur</button>
        </div>
        <?php endif; ?>

        <!-- Grille d'images -->
        <div class="gallery-grid <?php echo 'style-' . $gallery_style; ?>">
            <?php foreach ($images as $image) : 
                $image_url = wp_get_attachment_image_url($image->ID, 'large');
                $image_thumb = wp_get_attachment_image_url($image->ID, 'medium');
                $image_title = $image->post_title;
                $image_caption = $image->post_excerpt;
                
                // Essayer de déterminer une catégorie basée sur le titre (optionnel)
                $category = 'other';
                $title_lower = strtolower($image_title);
                if (strpos($title_lower, 'chambre') !== false) $category = 'chambre';
                elseif (strpos($title_lower, 'salon') !== false || strpos($title_lower, 'cuisine') !== false) $category = 'commun';
                elseif (strpos($title_lower, 'jardin') !== false || strpos($title_lower, 'extérieur') !== false) $category = 'exterieur';
            ?>
            <div class="gallery-item" data-category="<?php echo $category; ?>">
                <a href="<?php echo esc_url($image_url); ?>" class="gallery-link" data-lightbox="gallery" data-title="<?php echo esc_attr($image_title); ?>">
                    <img src="<?php echo esc_url($image_thumb); ?>" 
                         alt="<?php echo esc_attr($image_title); ?>" 
                         loading="lazy"
                         class="gallery-image">
                    <?php if ($image_caption) : ?>
                        <div class="gallery-caption"><?php echo esc_html($image_caption); ?></div>
                    <?php endif; ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Bouton "Voir plus" (optionnel) -->
        <?php if (count($images) >= $gallery_count) : ?>
        <div class="gallery-more">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn-outline">
                Voir toutes les photos
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>