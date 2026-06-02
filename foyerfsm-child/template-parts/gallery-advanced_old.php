<?php
/**
 * GALERIE AVANCÉE - Version avec échantillon par catégorie
 */
$title = get_option('gallery_advanced_title', 'Découvrez notre foyer');
$subtitle = get_option('gallery_advanced_subtitle', 'Chambres, espaces communs et extérieur');
$per_category = get_option('gallery_images_per_category', 6);
$columns = get_option('gallery_columns', 3);
$rows = get_option('gallery_rows', 2);

// Catégories disponibles
$categories = array(
    'chambres' => 'Chambres',
    'communs' => 'Espaces communs',
    'exterieur' => 'Extérieur',
);

// Récupérer les images pour chaque catégorie
$category_images = array();
$sample_images = array(); // Pour l'échantillon (1 ligne = 3 images)

foreach ($categories as $slug => $name) {
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_status' => 'inherit',
        'posts_per_page' => $per_category, // Pour la vue catégorie
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'image_category',
                'field' => 'slug',
                'terms' => $slug,
            ),
        ),
    );
    
    $images = get_posts($args);
    if (!empty($images)) {
        $category_images[$slug] = $images;
        // Pour l'échantillon, on prend seulement les 3 premières
        $sample_images[$slug] = array_slice($images, 0, 3);
    }
}

// Si aucune image, ne rien afficher
if (empty($category_images)) return;
?>

<section class="gallery-advanced">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($title); ?></h2>
            <?php if ($subtitle) : ?>
                <p class="section-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <!-- Filtres par catégorie -->
        <div class="gallery-advanced-filters">
            <button class="filter-btn active" data-filter="all">Toutes</button>
            <?php foreach ($categories as $slug => $name) : ?>
                <?php if (isset($category_images[$slug])) : ?>
                    <button class="filter-btn" data-filter="<?php echo $slug; ?>"><?php echo $name; ?></button>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Conteneur des galeries -->
        <div class="gallery-advanced-container">
            
            <!-- Galerie "Toutes" (échantillon : 1 ligne par catégorie) -->
            <div class="gallery-category active" data-category="all">
                <?php foreach ($sample_images as $slug => $images) : ?>
                    <div class="category-sample">
                        <h3 class="sample-title"><?php echo $categories[$slug]; ?></h3>
                        <div class="sample-grid" style="--cols: 3;">
                            <?php foreach ($images as $image) : 
                                $full_url = wp_get_attachment_image_url($image->ID, 'full');
                                $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                                $title = $image->post_title;
                            ?>
                                <div class="gallery-advanced-item">
                                    <a href="<?php echo esc_url($full_url); ?>" 
                                       class="gallery-advanced-link" 
                                       data-category="<?php echo $slug; ?>"
                                       data-category-name="<?php echo esc_attr($categories[$slug]); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>" 
                                             alt="<?php echo esc_attr($title); ?>"
                                             loading="lazy"
                                             class="gallery-advanced-image">
                                        <div class="gallery-advanced-overlay">
                                            <span class="gallery-advanced-icon">🔍</span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Galeries par catégorie (vue complète) -->
            <?php foreach ($category_images as $slug => $images) : ?>
                <div class="gallery-category" data-category="<?php echo $slug; ?>">
                    <div class="category-grid" style="--cols: <?php echo $columns; ?>;">
                        <?php 
                        $image_count = 0;
                        foreach ($images as $image) : 
                            if ($image_count >= ($columns * $rows)) break;
                            $full_url = wp_get_attachment_image_url($image->ID, 'full');
                            $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                            $title = $image->post_title;
                            $image_count++;
                        ?>
                            <div class="gallery-advanced-item">
                                <a href="<?php echo esc_url($full_url); ?>" 
                                   class="gallery-advanced-link" 
                                   data-category="<?php echo $slug; ?>"
                                   data-category-name="<?php echo esc_attr($categories[$slug]); ?>">
                                    <img src="<?php echo esc_url($thumb_url); ?>" 
                                         alt="<?php echo esc_attr($title); ?>"
                                         loading="lazy"
                                         class="gallery-advanced-image">
                                    <div class="gallery-advanced-overlay">
                                        <span class="gallery-advanced-icon">🔍</span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>
    </div>
</section>

<!-- Lightbox pour le diaporama -->
<div id="gallery-lightbox" class="lightbox">
    <button class="lightbox-close">&times;</button>
    <button class="lightbox-prev">❮</button>
    <button class="lightbox-next">❯</button>
    <div class="lightbox-content">
        <img src="" alt="" id="lightbox-image">
        <div class="lightbox-caption"></div>
    </div>
</div>