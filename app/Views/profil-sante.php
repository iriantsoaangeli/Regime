<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Santé</title>
  <link rel="stylesheet" href="/assets/front.css" />
</head>
<body>
  <?= $this->include('templates/header') ?>

  <main class="main" style="padding: 40px 20px;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
      <h1>Mon profil santé</h1>

      <?php $profil = $profil ?? null; ?>
      <?php if (!$profil): ?>
        <p>Aucune mesure disponible pour le moment.</p>
      <?php else: ?>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
          <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
            <strong>Taille</strong>
            <p style="margin: 8px 0 0; font-size: 1.2rem;"><?= esc($profil['taille_cm'] ?? '-') ?> cm</p>
          </div>
          <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
            <strong>Poids</strong>
            <p style="margin: 8px 0 0; font-size: 1.2rem;"><?= esc($profil['poids_kg'] ?? '-') ?> kg</p>
          </div>
          <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
            <strong>IMC</strong>
            <p style="margin: 8px 0 0; font-size: 1.2rem;"><?= esc($profil['imc'] ?? '-') ?></p>
          </div>
          <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
            <strong>Date de mesure</strong>
            <p style="margin: 8px 0 0; font-size: 1.2rem;"><?= esc($profil['date_mesure'] ?? '-') ?></p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?= $this->include('templates/footer') ?>
</body>
</html>
