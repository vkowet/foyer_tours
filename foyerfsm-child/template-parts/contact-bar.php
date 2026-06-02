<?php
/**
 * BARRE D'INFORMATIONS - AVEC OPTIONS
 */
$activer = get_option('contact_bar_activer', 1);
if (!$activer) return;

$adresse   = get_option('contact_adresse', '29 Rue place Coty, Tours 37100');
$telephone = get_option('contact_telephone', '01 23 45 67 89');
$email     = get_option('contact_email', 'contact@foyer.valkoprod.com');
?>

<div class="contact-info-bar">
    <div class="contact-info-container">
        
        <div class="contact-item">
            <span class="contact-icon">📍</span>
            <span><?php echo esc_html($adresse); ?></span>
        </div>
        
        <div class="contact-item">
            <span class="contact-icon">📞</span>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $telephone)); ?>">
                <?php echo esc_html($telephone); ?>
            </a>
        </div>
        
        <div class="contact-item">
            <span class="contact-icon">✉️</span>
            <a href="mailto:<?php echo esc_attr($email); ?>">
                <?php echo esc_html($email); ?>
            </a>
        </div>
        
    </div>
</div>