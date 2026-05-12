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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
    <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/activello/activello.css" />
    <link rel="stylesheet" href="/assets/activello/app.css" />
</head>
<body class="auth-page" style="--auth-bg: url('/people/enjoyair.jpg');">
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width: 420px; width: 100%;">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Connexion à votre compte</p>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success">
                    <?= session('message') ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('login') ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= old('email') ?>" required>
                    <?php if (session()->has('errors.email')): ?>
                        <span class="text-danger small"><?= session('errors.email') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <?php if (session()->has('errors.password')): ?>
                        <span class="text-danger small"><?= session('errors.password') ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>

            <div class="auth-footer">
                <p>Pas encore de compte? <a href="<?= url_to('register.step1') ?>">S'inscrire</a></p>
            </div>
        </div>
    </div>
</body>
</html>
