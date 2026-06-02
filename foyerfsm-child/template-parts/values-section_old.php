<?php
/**
 * SECTION NOS VALEURS - VERSION SIMPLE
 */
$values = array();

for ($i = 1; $i <= 4; $i++) {
    if (get_theme_mod("value_v2_{$i}_active", $i <= 3)) {
        $image_id = get_theme_mod("value_v2_{$i}_image", 0);
        $title    = get_theme_mod("value_v2_{$i}_title", "Valeur $i");
        $text     = get_theme_mod("value_v2_{$i}_text", "Description de la valeur $i.");
        
        $values[] = array(
            'image_id' => $image_id,
            'title'    => $title,
            'text'     => $text,
        );
    }
}

if (empty($values)) return;
?>

<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Nos Valeurs</h2>
            <p class="section-subtitle">Ce qui fait la singularité de notre foyer</p>
        </div>

        <div class="values-grid columns-<?php echo count($values); ?>">
            <?php foreach ($values as $value) :
                $image_url = $value['image_id'] 
                    ? wp_get_attachment_image_url($value['image_id'], 'medium_large')
                    : 'https://placehold.co/600x400/2c3e50/white?text=' . urlencode($value['title']);
            ?>
            <div class="value-card">
                <div class="value-image-wrapper">
                    <div class="value-image" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                        <div class="value-overlay"></div>
                    </div>
                </div>
                <div class="value-content">
                    <h3 class="value-title"><?php echo esc_html($value['title']); ?></h3>
                    <p class="value-text"><?php echo esc_html($value['text']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>