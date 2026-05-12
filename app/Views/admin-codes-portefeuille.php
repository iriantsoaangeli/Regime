<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Codes Portefeuille</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>
<body>
  <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Gestion des codes Portefeuille</h1>
        <p><?= count($codes ?? []) ?> codes disponibles</p>
      </div>
    </div>

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

    <div class="card" style="margin-bottom: 20px;">
      <h2>Créer un code</h2>
      <form method="post" action="">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
          <input class="form-control" type="text" name="code" placeholder="Code (optionnel)" />
          <input class="form-control" type="number" name="montant" placeholder="Montant" required />
        </div>
        <button class="btn-primary" type="submit" style="margin-top: 12px;">Générer</button>
      </form>
    </div>

    <?php $codes = $codes ?? []; ?>
    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Code</th>
              <th>Montant</th>
              <th>Statut</th>
              <th>Utilisé le</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($codes)): ?>
              <tr>
                <td colspan="4">Aucun code enregistré.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($codes as $code): ?>
                <tr>
                  <td><strong><?= esc($code['code'] ?? '') ?></strong></td>
                  <td><?= number_format((float)($code['montant'] ?? 0), 0, ',', ' ') ?> Ar</td>
                  <td>
                    <?php if (!empty($code['is_utilise'])): ?>
                      <span class="badge" style="background:#f1f5f9; color:#64748b;">Utilisé</span>
                    <?php else: ?>
                      <span class="badge badge--green">Disponible</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($code['utilise_le'] ?? '-') ?></td>
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
