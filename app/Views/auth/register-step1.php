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

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach (session('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                    </ul>
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
    
    <script src="<?= base_url('assets/register.js') ?>"></script>
</body>
</html>
