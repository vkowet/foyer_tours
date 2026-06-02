<?php

/**
 * Template Name: À propos
 * Description: Page À propos harmonisée avec le style des autres pages
 */

get_header();
?>

<main class="apropos-page">

    <div class="container">

        <!-- ===== EN-TÊTE DE PAGE ===== -->
        <div class="page-header">
            <h1 class="page-title"><?php echo esc_html(get_option('apropos_hero_title', 'À propos de nous')); ?></h1>
            <?php if (get_option('apropos_hero_subtitle')) : ?>
                <p class="page-subtitle"><?php echo esc_html(get_option('apropos_hero_subtitle')); ?></p>
            <?php endif; ?>
        </div>

        <!-- ===== MESSAGE DE LA SUPÉRIEURE ===== -->
        <div class="superior-section">
            <div class="two-columns">
                <div class="column-content">
                    <h2 class="section-title"><?php echo esc_html(get_option('apropos_superior_title', 'Lettre aux amis et aux familles')); ?></h2>
                    <div class="superior-message">
                        <?php echo wp_kses_post(get_option('apropos_superior_message', '<p>Chers amis,</p><p>Nous nous préparons à dire au revoir à l\'année 2025...</p>')); ?>
                    </div>
                    <p class="message-signature"><?php echo esc_html(get_option('apropos_superior_signature', 'Sr Reetha Paul, Supérieure Générale')); ?></p>
                </div>
                <div class="column-image">
                    <?php
                    $superior_image = get_option('apropos_superior_image');
                    if ($superior_image) :
                        echo wp_get_attachment_image($superior_image, 'large', false, ['class' => 'rounded-image']);
                    else :
                        echo '<img src="https://placehold.co/600x800/2c3e50/white?text=Sr+Reetha" class="rounded-image">';
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <!-- ===== HISTOIRE DE L'ÉTOILE DE MER ===== -->
        <div class="starfish-section">
            <h2 class="section-title"><?php echo esc_html(get_option('apropos_starfish_title', 'L\'histoire de l\'étoile de mer')); ?></h2>
            <div class="starfish-content">
                <?php echo wp_kses_post(get_option('apropos_starfish_text', '<p>« Jim avait l\'habitude de se promener sur la plage...</p>')); ?>
            </div>
            <blockquote class="inspiring-quote">
                <?php echo wp_kses_post(get_option('apropos_starfish_quote', '« Nous ne pouvons pas faire de grandes choses, seulement de petites choses avec un grand amour. »')); ?>
                <cite><?php echo esc_html(get_option('apropos_starfish_quote_author', 'Mère Teresa')); ?></cite>
            </blockquote>
        </div>

        <!-- ===== HISTOIRE DE LA CONGRÉGATION ===== -->
        <div class="history-section">
            <h2 class="section-title"><?php echo esc_html(get_option('apropos_history_title', 'Notre Histoire')); ?></h2>
            <div class="timeline">
                <?php for ($i = 1; $i <= 5; $i++) :
                    $year = get_option("apropos_history_year_$i");
                    $title = get_option("apropos_history_title_$i");
                    $desc = get_option("apropos_history_desc_$i");
                    if ($year && $title) :
                ?>
                        <div class="timeline-item">
                            <div class="timeline-year"><?php echo esc_html($year); ?></div>
                            <div class="timeline-content">
                                <h3><?php echo esc_html($title); ?></h3>
                                <p><?php echo wp_kses_post($desc); ?></p>
                            </div>
                        </div>
                <?php endif;
                endfor; ?>
            </div>
        </div>

        <!-- ===== ÉVÉNEMENTS RÉCENTS ===== -->
        <div class="events-section">
            <h2 class="section-title"><?php echo esc_html(get_option('apropos_events_title', 'Événements récents')); ?></h2>
            <div class="events-grid">
                <?php for ($i = 1; $i <= 4; $i++) :
                    $event_title = get_option("apropos_event_{$i}_title");
                    $event_date = get_option("apropos_event_{$i}_date");
                    $event_desc = get_option("apropos_event_{$i}_desc");
                    if ($event_title && $event_date) :
                ?>
                        <div class="event-card">
                            <span class="event-date"><?php echo esc_html($event_date); ?></span>
                            <h3><?php echo esc_html($event_title); ?></h3>
                            <p><?php echo wp_kses_post($event_desc); ?></p>
                        </div>
                <?php endif;
                endfor; ?>
            </div>
        </div>

        <!-- ===== MISSIONS DANS LE MONDE ===== -->
        <div class="missions-section">
            <h2 class="section-title"><?php echo esc_html(get_option('apropos_missions_title', 'Nos missions dans le monde')); ?></h2>
            <div class="missions-grid">
                <?php
                $countries = ['france', 'inde', 'madagascar', 'tchad', 'italie'];
                foreach ($countries as $country) :
                    $name = get_option("apropos_mission_{$country}_name", ucfirst($country));
                    $flag = get_option(
                        "apropos_mission_{$country}_flag",
                        $country === 'france' ? '🇫🇷' : ($country === 'inde' ? '🇮🇳' : ($country === 'madagascar' ? '🇲🇬' : ($country === 'tchad' ? '🇹🇩' : '🇮🇹')))
                    );
                    $title = get_option("apropos_mission_{$country}_title", 'Mission');
                    $desc = get_option("apropos_mission_{$country}_desc", 'Description de la mission');
                    $image_id = get_option("apropos_mission_{$country}_image", '');
                ?>
                    <div class="mission-card">
                        <?php if ($image_id) :
                            $image_url = wp_get_attachment_image_url($image_id, 'medium');
                            $image_full_url = wp_get_attachment_image_url($image_id, 'full');
                        ?>
                            <div class="mission-image" data-full="<?php echo esc_url($image_full_url); ?>">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy">
                            </div>
                        <?php endif; ?>
                        <div class="mission-card-content">
                            <span class="country-flag"><?php echo esc_html($flag); ?></span>
                            <h4><?php echo esc_html($name); ?></h4>
                            <p class="mission-title"><?php echo esc_html($title); ?></p>
                            <p class="mission-desc"><?php echo wp_kses_post($desc); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ===== SOUTENIR LA MISSION ===== -->
        <div class="support-section">
            <div class="two-columns">
                <div class="column-content">
                    <h2 class="section-title"><?php echo esc_html(get_option('apropos_support_title', 'Soutenir notre mission')); ?></h2>
                    <div><?php echo wp_kses_post(get_option('apropos_support_text', 'La Congrégation peut délivrer des reçus fiscaux pour les dons. Les dons ouvrent droit à une réduction d’impôt sur le revenu égale à 66% de leur montant.')); ?></div>

                    <h3><?php echo esc_html(get_option('apropos_bank_title', 'Coordonnées bancaires')); ?></h3>
                    <p><strong>IBAN :</strong> <?php echo esc_html(get_option('apropos_bank_iban', 'FR76 3000 3040 9500 0500 0527 047')); ?></p>
                    <p><strong>BIC :</strong> <?php echo esc_html(get_option('apropos_bank_bic', 'SOGEFRPP')); ?></p>

                    <h3><?php echo esc_html(get_option('apropos_contact_title', 'Nous contacter')); ?></h3>
                    <p><strong>Adresse :</strong> <?php echo wp_kses_post(nl2br(get_option('apropos_contact_address', '15 rue Monin, 41000 BLOIS'))); ?></p>
                    <p><strong>Tél :</strong> <?php echo esc_html(get_option('apropos_contact_phone', '02 54 78 63 97')); ?></p>
                    <p><strong>Email :</strong> <a href="mailto:<?php echo esc_attr(get_option('apropos_contact_email', 'secretariat@congregationfsm.fr')); ?>"><?php echo esc_html(get_option('apropos_contact_email', 'secretariat@congregationfsm.fr')); ?></a></p>
                </div>
                <div class="column-image">
                    <div class="donation-card">
                        <h3><?php echo esc_html(get_option('apropos_donation_title', 'Faire un don')); ?></h3>
                        <div><?php echo wp_kses_post(get_option('apropos_donation_text', 'Les dons en espèces, par chèque ou par virement (avec votre adresse pour le reçu) à :')); ?></div>
                        <div class="address-highlight">
                            <?php echo wp_kses_post(nl2br(get_option('apropos_donation_address', "Sœurs Franciscaines Servantes de Marie\n15 rue Monin\n41000 BLOIS"))); ?>
                        </div>
                        <a href="mailto:<?php echo esc_attr(get_option('apropos_contact_email', 'secretariat@congregationfsm.fr')); ?>" class="btn-submit">
                            <?php echo esc_html(get_option('apropos_donation_button', 'Nous contacter par mail')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== BOUTON DE CONTACT ===== -->
        <div class="contact-prompt">
            <p><?php echo esc_html(get_option('apropos_contact_prompt_text', 'Vous souhaitez rejoindre notre foyer ?')); ?></p>
            <a href="<?php echo esc_url(get_option('apropos_contact_button_link', home_url('/demander-une-chambre'))); ?>" class="btn-submit">
                <?php echo esc_html(get_option('apropos_contact_button_text', 'Demander une chambre')); ?>
            </a>
        </div>

    </div>
</main>


<?php get_footer(); ?>