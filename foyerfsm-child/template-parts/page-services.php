<?php
/**
 * Template Name: Services
 * Description: Page présentant les services du foyer
 */

get_header();
?>
<!-- DEBUG SERVEUR -->
<div style="display:none;">
    <?php echo 'Server: ' . $_SERVER['SERVER_SOFTWARE']; ?>
    <?php echo ' PHP: ' . PHP_VERSION; ?>
</div>

<main class="services-page">
    
    <div class="container">
        
        <!-- ===== EN-TÊTE DE PAGE ===== -->
        <div class="page-header">
            <h1 class="page-title"><?php echo esc_html(get_option('services_page_title', 'Nos services')); ?></h1>
            <p class="page-subtitle"><?php echo esc_html(get_option('services_page_subtitle', 'Découvrez tous les services mis à votre disposition')); ?></p>
        </div>
        
        <!-- ===== INTRODUCTION ===== -->
        <div class="intro-card">
            <div class="intro-icon">✨</div>
            <div class="intro-text">
                <?php 
                $intro_text = get_option('services_intro_text', '<p>Notre foyer met à disposition de ses résidentes de nombreux services pour faciliter leur quotidien et favoriser leur épanouissement.</p>');
                echo wp_kses_post($intro_text);
                ?>
            </div>
        </div>

        <!-- ===== GRILLE DES SERVICES ===== -->
        <div class="services-grid">
            
            <?php
            // Configuration des services (icônes par défaut)
            $service_icons = [
                1 => '🏠',
                2 => '🍽️',
                3 => '🔒',
                4 => '📍',
                5 => '🙏',
                6 => '👥'
            ];
            
            // Boucle pour les 6 services
            for ($i = 1; $i <= 6; $i++) :
                $title = get_option("service_{$i}_title", 
                    $i == 1 ? 'Chambres équipées' : 
                    ($i == 2 ? 'Espaces communs' : 
                    ($i == 3 ? 'Sécurité 24h/24' : 
                    ($i == 4 ? 'Localisation idéale' : 
                    ($i == 5 ? 'Accompagnement personnalisé' : 'Vie communautaire')))));
                
                $text = get_option("service_{$i}_text", 
                    $i == 1 ? '<p>9 chambres confortables de 9m² à 14m², chacune avec sa douche et ses toilettes privatives. Un espace idéal pour l\'étude et le repos.</p>' : 
                    ($i == 2 ? '<p>Une grande cuisine commune entièrement équipée et une salle à manger conviviale au 2ème étage pour partager des moments ensemble.</p>' : 
                    ($i == 3 ? '<p>Un accès sécurisé par badge, une présence rassurante et un cadre calme pour étudier en toute sérénité.</p>' : 
                    ($i == 4 ? '<p>Situé à Tours, notre foyer est à seulement 5 minutes à pied de la station de tram Christ Roi et à 15 minutes de la gare SNCF.</p>' : 
                    ($i == 5 ? '<p>Un accompagnement spirituel et humain à la demande, dans le respect de chacun, pour soutenir les étudiantes dans leur parcours.</p>' : 
                    '<p>Des espaces de convivialité et des activités pour favoriser les échanges et créer une vraie communauté entre résidentes.</p>')))));
                
                $features_raw = get_option("service_{$i}_features", 
                    $i == 1 ? "Lit confortable\nBureau de travail\nArmoire rangement\nConnexion WiFi" : 
                    ($i == 2 ? "Cuisine équipée\nRéfrigérateur\nFour et plaques\nSalle à manger" : 
                    ($i == 3 ? "Accès par badge\nVidéosurveillance\nÉclairage automatique\nPersonnel disponible" : 
                    ($i == 4 ? "Proche des facultés\nCommerces à proximité\nArrêt de tram\nGare accessible" : 
                    ($i == 5 ? "Écoute bienveillante\nSoutien personnalisé\nAccompagnement spirituel\nEntraide communautaire" : 
                    "Salle commune\nActivités partagées\nÉvénements\nEntraide")))));
                
                // Nettoyer les retours à la ligne
                $features_raw = str_replace(['\n', '\r\n', '\r'], "\n", $features_raw);
                $features = array_filter(array_map('trim', explode("\n", $features_raw)));
            ?>
            
            <div class="service-card-large">
                <div class="service-icon-large"><?php echo $service_icons[$i]; ?></div>
                <div class="service-content">
                    <h2 class="service-title"><?php echo esc_html($title); ?></h2>
                    
                    <div class="service-description">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                    
                    <?php if (!empty($features)) : ?>
                    <ul class="service-features">
                        <?php foreach ($features as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php endfor; ?>
            
        </div>
        
        <!-- ===== BOUTON DE CONTACT ===== -->
        <?php
        $contact_text = get_option('services_contact_text', 'Prête à rejoindre notre foyer ?');
        $contact_button_text = get_option('services_contact_button_text', 'Demander une chambre');
        $contact_button_link = get_option('services_contact_button_link', home_url('/demander-une-chambre'));
        
        if (!empty($contact_text) && !empty($contact_button_text)) :
        ?>
        <div class="contact-prompt">
            <p><?php echo esc_html($contact_text); ?></p>
            <a href="<?php echo esc_url($contact_button_link); ?>" class="btn-submit">
                <?php echo esc_html($contact_button_text); ?>
            </a>
        </div>
        <?php endif; ?>
        
    </div>
</main>

<script>
(function() {
    // Forcer le scroll normal sur la page services
    if (document.body.classList.contains('page-template-page-services')) {
        document.documentElement.style.overflow = 'auto';
        document.body.style.overflow = 'auto';
        document.body.style.height = 'auto';
        document.documentElement.style.height = 'auto';
        
        // Supprimer les overflow sur tous les éléments
        var elements = document.querySelectorAll('.services-page, .services-grid, .service-card-large, .service-content, .service-description, .service-features');
        elements.forEach(function(el) {
            el.style.overflow = 'visible';
            el.style.maxHeight = 'none';
            el.style.height = 'auto';
        });
        
        // Vérifier s'il y a un élément parent avec overflow
        var parent = document.querySelector('.services-page');
        while (parent && parent !== document.body) {
            var overflow = window.getComputedStyle(parent).overflowY;
            if (overflow === 'auto' || overflow === 'scroll') {
                parent.style.overflow = 'visible';
            }
            parent = parent.parentElement;
        }
    }
})();
</script>


<?php get_footer(); ?>