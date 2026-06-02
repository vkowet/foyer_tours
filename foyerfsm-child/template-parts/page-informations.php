<?php

/**
 * Template Name: Informations
 * Description: Page d'informations pratiques
 */

get_header();
?>

<main class="informations-page">

    <div class="container">

        <!-- ===== EN-TÊTE DE PAGE ===== -->
        <?php
        $page_title = get_option('informations_page_title');
        $page_subtitle = get_option('informations_page_subtitle');
        ?>
        <?php if ($page_title || $page_subtitle) : ?>
            <div class="page-header">
                <?php if ($page_title) : ?>
                    <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
                <?php endif; ?>
                <?php if ($page_subtitle) : ?>
                    <p class="page-subtitle"><?php echo esc_html($page_subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- ===== INTRODUCTION ===== -->
        <?php $intro_text = get_option('informations_intro_text'); ?>
        <?php if ($intro_text) : ?>
            <div class="intro-card">
                <div class="intro-icon">ℹ️</div>
                <div class="intro-text">
                    <?php echo wp_kses_post($intro_text); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== SECTION RÈGLEMENT MENSUEL ===== -->
        <?php
        $reglement_title = get_option('informations_reglement_title');
        $reglement_text = get_option('informations_reglement_text');
        ?>
        <?php if ($reglement_title || $reglement_text) : ?>
            <div class="info-card">
                <div class="info-icon">💰</div>
                <div class="info-content">
                    <?php if ($reglement_title) : ?>
                        <h2 class="info-title"><?php echo esc_html($reglement_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($reglement_text) : ?>
                        <?php echo wp_kses_post($reglement_text); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== SECTION CAUTION ===== -->
        <?php
        $caution_title = get_option('informations_caution_title');
        $caution_text = get_option('informations_caution_text');
        ?>
        <?php if ($caution_title || $caution_text) : ?>
            <div class="info-card">
                <div class="info-icon">🔒</div>
                <div class="info-content">
                    <?php if ($caution_title) : ?>
                        <h2 class="info-title"><?php echo esc_html($caution_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($caution_text) : ?>
                        <?php echo wp_kses_post($caution_text); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== SECTION REPAS ===== -->
        <?php $repas_text = get_option('informations_repas_text'); ?>
        <?php if ($repas_text) : ?>
            <div class="info-card highlight">
                <div class="info-icon">🍽️</div>
                <div class="info-content">
                    <?php echo wp_kses_post($repas_text); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== SECTION BADGE ===== -->
        <?php
        $badge_title = get_option('informations_badge_title');
        $badge_text = get_option('informations_badge_text');
        ?>
        <?php if ($badge_title || $badge_text) : ?>
            <div class="info-card">
                <div class="info-icon">🔑</div>
                <div class="info-content">
                    <?php if ($badge_title) : ?>
                        <h2 class="info-title"><?php echo esc_html($badge_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($badge_text) : ?>
                        <?php echo wp_kses_post($badge_text); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== SECTION RÈGLEMENT INTÉRIEUR ===== -->
        <?php
        $engagements_title = get_option('informations_engagements_title');
        $engagements_list = get_option('informations_engagements_list');
        $engagements_complement = get_option('informations_engagements_complement');
        ?>
        <?php if ($engagements_title || $engagements_list || $engagements_complement) : ?>
            <div class="info-card">
                <div class="info-icon">📜</div>
                <div class="info-content">
                    <?php if ($engagements_title) : ?>
                        <h2 class="info-title"><?php echo esc_html($engagements_title); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($engagements_list)) : ?>
                        <?php
                        // Nettoyer le contenu : enlever les balises <p> existantes
                        $clean_list = strip_tags($engagements_list, '<br>');
                        // Remplacer les <br> par des retours à la ligne
                        $clean_list = str_replace(array('<br>', '<br />'), "\n", $clean_list);
                        // Séparer par lignes
                        $engagements = explode("\n", $clean_list);
                        ?>
                        <?php if (count($engagements) > 0) : ?>
                            <ul class="engagements-list">
                                <?php foreach ($engagements as $engagement) : ?>
                                    <?php $engagement = trim($engagement); ?>
                                    <?php if (!empty($engagement)) : ?>
                                        <li><?php echo esc_html($engagement); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($engagements_complement) : ?>
                        <div class="engagements-complement">
                            <?php echo wp_kses_post($engagements_complement); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ===== NOTE DE BAS DE PAGE ===== -->
        <?php $contract_ref = get_option('informations_contract_ref'); ?>
        <?php if ($contract_ref) : ?>
            <div class="info-footer">
                <p class="contract-reference">
                    <?php echo esc_html($contract_ref); ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- ===== BOUTON DE CONTACT ===== -->
        <?php
        $contact_text = get_option('informations_contact_text');
        $button_text = get_option('informations_contact_button_text');
        $button_link = get_option('informations_contact_button_link');

        // CORRECTION : Vérifier que le lien est valide
        if ($button_link && $button_link > 0 && get_post_status($button_link)) {
            $button_url = get_permalink($button_link);
        } else {
            $button_url = home_url('/demander-une-chambre');
        }
        ?>
        <?php if (($contact_text || $button_text) && $button_url) : ?>
            <div class="contact-prompt">
                <?php if ($contact_text) : ?>
                    <p><?php echo esc_html($contact_text); ?></p>
                <?php endif; ?>
                <?php if ($button_text) : ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="btn-submit">
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>