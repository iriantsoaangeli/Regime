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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
    <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/activello/activello.css" />
    <link rel="stylesheet" href="/assets/activello/app.css" />
</head>
<body class="auth-page" style="--auth-bg: url('/people/feelinggood.jpg');">
    <div class="auth-wrapper">
        <div class="auth-card" style="max-width: 600px; width: 100%;">
            <h1 class="auth-title">HealthyLife</h1>
            <p class="auth-subtitle">Créer un compte - Étape 1/2</p>
            <div class="progress" style="margin-bottom: 25px;">
                <div class="progress-bar progress-bar-success" style="width: 50%;"></div>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach (session('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url_to('register.step1.submit') ?>">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom" class="form-control"
                                   value="<?= old('nom') ?>" required>
                            <?php if (session()->has('errors.nom')): ?>
                                <span class="text-danger small"><?= session('errors.nom') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="prenom">Prénom *</label>
                            <input type="text" id="prenom" name="prenom" class="form-control"
                                   value="<?= old('prenom') ?>" required>
                            <?php if (session()->has('errors.prenom')): ?>
                                <span class="text-danger small"><?= session('errors.prenom') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= old('email') ?>" required>
                    <?php if (session()->has('errors.email')): ?>
                        <span class="text-danger small"><?= session('errors.email') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="genre_id">Genre *</label>
                    <select id="genre_id" name="genre_id" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['id'] ?>" <?= old('genre_id') == $genre['id'] ? 'selected' : '' ?>>
                                <?= $genre['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session()->has('errors.genre_id')): ?>
                        <span class="text-danger small"><?= session('errors.genre_id') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe (min 8 caractères) *</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <?php if (session()->has('errors.password')): ?>
                        <span class="text-danger small"><?= session('errors.password') ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirmer mot de passe *</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                    <?php if (session()->has('errors.password_confirm')): ?>
                        <span class="text-danger small"><?= session('errors.password_confirm') ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Continuer vers étape 2</button>
            </form>

            <div class="auth-footer">
                <p>Vous avez déjà un compte? <a href="<?= url_to('login') ?>">Se connecter</a></p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/register.js') ?>"></script>
</body>
</html>
