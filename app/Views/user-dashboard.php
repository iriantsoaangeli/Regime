<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mon Espace - HealthyLife</title>
  <link rel="stylesheet" href="/assets/front.css" />
  <style>
      .container { max-width: 1000px; margin: 40px auto; padding: 20px; font-family: sans-serif; }
      .header-area { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;}
      .card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; background: #fff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
      .gold-badge { background: #eab308; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
      .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
      .form-group { margin-bottom: 15px; }
      .form-label { display: block; margin-bottom: 5px; font-weight: 500;}
      .form-control { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; }
      .btn { padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block;}
      .suggestion-box { background: #f0f9ff; border: 1px solid #bae6fd; padding: 20px; border-radius: 8px;}
      .wallet-box { background: #fef08a; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #facc15; }
  </style>
</head>
<body style="background: #f8fafc; margin: 0;">

    <div class="container">
        <div class="header-area">
            <h1>Bonjour, <?= esc($user['prenom']) ?> <?= esc($user['nom']) ?></h1>
            <div>
                <?php if ($isGold): ?>
                    <span class="gold-badge">Membre Gold ⭐️</span>
                <?php else: ?>
                    <a href="/mon-espace/devenir-gold" class="btn" style="background:#eab308; color:#fff; font-weight:bold;">Devenir Gold (-15%)</a>
                <?php endif; ?>
                <a href="/" class="btn" style="background:#64748b; margin-left:10px;">Retour site</a>
            </div>
        </div>

        <?php if (session()->getFlashdata('message')): ?>
            <div style="background: #dcfce7; padding: 15px; border-radius: 6px; color: #166534; margin-bottom:20px;">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #fee2e2; padding: 15px; border-radius: 6px; color: #991b1b; margin-bottom:20px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="grid">
            <!-- Colonne gauche -->
            <div>
                <!-- Portefeuille -->
                <div class="wallet-box">
                    <h3 style="margin-top:0; color:#854d0e;">💰 Mon Portefeuille</h3>
                    <div style="font-size: 2rem; font-weight: bold; color: #713f12; margin: 10px 0;">
                        <?= number_format($solde, 0, ',', ' ') ?> Ar
                    </div>
                    <form action="/portefeuille/recharger" method="post" style="display:flex; gap:10px; margin-top: 15px;">
                        <input type="text" name="code" class="form-control" placeholder="Entrez un code de recharge" required>
                        <button type="submit" class="btn" style="background: #854d0e; white-space:nowrap;">Recharger</button>
                    </form>
                </div>

                <!-- Profil Santé Form -->
                <div class="card">
                    <h2>Mes paramètres de santé</h2>
                    
                    <form action="/mon-profil/update" method="post">
                        <div class="form-group">
                            <label class="form-label">Ma taille (cm)</label>
                            <input type="number" name="taille_cm" class="form-control" value="<?= $profil ? esc($profil['taille_cm']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mon poids actuel (kg)</label>
                            <input type="number" step="0.1" name="poids_kg" class="form-control" value="<?= $profil ? esc($profil['poids_kg']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mon Objectif</label>
                            <select name="objectif_id" class="form-control" required>
                                <option value="">-- Choisir un objectif --</option>
                                <?php foreach($objectifs as $obj): ?>
                                    <option value="<?= $obj['id'] ?>" <?= ($profil && $profil['objectif_id'] == $obj['id']) ? 'selected' : '' ?>>
                                        <?= esc($obj['libelle']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn">Mettre à jour & Recalculer l'IMC</button>
                    </form>
                </div>
            </div>

            <!-- Colonne droite (IMC et Moteur) -->
            <div>
                <?php if ($profil): ?>
                <div class="card" style="text-align: center;">
                    <h3 style="margin-top:0; color:#475569;">Indice de Masse Corporelle (IMC)</h3>
                    <div style="font-size: 3rem; font-weight: bold; color: #0f172a; margin: 10px 0;">
                        <?= esc($profil['imc']) ?>
                    </div>
                    <?php if (isset($imc_category)): ?>
                        <span style="background: <?= $imc_category['color'] == 'green' ? '#dcfce7' : ($imc_category['color']=='orange' ? '#ffedd5' : '#fee2e2') ?>; 
                                     color: <?= $imc_category['color'] == 'green' ? '#166534' : ($imc_category['color']=='orange' ? '#9a3412' : '#991b1b') ?>; 
                                     padding: 5px 15px; border-radius: 20px; font-weight: bold;">
                            <?= esc($imc_category['label']) ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <?php if (isset($suggestion) && !empty($suggestion)): ?>
                <div class="suggestion-box">
                    <h3 style="margin-top:0; color: #0369a1;">Programme Suggéré 🎯</h3>
                    <p style="font-size: 0.9rem; color: #0c4a6e;">Basé sur votre objectif, nous vous recommandons ce combo idéal.</p>
                    
                    <?php 
                        $totalPrice = 0; 
                        $prixRegime = $suggestion['tarif']['prix'];
                        $prixActivite = isset($suggestion['activite']) ? $suggestion['activite']['prix'] : 0;
                        if ($isGold) {
                            $prixRegime *= 0.85;
                            $prixActivite *= 0.85;
                        }
                        $totalPrice = $prixRegime + $prixActivite;
                    ?>

                    <div style="background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                        <strong>🍽️ Régime : <?= esc($suggestion['regime']['nom']) ?></strong>
                        <p style="margin: 5px 0 0 0; font-size: 0.85rem; color:#64748b;"><?= esc($suggestion['regime']['description']) ?></p>
                        <p style="margin: 5px 0 0 0; font-size: 0.85rem;">Durée: <?= $suggestion['tarif']['duree_jours'] ?> jours • Variation prévue: <?= $suggestion['tarif']['variation_poids_kg'] ?> kg</p>
                        <div style="margin-top: 10px; font-weight: bold; color: #16a34a;">
                            Prix : <?= number_format($prixRegime, 0, ',', ' ') ?> Ar
                        </div>
                    </div>
                    
                    <?php if (isset($suggestion['activite'])): ?>
                    <div style="background: #fff; padding: 15px; border-radius: 8px;">
                        <strong>🏃 Sport : <?= esc($suggestion['activite']['nom']) ?></strong>
                        <p style="margin: 5px 0 0 0; font-size: 0.85rem; color:#64748b;"><?= esc($suggestion['activite']['description']) ?></p>
                        <div style="margin-top: 10px; font-weight: bold; color: #16a34a;">
                            Prix : <?= number_format($prixActivite, 0, ',', ' ') ?> Ar
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div style="margin-top:20px; text-align:center; padding-top:15px; border-top:1px solid #bae6fd;">
                        <h4 style="margin:0 0 10px 0; color:#0369a1;">Total à payer : <?= number_format($totalPrice, 0, ',', ' ') ?> Ar</h4>
                        <form action="/commande/acheter-programme" method="post">
                            <input type="hidden" name="regime_id" value="<?= $suggestion['regime']['id'] ?>">
                            <input type="hidden" name="tarif_id" value="<?= $suggestion['tarif']['id'] ?>">
                            <?php if (isset($suggestion['activite'])): ?>
                                <input type="hidden" name="activite_id" value="<?= $suggestion['activite']['id'] ?>">
                            <?php endif; ?>
                            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                            
                            <button type="submit" class="btn" style="width: 100%; background: #16a34a; font-size: 1.1rem; padding: 12px;">
                                Acheter le programme avec mon Portefeuille
                            </button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
