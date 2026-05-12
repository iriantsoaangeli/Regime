<?php
/**
 * Page de connexion administrateur
 * Permet aux admins de se connecter avec email + mot de passe
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion Admin - HealthyLife</title>
    <link rel="stylesheet" href="/assets/style.css" />
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">🔐 Administration</h1>
            <p class="auth-subtitle">Connexion administrateur</p>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('admin.login.submit') ?>" class="auth-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email" class="form-label">Login</label>
                    <input type="text" id="login" name="login" class="form-input" 
                           value="<?= old('login') ?>" required>
                    <?php if (session()->has('errors.login')): ?>
                        <span class="form-error"><?= session('errors.login') ?></span>
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
        </div>
    </div>

    <style>
        .auth-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #be123c 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }

        .auth-title {
            text-align: center;
            color: #1e3a8a;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 700;
        }

        .auth-subtitle {
            text-align: center;
            color: #666;
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
            color: #333;
            font-size: 14px;
        }

        .form-input {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
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
            background: linear-gradient(135deg, #1e3a8a 0%, #be123c 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
        }

        .btn-full {
            width: 100%;
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
    </style>
</body>
</html>
