<?php

/**
 * Template Name: Présentation des chambres
 * Description: Affiche toutes les chambres du CPT "chambre" avec galerie d'images
 */

get_header();
?>

<main class="chambres-page">

    <!-- ===== HERO ===== -->
    <?php $hero_image = get_option('chambres_hero_image'); ?>
    <?php if ($hero_image) : ?>
        <section class="page-hero" style="background-image: url('<?php echo wp_get_attachment_image_url($hero_image, 'full'); ?>');">
            <div class="hero-overlay" style="background: rgba(0,0,0,0.3);"></div>
        </section>
    <?php endif; ?>

    <div class="container">

        <!-- ===== TITRE ===== -->
        <h1 class="page-title"><?php echo esc_html(get_option('chambres_hero_title', 'Nos chambres')); ?></h1>

        <!-- ===== INTRODUCTION ===== -->
        <?php if (get_option('chambres_intro_text')) : ?>
            <div class="chambres-intro">
                <div class="intro-text">
                    <?php echo wp_kses_post(get_option('chambres_intro_text')); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== LISTE DES CHAMBRES ===== -->
        <?php
        $args = array(
            'post_type' => 'chambre',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $chambres = new WP_Query($args);


        if ($chambres->have_posts()) : ?>
            <div class="chambres-liste">
                <?php
                $compteur = 0;
                while ($chambres->have_posts()) : $chambres->the_post();
                    $compteur++;

                    $prix = get_post_meta(get_the_ID(), '_chambre_prix', true);
                    $surface = get_post_meta(get_the_ID(), '_chambre_surface', true);
                    $equipements = get_post_meta(get_the_ID(), '_chambre_equipements', true);

                    $equipements_array = array();
                    if (!empty($equipements)) {
                        $equipements_array = explode("\n", $equipements);
                        $equipements_array = array_filter(array_map('trim', $equipements_array));
                    }

                    // Récupération des images de la galerie
                    $gallery_images = get_post_meta(get_the_ID(), '_chambre_gallery', true);
                    $gallery_images = is_array($gallery_images) ? $gallery_images : array();
                    $featured_image = get_post_thumbnail_id();

                    $gallery_data = array();

                    if ($featured_image) {
                        $gallery_data[] = array(
                            'full' => wp_get_attachment_image_url($featured_image, 'full'),
                            'thumbnail' => wp_get_attachment_image_url($featured_image, 'medium'),
                            'alt' => get_the_title()
                        );
                    }

                    foreach ($gallery_images as $image_id) {
                        if ($image_id != $featured_image) {
                            $gallery_data[] = array(
                                'full' => wp_get_attachment_image_url($image_id, 'full'),
                                'thumbnail' => wp_get_attachment_image_url($image_id, 'medium'),
                                'alt' => get_the_title()
                            );
                        }
                    }
                ?>

                    <div class="chambre-item <?php echo $compteur % 2 === 0 ? 'reverse' : ''; ?>">

                        <!-- Colonne image avec galerie -->
                        <div class="chambre-image-col">
                            <?php if (!empty($gallery_data)) : ?>
                                <div class="chambre-gallery" data-images='<?php echo json_encode($gallery_data); ?>'>
                                    <div class="chambre-main-image">
                                        <img src="<?php echo esc_url($gallery_data[0]['full']); ?>" alt="<?php the_title_attribute(); ?>">
                                    </div>
                                </div>
                            <?php else : ?>
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'chambre-image']); ?>
                                <?php else : ?>
                                    <img src="https://placehold.co/800x600/2c3e50/white?text=<?php echo urlencode(get_the_title()); ?>" class="chambre-image" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Colonne texte -->
                        <div class="chambre-content-col">
                            <h2 class="chambre-titre"><?php the_title(); ?></h2>

                            <div class="chambre-description">
                                <?php
                                $content = get_the_content();
                                $content = apply_filters('the_content', $content);
                                echo $content;
                                ?>
                            </div>

                            <?php if ($prix || $surface) : ?>
                                <div class="chambre-caracteristiques">
                                    <?php if ($prix) : ?>
                                        <div class="caracteristique prix">
                                            <span class="carac-label">Prix :</span>
                                            <span class="carac-valeur"><?php echo esc_html($prix); ?> € / mois</span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($surface) : ?>
                                        <div class="caracteristique surface">
                                            <span class="carac-label">Surface :</span>
                                            <span class="carac-valeur"><?php echo esc_html($surface); ?> m²</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($equipements_array)) : ?>
                                <div class="chambre-equipements">
                                    <h3>Équipements</h3>
                                    <ul class="equipements-liste">
                                        <?php foreach ($equipements_array as $equipement) : ?>
                                            <?php if (!empty($equipement)) : ?>
                                                <li>✓ <?php echo esc_html($equipement); ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if (get_option('chambres_show_button', 1)) : ?>
                                <div class="chambre-actions">
                                    <a href="<?php echo esc_url(get_option('chambres_button_link', home_url('/demander-une-chambre'))); ?>" class="btn-foyer">
                                        <?php echo esc_html(get_option('chambres_button_text', 'Demander cette chambre')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div style="text-align: center; padding: 60px 0; background: #f9f9f9; border-radius: 10px;">
                <p style="font-size: 1.2rem; color: #666;">Aucune chambre disponible pour le moment.</p>
            </div>
        <?php endif; ?>

        <!-- ===== APPEL À L'ACTION ===== -->
        <?php if (get_option('chambres_cta_title') || get_option('chambres_cta_text')) : ?>
            <div class="chambres-cta">
                <?php if (get_option('chambres_cta_title')) : ?>
                    <h2><?php echo esc_html(get_option('chambres_cta_title')); ?></h2>
                <?php endif; ?>

                <?php if (get_option('chambres_cta_text')) : ?>
                    <p><?php echo esc_html(get_option('chambres_cta_text')); ?></p>
                <?php endif; ?>

                <a href="<?php echo esc_url(get_option('chambres_cta_button_link', home_url('/contact'))); ?>" class="btn-foyer btn-large">
                    <?php echo esc_html(get_option('chambres_cta_button_text', 'Nous contacter')); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<!-- SCRIPT DE LA GALERIE - VERSION FINALE -->
<script>
    (function() {
        console.log('=== GALERIE CHAMBRES ACTIVE ===');

        // Créer la lightbox
        function createLightbox() {
            if (document.getElementById('chambre-gallery-lightbox')) return;

            const lightboxHTML = `
            <div id="chambre-gallery-lightbox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:999999; align-items:center; justify-content:center;">
                <div style="position:relative; max-width:90%; max-height:90%;">
                    <span id="gallery-lightbox-close" style="position:absolute; top:-40px; right:0; color:white; font-size:40px; cursor:pointer; z-index:10;">&times;</span>
                    <img id="gallery-lightbox-img" src="" style="max-width:90vw; max-height:80vh; object-fit:contain; border-radius:5px;">
                    <div style="position:absolute; top:50%; left:0; right:0; transform:translateY(-50%); display:flex; justify-content:space-between;">
                        <button id="gallery-lightbox-prev" style="background:rgba(0,0,0,0.6); color:white; border:none; width:50px; height:50px; border-radius:50%; cursor:pointer; font-size:24px; transition:all 0.3s;">❮</button>
                        <button id="gallery-lightbox-next" style="background:rgba(0,0,0,0.6); color:white; border:none; width:50px; height:50px; border-radius:50%; cursor:pointer; font-size:24px; transition:all 0.3s;">❯</button>
                    </div>
                    <div id="gallery-lightbox-thumbs" style="display:flex; gap:10px; margin-top:20px; justify-content:center; flex-wrap:wrap;"></div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', lightboxHTML);

            // Fermeture
            document.getElementById('gallery-lightbox-close').onclick = function() {
                document.getElementById('chambre-gallery-lightbox').style.display = 'none';
                document.body.style.overflow = '';
            };

            document.getElementById('chambre-gallery-lightbox').onclick = function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                    document.body.style.overflow = '';
                }
            };

            // Navigation clavier
            document.addEventListener('keydown', function(e) {
                const lightbox = document.getElementById('chambre-gallery-lightbox');
                if (!lightbox || lightbox.style.display !== 'flex') return;
                if (e.key === 'Escape') {
                    lightbox.style.display = 'none';
                    document.body.style.overflow = '';
                }
                if (e.key === 'ArrowLeft') document.getElementById('gallery-lightbox-prev')?.click();
                if (e.key === 'ArrowRight') document.getElementById('gallery-lightbox-next')?.click();
            });
        }

        // Initialiser les galeries
        function initGalleries() {
            const galleries = document.querySelectorAll('.chambre-gallery');
            console.log('Galleries trouvées:', galleries.length);

            if (!galleries.length) return;

            createLightbox();

            const lightbox = document.getElementById('chambre-gallery-lightbox');
            const mainImg = document.getElementById('gallery-lightbox-img');
            const prevBtn = document.getElementById('gallery-lightbox-prev');
            const nextBtn = document.getElementById('gallery-lightbox-next');
            const thumbsContainer = document.getElementById('gallery-lightbox-thumbs');

            let currentImages = [];
            let currentIndex = 0;

            galleries.forEach((gallery, idx) => {
                let images = [];
                try {
                    const data = gallery.getAttribute('data-images');
                    if (data) {
                        images = JSON.parse(data);
                        console.log(`Galerie ${idx}: ${images.length} image(s)`);
                    }
                } catch (e) {
                    console.error('Erreur:', e);
                    return;
                }

                if (!images.length) return;

                const mainContainer = gallery.querySelector('.chambre-main-image');
                if (!mainContainer) return;

                // Ajouter la loupe
                mainContainer.style.position = 'relative';

                const magnifier = document.createElement('div');
                magnifier.innerHTML = '🔍';
                magnifier.style.cssText = 'position:absolute; bottom:15px; right:15px; background:rgba(0,0,0,0.7); color:white; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:22px; z-index:10; transition:all 0.3s ease;';
                mainContainer.appendChild(magnifier);

                // Ouvrir la lightbox
                const openLightbox = function() {
                    currentImages = images;
                    currentIndex = 0;

                    mainImg.src = images[0].full;

                    // Miniatures
                    thumbsContainer.innerHTML = '';
                    images.forEach((img, i) => {
                        const thumb = document.createElement('div');
                        thumb.style.cssText = 'width:70px; height:70px; border-radius:5px; overflow:hidden; cursor:pointer; opacity:0.5; transition:all 0.3s; border:2px solid transparent;';
                        if (i === 0) {
                            thumb.style.opacity = '1';
                            thumb.style.borderColor = '#b75b7d';
                        }

                        const thumbImg = document.createElement('img');
                        thumbImg.src = img.thumbnail;
                        thumbImg.style.cssText = 'width:100%; height:100%; object-fit:cover;';
                        thumb.appendChild(thumbImg);

                        thumb.onclick = function() {
                            currentIndex = i;
                            mainImg.src = images[i].full;
                            const allThumbs = thumbsContainer.children;
                            for (let j = 0; j < allThumbs.length; j++) {
                                allThumbs[j].style.opacity = j === i ? '1' : '0.5';
                                allThumbs[j].style.borderColor = j === i ? '#b75b7d' : 'transparent';
                            }
                        };

                        thumbsContainer.appendChild(thumb);
                    });

                    lightbox.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                };

                magnifier.onclick = openLightbox;
                const mainImage = mainContainer.querySelector('img');
                if (mainImage) {
                    mainImage.style.cursor = 'pointer';
                    mainImage.onclick = openLightbox;
                }
            });

            // Navigation
            if (prevBtn) {
                prevBtn.onclick = function() {
                    if (!currentImages.length) return;
                    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                    mainImg.src = currentImages[currentIndex].full;

                    const thumbs = thumbsContainer.children;
                    for (let i = 0; i < thumbs.length; i++) {
                        thumbs[i].style.opacity = i === currentIndex ? '1' : '0.5';
                        thumbs[i].style.borderColor = i === currentIndex ? '#b75b7d' : 'transparent';
                    }
                };
            }

            if (nextBtn) {
                nextBtn.onclick = function() {
                    if (!currentImages.length) return;
                    currentIndex = (currentIndex + 1) % currentImages.length;
                    mainImg.src = currentImages[currentIndex].full;

                    const thumbs = thumbsContainer.children;
                    for (let i = 0; i < thumbs.length; i++) {
                        thumbs[i].style.opacity = i === currentIndex ? '1' : '0.5';
                        thumbs[i].style.borderColor = i === currentIndex ? '#b75b7d' : 'transparent';
                    }
                };
            }

            console.log('✅ Galerie chambres prête !');
        }

        // Exécution
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGalleries);
        } else {
            initGalleries();
        }
    })();
</script>

<style>
    /* Styles pour la galerie des chambres */
    .chambre-main-image {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .chambre-main-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .chambre-main-image:hover img {
        transform: scale(1.02);
    }

    #gallery-lightbox-prev:hover,
    #gallery-lightbox-next:hover {
        background: #b75b7d !important;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {

        #gallery-lightbox-prev,
        #gallery-lightbox-next {
            width: 40px !important;
            height: 40px !important;
            font-size: 18px !important;
        }
    }
</style>

<?php get_footer(); ?>