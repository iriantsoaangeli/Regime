<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife Admin – Activités</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>
 <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1>Gestion des Activités Sportives</h1>
        <p><?= count($activites) ?> activités enregistrées</p>
      </div>
      <a href="/admin/sport/create" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19" />
          <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Ajouter un sport
      </a>
    </div>
    
    <?php if (session()->getFlashdata('message')): ?>
        <div style="padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Nom de l'activité</th>
              <th>Prix</th>
              <th>Durée</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($activites as $activite): ?>
            <tr>
              <td>
                <strong><?= esc($activite['nom']) ?></strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);"><?= esc(word_limiter($activite['description'], 10)) ?></span>
              </td>
              <td><?= number_format($activite['prix'], 0, ',', ' ') ?> Ar</td>
              <td><?= esc($activite['duree_jours']) ?> jours</td>
              <td>
                  <?php if ($activite['is_actif']): ?>
                    <span class="badge badge--green">Actif</span>
                  <?php else: ?>
                    <span class="badge" style="background:#f1f5f9; color:#64748b;">Inactif</span>
                  <?php endif; ?>
              </td>
              <td>
                <div class="actions">
                  <a href="/admin/sport/edit/<?= $activite['id'] ?>" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; margin-right: 4px;">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Modifier
                  </a>
                  
                  <?php if ($activite['is_actif']): ?>
                  <a href="/admin/sport/delete/<?= $activite['id'] ?>" class="btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir désactiver ce sport ?');">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; margin-right: 4px;">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6l-1 14H6L5 6" />
                      <path d="M10 11v6" />
                      <path d="M14 11v6" />
                      <path d="M9 6V4h6v2" />
                    </svg>
                    Désactiver
                  </a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
