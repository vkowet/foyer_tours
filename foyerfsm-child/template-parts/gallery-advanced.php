<?php

/**
 * GALERIE AVANCÉE - Version épurée (sans les 3 modèles de chambres)
 */

// Récupération des options générales
$title = get_option('gallery_title', 'Découvrez notre foyer');
$subtitle = get_option('gallery_subtitle', 'Chambres, espaces communs et extérieur');
$slider_speed = get_option('gallery_all_slider_speed', 3000);
$slider_images_per_line = get_option('gallery_all_slider_images_per_line', 5);

// Options des catégories
$chambres_title = get_option('gallery_chambres_title', 'Nos chambres');
$chambres_per_category = get_option('gallery_chambres_images_per_category', 9);
$chambres_columns = get_option('gallery_chambres_columns', 3);
$chambres_rows = get_option('gallery_chambres_rows', 3);

$communs_title = get_option('gallery_communs_title', 'Espaces de vie');
$communs_per_category = get_option('gallery_communs_images_per_category', 6);
$communs_columns = get_option('gallery_communs_columns', 3);
$communs_rows = get_option('gallery_communs_rows', 1);

$exterieur_title = get_option('gallery_exterieur_title', 'Extérieur et jardin');
$exterieur_per_category = get_option('gallery_exterieur_images_per_category', 6);
$exterieur_columns = get_option('gallery_exterieur_columns', 3);
$exterieur_rows = get_option('gallery_exterieur_rows', 1);

// Récupérer les images pour les catégories
$category_images = array();

// Chambres - via le CPT chambre
$chambres_images = array();
$chambres_posts = get_posts(array(
    'post_type' => 'chambre',
    'posts_per_page' => $chambres_per_category,
    'post_status' => 'publish',
    'meta_key' => '_thumbnail_id',
    'orderby' => 'date',
    'order' => 'DESC'
));

foreach ($chambres_posts as $post) {
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    if ($thumbnail_id) {
        $chambres_images[] = get_post($thumbnail_id);
    }
}
if (!empty($chambres_images)) {
    $category_images['chambres'] = $chambres_images;
}

// Espaces communs
$args = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => $communs_per_category,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'image_category',
            'field' => 'slug',
            'terms' => 'communs',
        ),
    ),
);
$images = get_posts($args);
if (!empty($images)) {
    $category_images['communs'] = $images;
}

// Extérieur
$args = array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => $exterieur_per_category,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'image_category',
            'field' => 'slug',
            'terms' => 'exterieur',
        ),
    ),
);
$images = get_posts($args);
if (!empty($images)) {
    $category_images['exterieur'] = $images;
}

// Si aucune image, ne pas afficher la section
if (empty($category_images)) {
    return;
}
?>

<section class="gallery-advanced">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($title); ?></h2>
            <?php if ($subtitle) : ?>
                <p class="section-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <!-- Filtres -->
        <div class="gallery-advanced-filters">
            <button class="filter-btn active" data-filter="all">Toutes</button>
            <?php if (!empty($category_images['chambres'])) : ?>
                <button class="filter-btn" data-filter="chambres"><?php echo esc_html($chambres_title); ?></button>
            <?php endif; ?>
            <?php if (!empty($category_images['communs'])) : ?>
                <button class="filter-btn" data-filter="communs"><?php echo esc_html($communs_title); ?></button>
            <?php endif; ?>
            <?php if (!empty($category_images['exterieur'])) : ?>
                <button class="filter-btn" data-filter="exterieur"><?php echo esc_html($exterieur_title); ?></button>
            <?php endif; ?>
        </div>

        <!-- Conteneur des galeries -->
        <div class="gallery-advanced-container">

            <!-- ===== GALERIE "TOUTES" ===== -->
            <div class="gallery-category active" data-category="all">

                <!-- Section Chambres - Aperçu avec 3 images -->
                <?php if (!empty($category_images['chambres'])) : 
                    $chambres_preview = array_slice($category_images['chambres'], 0, 3);
                ?>
                    <div class="category-sample">
                        <h3 class="sample-title"><?php echo esc_html($chambres_title); ?></h3>
                        <div class="sample-grid" style="--cols: 3;">
                            <?php foreach ($chambres_preview as $image) :
                                $full_url = wp_get_attachment_image_url($image->ID, 'full');
                                $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                            ?>
                                <div class="gallery-advanced-item">
                                    <a href="<?php echo esc_url($full_url); ?>"
                                        class="gallery-advanced-link"
                                        data-category="chambres"
                                        data-category-name="<?php echo esc_attr($chambres_title); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>"
                                            alt="<?php echo esc_attr($image->post_title); ?>"
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
                <?php endif; ?>

                <!-- Espaces communs - 1 ligne de 3 images -->
                <?php if (!empty($category_images['communs'])) :
                    $communs_images = array_slice($category_images['communs'], 0, 3);
                ?>
                    <div class="category-sample">
                        <h3 class="sample-title"><?php echo esc_html($communs_title); ?></h3>
                        <div class="sample-grid" style="--cols: 3;">
                            <?php foreach ($communs_images as $image) :
                                $full_url = wp_get_attachment_image_url($image->ID, 'full');
                                $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                            ?>
                                <div class="gallery-advanced-item">
                                    <a href="<?php echo esc_url($full_url); ?>"
                                        class="gallery-advanced-link"
                                        data-category="communs"
                                        data-category-name="<?php echo esc_attr($communs_title); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>"
                                            alt="<?php echo esc_attr($image->post_title); ?>"
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
                <?php endif; ?>

                <!-- Extérieur - 1 ligne de 3 images -->
                <?php if (!empty($category_images['exterieur'])) :
                    $exterieur_images = array_slice($category_images['exterieur'], 0, 3);
                ?>
                    <div class="category-sample">
                        <h3 class="sample-title"><?php echo esc_html($exterieur_title); ?></h3>
                        <div class="sample-grid" style="--cols: 3;">
                            <?php foreach ($exterieur_images as $image) :
                                $full_url = wp_get_attachment_image_url($image->ID, 'full');
                                $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                            ?>
                                <div class="gallery-advanced-item">
                                    <a href="<?php echo esc_url($full_url); ?>"
                                        class="gallery-advanced-link"
                                        data-category="exterieur"
                                        data-category-name="<?php echo esc_attr($exterieur_title); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>"
                                            alt="<?php echo esc_attr($image->post_title); ?>"
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
                <?php endif; ?>

                <!-- Lien vers la page des chambres -->
                <div class="category-sample-footer">
                    <a href="<?php echo esc_url(home_url('/nos-chambres/')); ?>" class="filter-btn">
                        Voir toutes les chambres →
                    </a>
                </div>
            </div>

            <!-- ===== GALERIE CHAMBRES (COMPLÈTE) ===== -->
            <?php if (!empty($category_images['chambres'])) : ?>
            <div class="gallery-category" data-category="chambres">
                <div class="category-grid" style="--cols: <?php echo $chambres_columns; ?>;">
                    <?php foreach ($category_images['chambres'] as $image) :
                        $full_url = wp_get_attachment_image_url($image->ID, 'full');
                        $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                    ?>
                        <div class="gallery-advanced-item">
                            <a href="<?php echo esc_url($full_url); ?>"
                                class="gallery-advanced-link"
                                data-category="chambres"
                                data-category-name="<?php echo esc_attr($chambres_title); ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>"
                                    alt="<?php echo esc_attr($image->post_title); ?>"
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
            <?php endif; ?>

            <!-- ===== GALERIE ESPACES COMMUNS (COMPLÈTE) ===== -->
            <?php if (!empty($category_images['communs'])) : ?>
            <div class="gallery-category" data-category="communs">
                <div class="category-grid" style="--cols: <?php echo $communs_columns; ?>;">
                    <?php foreach ($category_images['communs'] as $image) :
                        $full_url = wp_get_attachment_image_url($image->ID, 'full');
                        $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                    ?>
                        <div class="gallery-advanced-item">
                            <a href="<?php echo esc_url($full_url); ?>"
                                class="gallery-advanced-link"
                                data-category="communs"
                                data-category-name="<?php echo esc_attr($communs_title); ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>"
                                    alt="<?php echo esc_attr($image->post_title); ?>"
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
            <?php endif; ?>

            <!-- ===== GALERIE EXTÉRIEUR (COMPLÈTE) ===== -->
            <?php if (!empty($category_images['exterieur'])) : ?>
            <div class="gallery-category" data-category="exterieur">
                <div class="category-grid" style="--cols: <?php echo $exterieur_columns; ?>;">
                    <?php foreach ($category_images['exterieur'] as $image) :
                        $full_url = wp_get_attachment_image_url($image->ID, 'full');
                        $thumb_url = wp_get_attachment_image_url($image->ID, 'medium_large');
                    ?>
                        <div class="gallery-advanced-item">
                            <a href="<?php echo esc_url($full_url); ?>"
                                class="gallery-advanced-link"
                                data-category="exterieur"
                                data-category-name="<?php echo esc_attr($exterieur_title); ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>"
                                    alt="<?php echo esc_attr($image->post_title); ?>"
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
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="gallery-lightbox" class="lightbox">
    <button class="lightbox-close">&times;</button>
    <button class="lightbox-prev">❮</button>
    <button class="lightbox-next">❯</button>
    <div class="lightbox-content">
        <img src="" alt="" id="lightbox-image">
        <div class="lightbox-caption"></div>
    </div>
</div>

<!-- Script de filtrage et lightbox -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtrage des catégories
        const filterBtns = document.querySelectorAll('.gallery-advanced-filters .filter-btn');
        const categories = document.querySelectorAll('.gallery-category');

        // Au chargement : s'assurer que seule la catégorie "all" est active
        categories.forEach(cat => {
            if (cat.dataset.category === 'all') {
                cat.classList.add('active');
            } else {
                cat.classList.remove('active');
            }
        });

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                categories.forEach(cat => {
                    if (cat.dataset.category === filter) {
                        cat.classList.add('active');
                    } else {
                        cat.classList.remove('active');
                    }
                });
            });
        });

        // Lightbox
        const lightbox = document.getElementById('gallery-lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCaption = document.querySelector('.lightbox-caption');
        const closeBtn = document.querySelector('.lightbox-close');
        const prevBtn = document.querySelector('.lightbox-prev');
        const nextBtn = document.querySelector('.lightbox-next');

        let currentImages = [];
        let currentIndex = 0;

        function openLightbox(images, startIndex) {
            currentImages = images;
            currentIndex = startIndex;
            showImage(currentIndex);
            lightbox.classList.add('active');
        }

        function showImage(index) {
            if (index >= 0 && index < currentImages.length) {
                lightboxImage.src = currentImages[index].url;
                lightboxCaption.textContent = currentImages[index].caption;
                currentIndex = index;
            }
        }

        // Gestionnaire pour tous les liens de la galerie
        document.querySelectorAll('.gallery-advanced-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const category = this.dataset.category;
                const categoryName = this.dataset.categoryName;

                const images = [];
                document.querySelectorAll(`.gallery-advanced-link[data-category="${category}"]`).forEach(l => {
                    images.push({
                        url: l.href,
                        caption: categoryName
                    });
                });

                const index = images.findIndex(img => img.url === this.href);
                openLightbox(images, index);
            });
        });

        // Navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentImages.length) {
                    showImage(currentIndex - 1);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentImages.length) {
                    showImage(currentIndex + 1);
                }
            });
        }

        // Fermeture
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                lightbox.classList.remove('active');
            });
        }

        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
            }
        });

        // Touches clavier
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') {
                lightbox.classList.remove('active');
            } else if (e.key === 'ArrowLeft') {
                prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                nextBtn.click();
            }
        });
    });
</script>