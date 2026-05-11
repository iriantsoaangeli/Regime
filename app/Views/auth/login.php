<?php
/**
 * Page de connexion utilisateur (Front Office)
 * Permet aux utilisateurs de se connecter avec email + mot de passe
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - HealthyLife</title>
    <link rel="stylesheet" href="/assets/style.css" />
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Connexion à votre compte</p>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success">
                    <?= session('message') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('login') ?>" class="auth-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="<?= old('email') ?>" required>
                    <?php if (session()->has('errors.email')): ?>
                        <span class="form-error"><?= session('errors.email') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    <?php if (session()->has('errors.password')): ?>
                        <span class="form-error"><?= session('errors.password') ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
            </form>

            <div class="auth-footer">
                <p>Pas encore de compte? <a href="<?= url_to('register.step1') ?>">S'inscrire</a></p>
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
            max-width: 400px;
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
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--text-secondary);
            margin: 0 0 30px 0;
            font-size: 14px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
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
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: var(--red-light, #fee2e2);
            color: var(--red, #ef4444);
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: var(--green-light);
            color: var(--green);
            border: 1px solid #bbf7d0;
        }
    </style>
</body>
</html>
