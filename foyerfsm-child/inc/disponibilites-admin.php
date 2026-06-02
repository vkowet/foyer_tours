<?php
/**
 * Gestion des disponibilités des chambres
 * Menu indépendant dans l'admin WordPress
 */

// Ajouter le menu dans l'admin
add_action('admin_menu', 'foyerfsm_disponibilites_menu');
function foyerfsm_disponibilites_menu() {
    add_menu_page(
        'Gestion des disponibilités',  // Titre de la page
        '🛏️ Disponibilités',           // Titre du menu
        'manage_options',              // Capacité requise
        'foyerfsm-disponibilites',     // Slug
        'foyerfsm_disponibilites_page', // Fonction d'affichage
        'dashicons-building',          // Icône
        26                             // Position (juste après Tableau de bord)
    );
}

// Enregistrer les options
add_action('admin_init', 'foyerfsm_register_disponibilites_options');
function foyerfsm_register_disponibilites_options() {
    // Définition des chambres
    $chambres_keys = array(
        'chambre_9m2',
        'chambre_11m2',
        'chambre_12m2',
        'chambre_14m2',
        'chambre_16m2',
        'chambre_17m2'
    );
    
    foreach ($chambres_keys as $key) {
        register_setting('foyerfsm_disponibilites_options', "disponible_{$key}");
    }
}

// Page d'affichage
function foyerfsm_disponibilites_page() {
    // Sauvegarde des modifications
    if (isset($_POST['submit_disponibilites']) && check_admin_referer('foyerfsm_disponibilites_action')) {
        foreach ($_POST['disponible'] as $key => $value) {
            update_option("disponible_{$key}", intval($value));
        }
        echo '<div class="notice notice-success is-dismissible"><p>✅ Les disponibilités ont été mises à jour.</p></div>';
    }
    
    // Configuration des chambres (sans prix)
    $chambres_config = array(
        'chambre_9m2' => array(
            'nom' => 'Chambre 9m²',
            'surface' => '9',
            'quantite_totale' => 1
        ),
        'chambre_11m2' => array(
            'nom' => 'Chambre 11m²',
            'surface' => '11',
            'quantite_totale' => 3
        ),
        'chambre_12m2' => array(
            'nom' => 'Chambre 12m²',
            'surface' => '12',
            'quantite_totale' => 2
        ),
        'chambre_14m2' => array(
            'nom' => 'Chambre 14m²',
            'surface' => '14',
            'quantite_totale' => 1
        ),
        'chambre_16m2' => array(
            'nom' => 'Chambre 16m²',
            'surface' => '16',
            'quantite_totale' => 1
        ),
        'chambre_17m2' => array(
            'nom' => 'Chambre 17m²',
            'surface' => '17',
            'quantite_totale' => 1
        )
    );
    
    // Calcul du total
    $total_chambres = 0;
    $total_disponibles = 0;
    foreach ($chambres_config as $key => $config) {
        $total_chambres += $config['quantite_totale'];
        $disponible = get_option("disponible_{$key}", $config['quantite_totale']);
        $total_disponibles += $disponible;
    }
    $taux_occupation = $total_chambres > 0 ? round((1 - $total_disponibles / $total_chambres) * 100) : 0;
    ?>
    <div class="wrap">
        <h1>🛏️ Gestion des disponibilités des chambres</h1>
        
        <!-- Cartes de statistiques -->
        <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 15px; flex: 1; min-width: 150px;">
                <div style="font-size: 2rem; font-weight: bold;"><?php echo $total_chambres; ?></div>
                <div>Total chambres</div>
            </div>
            <div style="background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); color: white; padding: 20px; border-radius: 15px; flex: 1; min-width: 150px;">
                <div style="font-size: 2rem; font-weight: bold;"><?php echo $total_disponibles; ?></div>
                <div>Chambres disponibles</div>
            </div>
            <div style="background: linear-gradient(135deg, #ff9800 0%, #fb8c00 100%); color: white; padding: 20px; border-radius: 15px; flex: 1; min-width: 150px;">
                <div style="font-size: 2rem; font-weight: bold;"><?php echo $taux_occupation; ?>%</div>
                <div>Taux d'occupation</div>
            </div>
        </div>
        
        <!-- Formulaire de gestion -->
        <form method="post" action="" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <?php wp_nonce_field('foyerfsm_disponibilites_action'); ?>
            
            <table class="wp-list-table widefat fixed striped" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th width="30%">Type de chambre</th>
                        <th width="20%">Surface</th>
                        <th width="20%">Total</th>
                        <th width="30%">Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chambres_config as $key => $config) : 
                        $disponible = get_option("disponible_{$key}", $config['quantite_totale']);
                        $reservees = $config['quantite_totale'] - $disponible;
                        $pourcentage = $config['quantite_totale'] > 0 ? round($disponible / $config['quantite_totale'] * 100) : 0;
                    ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html($config['nom']); ?></strong>
                                <?php if ($reservees > 0) : ?>
                                    <span style="display: inline-block; margin-left: 10px; background: #ff9800; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.7rem;">
                                        <?php echo $reservees; ?> réservée(s)
                                    </span>
                                <?php endif; ?>
                             </td>
                            <td><?php echo esc_html($config['surface']); ?> m²</td>
                            <td><?php echo $config['quantite_totale']; ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                    <input type="range" 
                                           name="disponible[<?php echo $key; ?>]" 
                                           value="<?php echo $disponible; ?>" 
                                           min="0" 
                                           max="<?php echo $config['quantite_totale']; ?>" 
                                           step="1"
                                           style="flex: 1; min-width: 150px;"
                                           oninput="this.nextElementSibling.value = this.value">
                                    <input type="number" 
                                           value="<?php echo $disponible; ?>" 
                                           min="0" 
                                           max="<?php echo $config['quantite_totale']; ?>" 
                                           step="1"
                                           style="width: 70px; text-align: center;"
                                           oninput="this.previousElementSibling.value = this.value"
                                           class="small-text">
                                    <span style="min-width: 40px;">/ <?php echo $config['quantite_totale']; ?></span>
                                </div>
                                <div style="margin-top: 8px;">
                                    <div style="background: #e0e0e0; border-radius: 10px; height: 6px; width: 100%;">
                                        <div style="background: <?php echo $pourcentage > 0 ? '#4caf50' : '#f44336'; ?>; width: <?php echo $pourcentage; ?>%; height: 6px; border-radius: 10px;"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f5f5f5;">
                        <th><strong>Total</strong></th>
                        <th>-</th>
                        <th><strong><?php echo $total_chambres; ?></strong></th>
                        <th><strong><?php echo $total_disponibles; ?> disponible(s)</strong></th>
                    </tr>
                </tfoot>
            </table>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="submit" name="submit_disponibilites" class="button button-primary" style="background: #b75b7d; border-color: #b75b7d;">
                    💾 Enregistrer les disponibilités
                </button>
            </div>
        </form>
        
        <!-- Message d'aide -->
        <div style="margin-top: 30px; padding: 20px; background: #f0f6fc; border-left: 4px solid #b75b7d; border-radius: 8px;">
            <h3 style="margin-top: 0; color: #b75b7d;">📌 Comment utiliser cet outil ?</h3>
            <p>Pour chaque type de chambre, ajustez le curseur ou le nombre pour indiquer combien de chambres sont <strong>actuellement disponibles</strong>.</p>
            <ul>
                <li>✅ Une chambre disponible apparaîtra dans le formulaire de demande</li>
                <li>❌ Une chambre réservée ne sera plus visible par les visiteurs</li>
                <li>📊 Les statistiques se mettent à jour automatiquement</li>
            </ul>
            <p><strong>Composition de l'inventaire :</strong></p>
            <ul>
                <li>1 chambre de 9m²</li>
                <li>3 chambres de 11m²</li>
                <li>2 chambres de 12m²</li>
                <li>1 chambre de 14m²</li>
                <li>1 chambre de 16m²</li>
                <li>1 chambre de 17m²</li>
            </ul>
            <p style="margin-top: 15px; color: #b75b7d;"><strong>💰 Les prix ne sont pas affichés sur le site. Ils seront communiqués après le premier contact.</strong></p>
        </div>
    </div>
    
    <style>
        .wp-list-table td { vertical-align: middle; }
        input[type="range"] { -webkit-appearance: none; background: #e0e0e0; height: 4px; border-radius: 5px; }
        input[type="range"]::-webkit-slider-thumb { -webkit-appearance: none; width: 16px; height: 16px; border-radius: 50%; background: #b75b7d; cursor: pointer; }
        @media (max-width: 782px) {
            .wp-list-table tr { display: block; margin-bottom: 20px; }
            .wp-list-table td { display: block; text-align: left; padding: 10px; }
            .wp-list-table th { display: none; }
        }
    </style>
    <?php
}