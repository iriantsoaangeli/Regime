<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Nourritures</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>
<body>
  <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Gestion des Nourritures</h1>
        <p><?= count($nourritures ?? []) ?> nourritures enregistrées</p>
      </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
      <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        <?= session()->getFlashdata('message') ?>
      </div>
    <?php endif; ?>

    <div class="card" style="margin-bottom: 20px;">
      <h2>Ajouter une nourriture</h2>
      <form method="post" action="">
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
          <input class="form-control" type="text" name="nom" placeholder="Nom" required />
          <input class="form-control" type="text" name="description" placeholder="Description" />
        </div>
        <button class="btn-primary" type="submit" style="margin-top: 12px;">Ajouter</button>
      </form>
    </div>

    <?php $nourritures = $nourritures ?? []; ?>
    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Description</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($nourritures)): ?>
              <tr>
                <td colspan="3">Aucune nourriture disponible.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($nourritures as $nourriture): ?>
                <tr>
                  <td><strong><?= esc($nourriture['nom'] ?? '') ?></strong></td>
                  <td><?= esc($nourriture['description'] ?? '-') ?></td>
                  <td>
                    <?php if (!empty($nourriture['is_actif'])): ?>
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
