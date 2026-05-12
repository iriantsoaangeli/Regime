<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Utilisateurs</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>
<body>
  <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Gestion des Utilisateurs</h1>
        <p><?= count($utilisateurs ?? []) ?> utilisateurs enregistrés</p>
      </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
      <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        <?= session()->getFlashdata('message') ?>
      </div>
    <?php endif; ?>

    <?php $utilisateurs = $utilisateurs ?? []; ?>
    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($utilisateurs)): ?>
              <tr>
                <td colspan="3">Aucun utilisateur trouvé.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                  <td><?= esc(($utilisateur['prenom'] ?? '') . ' ' . ($utilisateur['nom'] ?? '')) ?></td>
                  <td><?= esc($utilisateur['email'] ?? '-') ?></td>
                  <td>
                    <?php if (!empty($utilisateur['is_active'])): ?>
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
