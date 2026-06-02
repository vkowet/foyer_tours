<?php
// SECTION NOS VALEURS - 4 BLOCS MAX
?>
<section class="values-section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html(get_option('values_section_title', 'Nos Valeurs')); ?></h2>
        <div class="values-grid">
            <?php
            // Récupérer et afficher les valeurs actives
            for ($i = 1; $i <= 4; $i++) {
                $active = get_option("value_{$i}_active", $i <= 3 ? 1 : 0);
                if (!$active) continue;
                
                $title = get_option("value_{$i}_title", "Valeur $i");
                $text = get_option("value_{$i}_text", "Description de la valeur $i.");
                $image_id = get_option("value_{$i}_image", 0);
                
                // Gestion de l'image
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '';
            ?>
            <div class="value-card">
                <?php if ($image_url) : ?>
                <div class="value-image-wrapper">
                    <div class="value-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
                </div>
                <?php endif; ?>
                <div class="value-content">
                    <h3 class="value-title"><?php echo esc_html($title); ?></h3>
                    <!-- ✅ Correction ici : wp_kses_post au lieu de esc_html -->
                    <div class="value-text"><?php echo wp_kses_post($text); ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>