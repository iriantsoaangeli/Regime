<?php
/**
 * Page 2 d'inscription - Données de santé
 * Collecte: taille (cm), poids (kg)
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription - Étape 2 - HealthyLife</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
    <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/activello/activello.css" />
    <link rel="stylesheet" href="/assets/activello/app.css" />
</head>
<body class="auth-page" style="--auth-bg: url('/people/womaninhealt.jpg');">
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width: 620px; width: 100%;">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Créer un compte - Étape 2/2</p>
            <div class="progress" style="margin-bottom: 25px;">
                <div class="progress-bar progress-bar-success" style="width: 100%;"></div>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('register.step2.submit') ?>">
                <?= csrf_field() ?>

                <div class="well">
                    <h4>Vos informations de santé</h4>
                    <p class="text-muted">Ces données permettront de calculer votre IMC et vous suggérer le programme idéal.</p>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="taille_cm">Taille (cm) *</label>
                            <input type="number" id="taille_cm" name="taille_cm" class="form-control"
                                   step="0.1" min="50" max="250" value="<?= old('taille_cm') ?>" required
                                   placeholder="ex: 170">
                            <?php if (session()->has('errors.taille_cm')): ?>
                                <span class="text-danger small"><?= session('errors.taille_cm') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="poids_kg">Poids (kg) *</label>
                            <input type="number" id="poids_kg" name="poids_kg" class="form-control"
                                   step="0.1" min="20" max="300" value="<?= old('poids_kg') ?>" required
                                   placeholder="ex: 70">
                            <?php if (session()->has('errors.poids_kg')): ?>
                                <span class="text-danger small"><?= session('errors.poids_kg') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="objectif_id">Votre objectif *</label>
                    <select id="objectif_id" name="objectif_id" class="form-control" required>
                        <option value="">-- Sélectionner un objectif --</option>
                        <?php foreach ($objectifs as $obj): ?>
                            <option value="<?= $obj['id'] ?>" <?= old('objectif_id') == $obj['id'] ? 'selected' : '' ?>>
                                <?= $obj['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session()->has('errors.objectif_id')): ?>
                        <span class="text-danger small"><?= session('errors.objectif_id') ?></span>
                    <?php endif; ?>
                </div>

                <div class="well text-center">
                    <p class="text-muted" style="margin-bottom: 5px;">Votre IMC estimé:</p>
                    <h3 id="imc-display">-- kg/m²</h3>
                    <p id="imc-category"></p>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Finaliser l'inscription</button>
            </form>

            <div class="auth-footer">
                <p>Vous avez déjà un compte? <a href="<?= url_to('login') ?>">Se connecter</a></p>
            </div>
        </div>
    </div>

    <script>
        function calculateIMC() {
            const taille = parseFloat(document.getElementById('taille_cm').value);
            const poids = parseFloat(document.getElementById('poids_kg').value);

            if (taille > 0 && poids > 0) {
                const tailleM = taille / 100;
                const imc = poids / (tailleM * tailleM);

                document.getElementById('imc-display').textContent = imc.toFixed(1) + ' kg/m²';

                let category = '';
                if (imc < 18.5) {
                    category = 'Insuffisance pondérale';
                } else if (imc < 25) {
                    category = 'Poids normal';
                } else if (imc < 30) {
                    category = 'Surpoids';
                } else {
                    category = 'Obésité';
                }
                document.getElementById('imc-category').textContent = category;
            }
        }

        document.getElementById('taille_cm').addEventListener('input', calculateIMC);
        document.getElementById('poids_kg').addEventListener('input', calculateIMC);
    </script>
</body>
</html>
