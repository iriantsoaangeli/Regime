<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Détail utilisateur</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>
<body>
  <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Détail utilisateur</h1>
      </div>
    </div>

    <?php $utilisateur = $utilisateur ?? null; ?>
    <div class="card">
      <?php if (!$utilisateur): ?>
        <p>Utilisateur introuvable.</p>
      <?php else: ?>
        <p><strong>Nom :</strong> <?= esc(($utilisateur['prenom'] ?? '') . ' ' . ($utilisateur['nom'] ?? '')) ?></p>
        <p><strong>Email :</strong> <?= esc($utilisateur['email'] ?? '-') ?></p>
        <p><strong>Téléphone :</strong> <?= esc($utilisateur['telephone'] ?? '-') ?></p>
        <p><strong>Statut :</strong> <?= !empty($utilisateur['is_active']) ? 'Actif' : 'Inactif' ?></p>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
