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
    <link rel="stylesheet" href="/assets/style.css" />
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Créer un compte - Étape 2/2</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 100%;"></div>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('register.step2.submit') ?>" class="auth-form">
                <?= csrf_field() ?>

                <div class="health-info-card">
                    <h3>Vos informations de santé</h3>
                    <p class="info-text">Ces données permettront de calculer votre IMC et vous suggérer le programme idéal.</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="taille_cm" class="form-label">Taille (cm) *</label>
                        <input type="number" id="taille_cm" name="taille_cm" class="form-input" 
                               step="0.1" min="50" max="250" value="<?= old('taille_cm') ?>" required
                               placeholder="ex: 170">
                        <?php if (session()->has('errors.taille_cm')): ?>
                            <span class="form-error"><?= session('errors.taille_cm') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="poids_kg" class="form-label">Poids (kg) *</label>
                        <input type="number" id="poids_kg" name="poids_kg" class="form-input" 
                               step="0.1" min="20" max="300" value="<?= old('poids_kg') ?>" required
                               placeholder="ex: 70">
                        <?php if (session()->has('errors.poids_kg')): ?>
                            <span class="form-error"><?= session('errors.poids_kg') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="objectif_id" class="form-label">Votre objectif *</label>
                    <select id="objectif_id" name="objectif_id" class="form-input" required>
                        <option value="">-- Sélectionner un objectif --</option>
                        <?php foreach ($objectifs as $obj): ?>
                            <option value="<?= $obj['id'] ?>" <?= old('objectif_id') == $obj['id'] ? 'selected' : '' ?>>
                                <?= $obj['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session()->has('errors.objectif_id')): ?>
                        <span class="form-error"><?= session('errors.objectif_id') ?></span>
                    <?php endif; ?>
                </div>

                <div class="imc-preview">
                    <p class="imc-label">Votre IMC estimé:</p>
                    <p class="imc-value" id="imc-display">-- kg/m²</p>
                    <p class="imc-category" id="imc-category"></p>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Finaliser l'inscription</button>
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

    <style>
        .auth-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
        }

        .auth-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 40px;
        }

        .auth-title {
            text-align: center;
            color: var(--green);
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--text-secondary);
            margin: 0 0 20px 0;
            font-size: 14px;
        }

        .progress-bar {
            height: 6px;
            background: var(--border);
            border-radius: 3px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--green);
            transition: width 0.3s ease;
        }

        .health-info-card {
            background: var(--indigo-light);
            padding: 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 25px;
            border-left: 4px solid var(--indigo);
        }

        .health-info-card h3 {
            margin: 0 0 8px 0;
            color: var(--text-primary);
            font-size: 15px;
            font-weight: 700;
        }

        .info-text {
            margin: 0;
            color: var(--text-secondary);
            font-size: 13px;
            line-height: 1.5;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-family: inherit;
            transition: border-color var(--transition);
            background: #fff;
            color: var(--text-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--green);
        }

        .form-error {
            color: #dc2626;
            font-size: 12px;
        }

        .imc-preview {
            background: var(--bg);
            padding: 20px;
            border-radius: var(--radius-md);
            text-align: center;
            border: 1px solid var(--border);
        }

        .imc-label {
            margin: 0 0 8px 0;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
        }

        .imc-value {
            margin: 0 0 4px 0;
            color: var(--green);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .imc-category {
            margin: 0;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-primary {
            background: var(--green);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: #16a34a;
        }

        .btn-full {
            width: 100%;
        }

        .auth-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .auth-footer p {
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }

        .auth-footer a {
            color: var(--green);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: var(--red-light, #fee2e2);
            color: var(--red, #ef4444);
            border: 1px solid #fecaca;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
