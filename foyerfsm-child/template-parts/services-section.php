<?php
/**
 * SECTION SERVICES - 6 BLOCS MAX
 */
?>
<section class="services-section">
    <div class="container">
        <h2 class="section-title">Nos Services</h2>
        
        <div class="services-grid">
            <?php
            $icons = ['🏠', '🔒', '📍', '🙏', '📝', '🍽️'];
            $titles = ['Chambres Équipées', 'Sécurité', 'Localisation', 'Accompagnement', 'Admission', 'Cuisine'];
            $texts = [
                '9 chambres de 9m² à 14m², chacune avec douche et toilette privatives.',
                'Accès contrôlé et personnel disponible pour votre sécurité.',
                'À 5 min du tram et 15 min de la gare SNCF.',
                'Accompagnement spirituel à la demande.',
                'Faire une demande en ligne simplement.',
                'Grande cuisine commune entièrement équipée.'
            ];
            
            for ($i = 1; $i <= 6; $i++) {
                // Activation robuste
                $active = get_theme_mod("service_{$i}_active", $i <= 5);
                $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
                
                if (!$active) continue;
                
                $icon = get_theme_mod("service_{$i}_icon", $icons[$i-1]);
                $title = get_theme_mod("service_{$i}_title", $titles[$i-1]);
                $text = get_theme_mod("service_{$i}_text", $texts[$i-1]);
            ?>
            <div class="service-card">
                <div class="service-icon"><?php echo $icon; ?></div>
                <h3><?php echo esc_html($title); ?></h3>
                <p><?php echo esc_html($text); ?></p>
            </div>
            <?php } ?>
        </div>
    </div>
</section>