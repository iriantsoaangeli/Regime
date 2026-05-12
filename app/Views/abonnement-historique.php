<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historique Abonnement Gold</title>
  <link rel="stylesheet" href="/assets/front.css" />
</head>
<body>
  <?= $this->include('templates/header') ?>

  <main class="main" style="padding: 40px 20px;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
      <h1>Historique Abonnement Gold</h1>

      <?php if (session()->getFlashdata('message')): ?>
        <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
          <?= session()->getFlashdata('message') ?>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 20px;">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <?php $abonnements = $abonnements ?? []; ?>
      <?php if (empty($abonnements)): ?>
        <p>Aucun abonnement Gold trouvé pour le moment.</p>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table style="width:100%; border-collapse: collapse;">
            <thead>
              <tr style="text-align:left; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 10px;">Date début</th>
                <th style="padding: 10px;">Date fin</th>
                <th style="padding: 10px;">Montant payé</th>
                <th style="padding: 10px;">Statut</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($abonnements as $abonnement): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                  <td style="padding: 10px;"><?= esc($abonnement['date_debut'] ?? '-') ?></td>
                  <td style="padding: 10px;"><?= esc($abonnement['date_fin'] ?? '-') ?></td>
                  <td style="padding: 10px;"><?= number_format((float)($abonnement['montant_paye'] ?? 0), 0, ',', ' ') ?> Ar</td>
                  <td style="padding: 10px;">
                    <?php if (!empty($abonnement['is_actif'])): ?>
                      <span style="background:#dcfce7; color:#166534; padding: 4px 10px; border-radius: 16px; font-size: 0.8rem;">Actif</span>
                    <?php else: ?>
                      <span style="background:#f1f5f9; color:#64748b; padding: 4px 10px; border-radius: 16px; font-size: 0.8rem;">Inactif</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?= $this->include('templates/footer') ?>
</body>
</html>
