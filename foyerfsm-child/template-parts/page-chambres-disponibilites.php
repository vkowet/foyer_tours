<?php
/**
 * Template Name: Chambres et disponibilités
 * Description: Affiche les chambres disponibles avec diaporama et formulaire intégré
 */

get_header();
?>

<main class="chambres-disponibilites-page">
    
    <!-- ===== HERO SECTION ===== -->
    <section class="hero-chambres" style="background-image: url('<?php echo esc_url(get_option('chambres_hero_image') ? wp_get_attachment_image_url(get_option('chambres_hero_image'), 'full') : get_stylesheet_directory_uri() . '/assets/images/default-chambres-hero.jpg'); ?>');">
        <div class="hero-overlay">
            <div class="container">
                <h1 class="hero-title"><?php echo esc_html(get_option('chambres_hero_title', 'Nos chambres')); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html(get_option('chambres_hero_subtitle', 'Des espaces conçus pour votre bien-être et votre réussite')); ?></p>
            </div>
        </div>
    </section>
    
    <div class="container">
        
        <!-- ===== FILTRE DE DISPONIBILITÉ ===== -->
        <div class="disponibilite-filtre">
            <div class="filtre-info">
                <span class="filtre-label">Disponibilité :</span>
                <div class="filtre-buttons">
                    <button class="filtre-btn active" data-dispo="all">Toutes les chambres</button>
                    <button class="filtre-btn" data-dispo="disponible">Chambres disponibles</button>
                </div>
            </div>
            <div class="compteur-info">
                <span id="chambres-disponibles-count">0</span> chambre(s) disponible(s)
            </div>
        </div>
        
        <!-- ===== GRILLE DES CHAMBRES ===== -->
        <div class="chambres-grid-dispo" id="chambres-grid">
            <?php
            $args = array(
                'post_type' => 'chambre',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            
            $chambres = new WP_Query($args);
            $total_disponibles = 0;
            
            if ($chambres->have_posts()) : 
                while ($chambres->have_posts()) : $chambres->the_post();
                    $chambre_id = get_the_ID();
                    $prix = get_post_meta($chambre_id, '_chambre_prix', true);
                    $surface = get_post_meta($chambre_id, '_chambre_surface', true);
                    $equipements = get_post_meta($chambre_id, '_chambre_equipements', true);
                    $disponible = get_post_meta($chambre_id, '_chambre_disponible', true);
                    $is_disponible = ($disponible === 'oui' || empty($disponible));
                    
                    if ($is_disponible) $total_disponibles++;
                    
                    $images = array();
                    if (has_post_thumbnail()) {
                        $images[] = get_post_thumbnail_id();
                    }
                    // Récupérer les images supplémentaires (à adapter selon votre structure)
                    for ($i = 1; $i <= 5; $i++) {
                        $img_id = get_post_meta($chambre_id, "_chambre_image_$i", true);
                        if ($img_id) $images[] = $img_id;
                    }
            ?>
            <div class="chambre-card-dispo <?php echo $is_disponible ? 'disponible' : 'indisponible'; ?>" data-disponible="<?php echo $is_disponible ? '1' : '0'; ?>">
                <div class="chambre-card-inner">
                    
                    <!-- Badge disponibilité -->
                    <div class="disponibilite-badge <?php echo $is_disponible ? 'dispo' : 'indispo'; ?>">
                        <?php echo $is_disponible ? '✓ Disponible' : '✗ Indisponible'; ?>
                    </div>
                    
                    <!-- Galerie d'images (carrousel) -->
                    <div class="chambre-gallery swiper-container" data-chambre-id="<?php echo $chambre_id; ?>">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $img_id) : 
                                $img_url = wp_get_attachment_image_url($img_id, 'large');
                                $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                            ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt ?: get_the_title()); ?>" loading="lazy">
                                    <div class="gallery-overlay">
                                        <span class="zoom-icon">🔍</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($images)) : ?>
                                <div class="swiper-slide">
                                    <img src="https://placehold.co/800x600/2c3e50/white?text=<?php echo urlencode(get_the_title()); ?>" alt="<?php the_title_attribute(); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                    
                    <div class="chambre-card-content">
                        <h3 class="chambre-title"><?php the_title(); ?></h3>
                        
                        <div class="chambre-caracteristiques">
                            <?php if ($surface) : ?>
                            <div class="carac-item">
                                <span class="carac-icon">📏</span>
                                <span class="carac-value"><?php echo esc_html($surface); ?> m²</span>
                            </div>
                            <?php endif; ?>
                            <?php if ($prix) : ?>
                            <div class="carac-item prix">
                                <span class="carac-icon">💰</span>
                                <span class="carac-value"><?php echo esc_html($prix); ?> €/mois</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="chambre-description">
                            <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                        </div>
                        
                        <?php if (!empty($equipements)) : 
                            $equipements_list = array_filter(array_map('trim', explode("\n", $equipements)));
                        ?>
                        <div class="chambre-equipements-preview">
                            <?php foreach (array_slice($equipements_list, 0, 3) as $equip) : ?>
                                <span class="equip-tag">✓ <?php echo esc_html($equip); ?></span>
                            <?php endforeach; ?>
                            <?php if (count($equipements_list) > 3) : ?>
                                <span class="equip-more">+<?php echo count($equipements_list) - 3; ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="chambre-actions">
                            <?php if ($is_disponible) : ?>
                                <button class="btn-demande" data-chambre-id="<?php echo $chambre_id; ?>" data-chambre-titre="<?php echo esc_attr(get_the_title()); ?>">
                                    📝 Demander cette chambre
                                </button>
                            <?php else : ?>
                                <button class="btn-demande disabled" disabled>
                                    ⏳ Liste d'attente
                                </button>
                            <?php endif; ?>
                            <button class="btn-details" data-chambre-id="<?php echo $chambre_id; ?>">
                                Voir les détails
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : 
            ?>
            <div class="no-chambres">
                <p>Aucune chambre disponible pour le moment. Revenez bientôt !</p>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- ===== COMPTEUR CACHÉ POUR JS ===== -->
        <input type="hidden" id="total-disponibles" value="<?php echo $total_disponibles; ?>">
        
    </div>
    
    <!-- ===== MODAL FORMULAIRE DE DEMANDE ===== -->
    <div id="demande-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3 class="modal-title">Demander une chambre</h3>
            <div class="modal-chambre-info">
                <p>Chambre sélectionnée : <strong id="modal-chambre-titre"></strong></p>
            </div>
            <form id="demande-chambre-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="demande_chambre">
                <input type="hidden" name="chambre_id" id="form-chambre-id" value="">
                <?php wp_nonce_field('demande_chambre_action', 'demande_chambre_nonce'); ?>
                
                <div class="form-row">
                    <div class="form-field">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-field">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-field">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label for="telephone">Téléphone *</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                </div>
                
                <div class="form-field">
                    <label for="date_entree">Date d'entrée souhaitée *</label>
                    <input type="date" id="date_entree" name="date_entree" required>
                </div>
                
                <div class="form-field">
                    <label for="message">Message (optionnel)</label>
                    <textarea id="message" name="message" rows="4" placeholder="Questions ou informations complémentaires..."></textarea>
                </div>
                
                <div class="form-consent">
                    <input type="checkbox" id="consent" name="consent" required>
                    <label for="consent">J'accepte que mes données soient traitées pour la gestion de ma demande.</label>
                </div>
                
                <button type="submit" class="btn-submit-form">Envoyer ma demande</button>
            </form>
        </div>
    </div>
    
    <!-- ===== MODAL DÉTAILS CHAMBRE ===== -->
    <div id="details-modal" class="modal">
        <div class="modal-content modal-large">
            <span class="modal-close">&times;</span>
            <div id="details-content"></div>
        </div>
    </div>
    
    <!-- ===== LIGHTBOX POUR LES IMAGES ===== -->
    <div id="lightbox" class="lightbox">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-image" src="" alt="">
        <button class="lightbox-prev">❮</button>
        <button class="lightbox-next">❯</button>
    </div>
    
</main>

<?php get_footer(); ?>