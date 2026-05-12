<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Tableau de bord</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
  <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/activello/activello.css" />
  <link rel="stylesheet" href="/assets/activello/app.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>
  <?php
    $activePage = 'home';
    $objectif = $objectif ?? null;
    $objectifType = $objectifType ?? null;
    $regimeActuel = $regimeActuel ?? null;
    $regimeNourritures = $regimeNourritures ?? [];
    $activitesRecommandees = $activitesRecommandees ?? [];
  ?>

  <?= $this->include('templates/header') ?>

  <main id="main" class="site-main">
    <div class="container">
      <section class="hero-image">
        <img src="/people/watchingsky.jpg" alt="Objectifs santé" />
        <div class="hero-overlay">
          <h2>Votre progression, en images</h2>
          <p>Un tableau de bord clair pour suivre votre alimentation et vos activités.</p>
        </div>
      </section>
      <div class="dashboard-header">
        <div>
          <h1 class="entry-title">Tableau de bord</h1>
          <p class="lead">Suivez votre objectif, vos régimes et vos activités sportives.</p>
        </div>
        <div>
          <a class="btn btn-primary" href="/mon-espace">Mon espace</a>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h2 class="panel-title pull-left">Mon Objectif</h2>
          <a class="btn btn-default btn-xs pull-right" href="/mon-espace">Modifier</a>
        </div>
        <div class="panel-body">
          <?php if ($objectif): ?>
            <h3><?= esc($objectif['libelle'] ?? 'Objectif') ?></h3>
            <p class="text-muted"><?= esc($objectif['description'] ?? 'Objectif personnalisé') ?></p>
          <?php else: ?>
            <p class="text-muted">Objectif non défini. Complétez votre profil pour afficher un objectif.</p>
          <?php endif; ?>
          <?php if ($objectifType === 'gain'): ?>
            <span class="label label-success">Prise de masse</span>
          <?php elseif ($objectifType === 'perte'): ?>
            <span class="label label-warning">Perte de poids</span>
          <?php else: ?>
            <span class="label label-default">Objectif en attente</span>
          <?php endif; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading clearfix">
              <h2 class="panel-title pull-left">Régime actuel</h2>
              <a class="btn btn-default btn-xs pull-right" href="/regime">Modifier</a>
            </div>
            <div class="panel-body">
              <?php if ($regimeActuel): ?>
                <h4><?= esc($regimeActuel['nom'] ?? 'Régime actuel') ?></h4>
                <p class="text-muted"><?= esc($regimeActuel['description'] ?? 'Description non disponible.') ?></p>

                <?php if (!empty($regimeNourritures)): ?>
                  <?php foreach ($regimeNourritures as $item): ?>
                    <div>
                      <div class="clearfix">
                        <strong><?= esc($item['nom'] ?? 'Aliment') ?></strong>
                        <span class="pull-right"><?= esc($item['pct_nourriture'] ?? 0) ?>%</span>
                      </div>
                      <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-info" style="width:<?= esc($item['pct_nourriture'] ?? 0) ?>%"></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted">Aucun aliment défini pour ce régime.</p>
                <?php endif; ?>
              <?php else: ?>
                <p class="text-muted">Aucun régime actif trouvé.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading clearfix">
              <h2 class="panel-title pull-left">Activités sportives</h2>
              <a class="btn btn-default btn-xs pull-right" href="/sport">Voir</a>
            </div>
            <div class="panel-body">
              <?php if (empty($activitesRecommandees)): ?>
                <p class="text-muted">Aucune activité recommandée pour le moment.</p>
              <?php else: ?>
                <ul class="list-group">
                  <?php foreach ($activitesRecommandees as $activite): ?>
                    <li class="list-group-item">
                      <h4 class="list-group-item-heading"><?= esc($activite['nom'] ?? 'Activité') ?></h4>
                      <p class="list-group-item-text text-muted"><?= esc($activite['description'] ?? 'Programme en cours') ?></p>
                      <div class="activity-meta">
                        <span class="label label-primary"><?= esc($activite['duree_jours'] ?? '-') ?> jours</span>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?= $this->include('templates/footer') ?>
</body>
</html>
