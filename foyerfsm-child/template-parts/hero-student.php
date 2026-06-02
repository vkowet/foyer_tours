<?php

/**
 * HERO ÉTUDIANT - Version slider
 * Garde le fonctionnement en slider avec le contenu optimisé
 */
?>

<div class="hero-slider" data-speed="<?php echo get_option('hero_student_slider_speed', 5000); ?>">

    <?php for ($i = 1; $i <= 3; $i++) :
        $image_id = get_option("hero_student_image_$i");
        $surtitre = get_option("hero_student_surtitre_$i", 'Foyer étudiant à Tours');
        $titre = get_option("hero_student_titre_$i", 'Chambres étudiantes meublées dans un cadre calme et sécurisé');
        $texte = get_option("hero_student_texte_$i", 'Pour étudiantes uniquement. 9 chambres avec salle d\'eau privative, à proximité du tramway et des commodités.');
        $cta_primaire_texte = get_option("hero_student_cta_primaire_texte_$i", 'Voir les chambres');
        $cta_primaire_lien = get_option("hero_student_cta_primaire_lien_$i", '#');
        $cta_secondaire_texte = get_option("hero_student_cta_secondaire_texte_$i", 'Demander une chambre');
        $cta_secondaire_lien = get_option("hero_student_cta_secondaire_lien_$i", '#');
        $reassurance = get_option("hero_student_reassurance_$i", 'Visites et demandes en ligne selon les disponibilités');

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

        // Convertir les liens en URL si ce sont des IDs de page
        if (is_numeric($cta_primaire_lien) && $cta_primaire_lien > 0) {
            $cta_primaire_url = get_permalink($cta_primaire_lien);
        } else {
            $cta_primaire_url = $cta_primaire_lien;
        }

        if (is_numeric($cta_secondaire_lien) && $cta_secondaire_lien > 0) {
            $cta_secondaire_url = get_permalink($cta_secondaire_lien);
        } else {
            $cta_secondaire_url = $cta_secondaire_lien;
        }
    ?>

        <div class="slide">
            <div class="slide-image <?php echo $ratio_class; ?>" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                <div class="slide-overlay"></div>
                <div class="slide-content hero-student-content">

                    <?php if ($surtitre) : ?>
                        <span class="hero-surtitre"><?php echo esc_html($surtitre); ?></span>
                    <?php endif; ?>

                    <h1 class="slide-title"><?php echo esc_html($titre); ?></h1>

                    <?php if ($texte) : ?>
                        <p class="slide-text hero-texte"><?php echo esc_html($texte); ?></p>
                    <?php endif; ?>

                    <div class="hero-buttons">
                        <?php if ($cta_primaire_texte && $cta_primaire_url) : ?>
                            <a href="<?php echo esc_url($cta_primaire_url); ?>" class="btn-hero btn-hero-primary">
                                <?php echo esc_html($cta_primaire_texte); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($cta_secondaire_texte && $cta_secondaire_url) : ?>
                            <a href="<?php echo esc_url($cta_secondaire_url); ?>" class="btn-hero btn-hero-secondary">
                                <?php echo esc_html($cta_secondaire_texte); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($reassurance) : ?>
                        <p class="hero-reassurance"><?php echo esc_html($reassurance); ?></p>
                    <?php endif; ?>

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