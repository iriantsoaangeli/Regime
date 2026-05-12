<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mon Espace - HealthyLife</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
    <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/activello/activello.css" />
    <link rel="stylesheet" href="/assets/activello/app.css" />
    <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>
    <?php $activePage = 'dashboard'; ?>
    <?= $this->include('templates/header') ?>

    <main id="main" class="site-main">
        <div class="container">
                <section class="hero-image">
                    <img src="/people/feelinggoodabturself.jpg" alt="Votre espace personnel" />
                    <div class="hero-overlay">
                        <h2>Votre espace bien-être</h2>
                        <p>Suivez votre profil santé et gardez le contrôle sur vos objectifs.</p>
                    </div>
                </section>
            <div class="dashboard-header">
                <div>
                    <h1 class="entry-title">Bonjour, <?= esc($user['prenom']) ?> <?= esc($user['nom']) ?></h1>
                    <p class="lead">Gérez votre profil santé, votre portefeuille et vos programmes.</p>
                </div>
                <div class="dashboard-actions">
                    <?php if ($isGold): ?>
                        <span class="badge-gold">Membre Gold ⭐️</span>
                    <?php else: ?>
                        <a href="/mon-espace/devenir-gold" class="btn btn-warning">Devenir Gold (-15%)</a>
                    <?php endif; ?>
                    <a href="/" class="btn btn-default">Retour site</a>
                </div>
            </div>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">💰 Mon Portefeuille</h2>
                        </div>
                        <div class="panel-body">
                            <div style="font-size: 2rem; font-weight: bold; margin-bottom: 10px;">
                                <?= number_format($solde, 0, ',', ' ') ?> Ar
                            </div>
                            <form action="/portefeuille/recharger" method="post" class="form-inline">
                                <div class="form-group" style="margin-right: 10px;">
                                    <input type="text" name="code" class="form-control" placeholder="Entrez un code de recharge" required>
                                </div>
                                <button type="submit" class="btn btn-warning">Recharger</button>
                            </form>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Mes paramètres de santé</h2>
                        </div>
                        <div class="panel-body">
                            <form action="/mon-profil/update" method="post">
                                <div class="form-group">
                                    <label>Ma taille (cm)</label>
                                    <input type="number" name="taille_cm" class="form-control" value="<?= $profil ? esc($profil['taille_cm']) : '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Mon poids actuel (kg)</label>
                                    <input type="number" step="0.1" name="poids_kg" class="form-control" value="<?= $profil ? esc($profil['poids_kg']) : '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Mon Objectif</label>
                                    <select name="objectif_id" class="form-control" required>
                                        <option value="">-- Choisir un objectif --</option>
                                        <?php foreach ($objectifs as $obj): ?>
                                            <option value="<?= $obj['id'] ?>" <?= ($profil && $profil['objectif_id'] == $obj['id']) ? 'selected' : '' ?>>
                                                <?= esc($obj['libelle']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Mettre à jour & Recalculer l'IMC</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <?php if ($profil): ?>
                        <div class="panel panel-default" style="text-align: center;">
                            <div class="panel-heading">
                                <h2 class="panel-title">Indice de Masse Corporelle (IMC)</h2>
                            </div>
                            <div class="panel-body">
                                <div style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">
                                    <?= esc($profil['imc']) ?>
                                </div>
                                <?php if (isset($imc_category)): ?>
                                    <span class="label label-<?= $imc_category['color'] == 'green' ? 'success' : ($imc_category['color'] == 'orange' ? 'warning' : 'danger') ?>">
                                        <?= esc($imc_category['label']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (isset($suggestion) && !empty($suggestion)): ?>
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
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2 class="panel-title">Programme Suggéré 🎯</h2>
                                </div>
                                <div class="panel-body">
                                    <p class="text-muted">Basé sur votre objectif, nous vous recommandons ce combo idéal.</p>

                                    <div class="well">
                                        <strong>🍽️ Régime : <?= esc($suggestion['regime']['nom']) ?></strong>
                                        <p class="text-muted" style="margin-top: 8px;">
                                            <?= esc($suggestion['regime']['description']) ?>
                                        </p>
                                        <p class="text-muted">
                                            Durée: <?= $suggestion['tarif']['duree_jours'] ?> jours • Variation prévue: <?= $suggestion['tarif']['variation_poids_kg'] ?> kg
                                        </p>
                                        <div><strong>Prix :</strong> <?= number_format($prixRegime, 0, ',', ' ') ?> Ar</div>
                                    </div>

                                    <?php if (isset($suggestion['activite'])): ?>
                                        <div class="well">
                                            <strong>🏃 Sport : <?= esc($suggestion['activite']['nom']) ?></strong>
                                            <p class="text-muted" style="margin-top: 8px;">
                                                <?= esc($suggestion['activite']['description']) ?>
                                            </p>
                                            <div><strong>Prix :</strong> <?= number_format($prixActivite, 0, ',', ' ') ?> Ar</div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="text-center">
                                        <h4>Total à payer : <?= number_format($totalPrice, 0, ',', ' ') ?> Ar</h4>
                                        <form action="/commande/acheter-programme" method="post">
                                            <input type="hidden" name="regime_id" value="<?= $suggestion['regime']['id'] ?>">
                                            <input type="hidden" name="tarif_id" value="<?= $suggestion['tarif']['id'] ?>">
                                            <?php if (isset($suggestion['activite'])): ?>
                                                <input type="hidden" name="activite_id" value="<?= $suggestion['activite']['id'] ?>">
                                            <?php endif; ?>
                                            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                                            <button type="submit" class="btn btn-success btn-lg">Participer au programme </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?= $this->include('templates/footer') ?>
</body>
</html>
