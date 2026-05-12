<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Tarifs Régime</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>
<body>
  <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Tarifs du régime</h1>
        <p><?= count($tarifs ?? []) ?> tarifs configurés</p>
      </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
      <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        <?= session()->getFlashdata('message') ?>
      </div>
    <?php endif; ?>

    <div class="card" style="margin-bottom: 20px;">
      <h2>Ajouter un tarif</h2>
      <form method="post" action="">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
          <input class="form-control" type="number" name="duree_jours" placeholder="Durée (jours)" required />
          <input class="form-control" type="number" step="0.1" name="variation_poids_kg" placeholder="Variation (kg)" required />
          <input class="form-control" type="number" name="prix" placeholder="Prix (Ar)" required />
        </div>
        <button class="btn-primary" type="submit" style="margin-top: 12px;">Ajouter</button>
      </form>
    </div>

    <?php $tarifs = $tarifs ?? []; ?>
    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Durée</th>
              <th>Variation</th>
              <th>Prix</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($tarifs)): ?>
              <tr>
                <td colspan="4">Aucun tarif défini pour ce régime.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($tarifs as $tarif): ?>
                <tr>
                  <td><?= esc($tarif['duree_jours'] ?? '-') ?> jours</td>
                  <td><?= esc($tarif['variation_poids_kg'] ?? '-') ?> kg</td>
                  <td><?= number_format((float)($tarif['prix'] ?? 0), 0, ',', ' ') ?> Ar</td>
                  <td>
                    <?php if (!empty($tarif['is_actif'])): ?>
                      <span class="badge badge--green">Actif</span>
                    <?php else: ?>
                      <span class="badge" style="background:#f1f5f9; color:#64748b;">Inactif</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
