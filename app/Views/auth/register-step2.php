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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }

        .auth-title {
            text-align: center;
            color: #667eea;
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 700;
        }

        .auth-subtitle {
            text-align: center;
            color: #666;
            margin: 0 0 20px 0;
            font-size: 14px;
        }

        .progress-bar {
            height: 4px;
            background: #eee;
            border-radius: 2px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }

        .health-info-card {
            background: #f8f9ff;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .health-info-card h3 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 15px;
        }

        .info-text {
            margin: 0;
            color: #666;
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
            color: #333;
            font-size: 14px;
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-error {
            color: #e74c3c;
            font-size: 12px;
        }

        .imc-preview {
            background: linear-gradient(135deg, #f0f4ff 0%, #f8f0ff 100%);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e6ff;
        }

        .imc-label {
            margin: 0 0 8px 0;
            color: #666;
            font-size: 13px;
            font-weight: 500;
        }

        .imc-value {
            margin: 0 0 4px 0;
            color: #667eea;
            font-size: 28px;
            font-weight: 700;
        }

        .imc-category {
            margin: 0;
            color: #666;
            font-size: 13px;
        }

        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-full {
            width: 100%;
        }

        .auth-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .auth-footer p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #ffe0e0;
            color: #c70039;
            border: 1px solid #ffb3ba;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
