<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Régimes par objectif</title>
  <link rel="stylesheet" href="/assets/front.css" />
</head>
<body>
  <?= $this->include('templates/header') ?>

  <main class="main" style="padding: 40px 20px;">
    <div class="container" style="max-width: 1000px; margin: 0 auto;">
      <h1>Régimes par objectif</h1>

      <?php $regimes = $regimes ?? []; ?>
      <?php if (empty($regimes)): ?>
        <p>Aucun régime ne correspond à cet objectif pour le moment.</p>
      <?php else: ?>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
          <?php foreach ($regimes as $regime): ?>
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
              <h3 style="margin-top:0;"><?= esc($regime['nom'] ?? '') ?></h3>
              <p style="color:#64748b; font-size: 0.9rem;">
                <?= esc($regime['description'] ?? 'Description non disponible.') ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?= $this->include('templates/footer') ?>
</body>
</html>
