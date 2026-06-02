<?php

/**
 * SLIDER HÉRO - PLEIN ÉCRAN INTELLIGENT
 * Garde le plein écran mais ajuste le cadrage
 */
?>

<div class="hero-slider" data-speed="<?php echo get_option('slider_speed', 5000); ?>">

    <?php for ($i = 1; $i <= 3; $i++) :
        $image_id = get_option("slider_image_$i");
        $title = get_option("slider_title_$i", "Slide $i");
        $text = get_option("slider_text_$i", "");

        if (!$image_id) continue;

        // Récupérer l'image et ses métadonnées
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        $image_meta = wp_get_attachment_metadata($image_id);

        // Vérifier que les métadonnées existent
        if ($image_meta) {
            $image_width = $image_meta['width'];
            $image_height = $image_meta['height'];
            $image_ratio = $image_width / $image_height;

            // Déterminer la classe CSS en fonction du ratio
            $ratio_class = 'ratio-normal';
            if ($image_ratio > 1.8) {
                $ratio_class = 'ratio-wide'; // Très large
            } elseif ($image_ratio < 0.8) {
                $ratio_class = 'ratio-tall'; // Très haute
            }
        } else {
            $ratio_class = 'ratio-normal';
        }
    ?>

        <div class="slide">
            <div class="slide-image <?php echo $ratio_class; ?>"
                style="background-image: url('<?php echo esc_url($image_url); ?>');">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <h1 class="slide-title"><?php echo esc_html($title); ?></h1>
                    <?php if ($text) : ?>
                        <p class="slide-text"><?php echo esc_html($text); ?></p>
                    <?php endif; ?>
                    <?php
                    $button_text = get_option('slider_button_text', 'Demander une chambre');
                    $button_link = get_option('slider_button_link', '#contact-us-1');
                    ?>
                    <?php
                    // Si c'est un ID de page, on le convertit en lien
                    if (is_numeric($button_link) && $button_link > 0) {
                        $button_url = get_permalink($button_link);
                    } else {
                        $button_url = $button_link;
                    }
                    ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="btn btn-primary"><?php echo esc_html($button_text); ?></a>
                </div>
            </div>
        </div>

    <?php endfor; ?>

    <!-- NAVIGATION DU SLIDER -->
    <div class="slider-nav">
        <button class="slider-prev" aria-label="Slide précédente">❮</button>
        <button class="slider-next" aria-label="Slide suivante">❯</button>
    </div>

    <div class="slider-dots"></div>

</div>