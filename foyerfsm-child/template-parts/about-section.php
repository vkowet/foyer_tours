<?php
/**
 * SECTION À PROPOS - 2 BLOCS CÔTE À CÔTE
 * Gérée via Options Foyer > À propos
 */
?>

<section class="about-section section-light">
    <div class="container">
        
        <div class="about-grid">
            
            <!-- COLONNE GAUCHE : IMAGE -->
            <div class="about-image">
                <?php 
                $about_image_id = get_option('about_image', '');
                $about_title = get_option('about_section_title', 'À propos de notre foyer');
                
                if ($about_image_id) :
                    // Utiliser une taille d'image adaptée (medium_large = 768px max)
                    $about_image_url = wp_get_attachment_image_url($about_image_id, 'medium_large');
                    $image_alt = get_post_meta($about_image_id, '_wp_attachment_image_alt', true);
                ?>
                    <img src="<?php echo esc_url($about_image_url); ?>" 
                         alt="<?php echo esc_attr($image_alt ?: $about_title); ?>"
                         loading="lazy">
                <?php else : ?>
                    <img src="https://placehold.co/600x400/2c3e50/white?text=Foyer+FSM" 
                         alt="<?php echo esc_attr($about_title); ?>"
                         loading="lazy">
                <?php endif; ?>
            </div>
            
            <!-- COLONNE DROITE : TEXTE -->
            <div class="about-content">
                <h2 class="section-title">
                    <?php echo esc_html($about_title); ?>
                </h2>
                
                <div class="about-text">
                    <?php 
                    $about_text = get_option('about_text', '');
                    
                    if (empty($about_text)) {
                        $about_text = "Notre foyer, géré par des sœurs Franciscaines, offre un espace chaleureux et accueillant pour les étudiantes. Avec 9 chambres confortables, chacune avec sa salle de bain privée, vous bénéficierez d'un cadre propice à l'étude et à l'épanouissement personnel. À deux pas de toutes les commodités, notre foyer représente une option idéale pour les étudiantes souhaitant vivre sereinement à Tours.";
                    }
                    
                    // Afficher le texte avec les balises HTML autorisées
                    echo wp_kses_post($about_text);
                    ?>
                </div>
                
                <?php 
                $about_button_text = get_option('about_button_text', 'Lire plus sur le foyer');
                $about_button_link = get_option('about_button_link', '');
                
                if (empty($about_button_link)) {
                    $about_button_link = 'https://lefoyer.valkoprod.com/?page_id=320';
                } else {
                    // Si c'est un ID de page, le convertir en lien
                    if (is_numeric($about_button_link) && $about_button_link > 0) {
                        $about_button_link = get_permalink($about_button_link);
                    }
                }
                
                if (!empty($about_button_text)) :
                ?>
                <div class="about-button">
                    <a href="<?php echo esc_url($about_button_link); ?>" class="btn btn-outline">
                        <?php echo esc_html($about_button_text); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>
</section>