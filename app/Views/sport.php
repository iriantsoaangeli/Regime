<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Sport</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
  <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/activello/activello.css" />
  <link rel="stylesheet" href="/assets/activello/app.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>
  <?php
    $activePage = 'sport';
    $objectif = $objectif ?? null;
    $objectifType = $objectifType ?? null;
    $imc = $imc ?? null;
    $activitesRecommandees = $activitesRecommandees ?? [];
  ?>

  <?= $this->include('templates/header') ?>

  <main id="main" class="site-main">
    <div class="container">
      <div class="page-header">
        <h1 class="entry-title">Sport</h1>
      </div>

      <section class="hero-image">
        <img src="/people/workingout.jpg" alt="Activités sportives" />
        <div class="hero-overlay">
          <h2>Restez motivé chaque jour</h2>
          <p>Des programmes sportifs adaptés à votre rythme et à votre objectif.</p>
        </div>
      </section>

      <div class="well calorie-banner">
        <h2 class="h3">
          <?php if ($objectif): ?>
            Votre objectif : <?= esc($objectif['libelle'] ?? '') ?>
          <?php elseif ($objectifType === 'gain'): ?>
            Votre objectif : Augmenter
          <?php elseif ($objectifType === 'perte'): ?>
            Votre objectif : Réduire
          <?php else: ?>
            Votre objectif : Non défini
          <?php endif; ?>
        </h2>
        <p class="text-muted">
          <?php if ($objectifType === 'gain'): ?>
            Développez votre masse musculaire avec des activités adaptées.
          <?php elseif ($objectifType === 'perte'): ?>
            Brûlez des calories avec des activités adaptées.
          <?php else: ?>
            Définissez votre profil pour des suggestions adaptées.
          <?php endif; ?>
          <?php if ($imc !== null): ?>
            • IMC <?= esc($imc) ?>
          <?php endif; ?>
        </p>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h2 class="panel-title">Activités recommandées</h2>
        </div>
        <div class="panel-body">
          <?php if (empty($activitesRecommandees)): ?>
            <p>Aucune activité recommandée disponible pour cet objectif.</p>
          <?php else: ?>
            <ul class="list-group">
              <?php foreach ($activitesRecommandees as $activite): ?>
                <li class="list-group-item">
                  <h4 class="list-group-item-heading"><?= esc($activite['nom'] ?? 'Activité') ?></h4>
                  <p class="list-group-item-text text-muted"><?= esc($activite['description'] ?? 'Programme') ?></p>
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
  </main>

  <?= $this->include('templates/footer') ?>
</body>

</html>