<?php
/**
 * Page 1 d'inscription - Informations personnelles
 * Collecte: nom, prénom, email, mot de passe, genre
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription - Étape 1 - HealthyLife</title>
    <link rel="stylesheet" href="/assets/style.css" />
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Créer un compte - Étape 1/2</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 50%;"></div>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('register.step1.submit') ?>" class="auth-form">
                <?= csrf_field() ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" id="nom" name="nom" class="form-input" 
                               value="<?= old('nom') ?>" required>
                        <?php if (session()->has('errors.nom')): ?>
                            <span class="form-error"><?= session('errors.nom') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" class="form-input" 
                               value="<?= old('prenom') ?>" required>
                        <?php if (session()->has('errors.prenom')): ?>
                            <span class="form-error"><?= session('errors.prenom') ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="<?= old('email') ?>" required>
                    <?php if (session()->has('errors.email')): ?>
                        <span class="form-error"><?= session('errors.email') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="genre_id" class="form-label">Genre *</label>
                    <select id="genre_id" name="genre_id" class="form-input" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['id'] ?>" <?= old('genre_id') == $genre['id'] ? 'selected' : '' ?>>
                                <?= $genre['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session()->has('errors.genre_id')): ?>
                        <span class="form-error"><?= session('errors.genre_id') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe (min 8 caractères) *</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    <?php if (session()->has('errors.password')): ?>
                        <span class="form-error"><?= session('errors.password') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmer mot de passe *</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-input" required>
                    <?php if (session()->has('errors.password_confirm')): ?>
                        <span class="form-error"><?= session('errors.password_confirm') ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Continuer vers étape 2</button>
            </form>

            <div class="auth-footer">
                <p>Vous avez déjà un compte? <a href="<?= url_to('login') ?>">Se connecter</a></p>
            </div>
        </div>
    </div>

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
