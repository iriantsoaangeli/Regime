<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Régimes</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
  <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/activello/activello.css" />
  <link rel="stylesheet" href="/assets/activello/app.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>
  <?php
    $activePage = 'regime';
    $regimesData = $regimesData ?? [];
    $objectif = $objectif ?? null;
    $imc = $imc ?? null;
    $calorieTarget = $calorieTarget ?? 1600;
    $objectifType = $objectifType ?? null;
  ?>

  <?= $this->include('templates/header') ?>

  <main id="main" class="site-main">
    <div class="container">
      <div class="page-header">
        <h1 class="entry-title">Régimes</h1>
      </div>

      <section class="hero-image">
        <img src="/people/prettygirl.jpg" alt="Régimes équilibrés" />
        <div class="hero-overlay">
          <h2>Des menus adaptés à votre objectif</h2>
          <p>Choisissez le programme qui vous aide à avancer chaque jour.</p>
        </div>
      </section>

      <div class="well calorie-banner">
        <div class="row">
          <div class="col-sm-8">
            <h2 class="h3">Objectif Calorique Journalier</h2>
            <p class="text-muted">
              <?php if ($objectif): ?>
                Objectif : <?= esc($objectif['libelle'] ?? '') ?>
              <?php elseif ($objectifType === 'gain'): ?>
                Objectif : Gain de poids
              <?php elseif ($objectifType === 'perte'): ?>
                Objectif : Perte de poids
              <?php else: ?>
                Objectif : Non défini
              <?php endif; ?>
              <?php if ($imc !== null): ?>
                • IMC <?= esc($imc) ?>
              <?php endif; ?>
            </p>
          </div>
          <div class="col-sm-4 text-right">
            <div class="calorie-number"><?= esc($calorieTarget) ?></div>
            <div class="calorie-unit">kcal/jour</div>
          </div>
        </div>
      </div>

      <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('message') ?>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <?php if (empty($regimesData)): ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Régimes</h2>
          </div>
          <div class="panel-body">
            <p>Aucun régime actif disponible pour le moment.</p>
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($regimesData as $index => $item): ?>
          <?php
            $regime = $item['regime'] ?? [];
            $tarifs = $item['tarifs'] ?? [];
            $aliments = $item['aliments'] ?? [];
          ?>
          <div class="panel panel-default" id="ingredients-<?= esc($regime['id'] ?? $index) ?>">
            <div class="panel-heading">
              <h2 class="panel-title"><?= esc($regime['nom'] ?? 'Régime') ?></h2>
            </div>
            <div class="panel-body">
              <?php if (!empty($regime['description'])): ?>
                <p class="text-muted"><?= esc($regime['description']) ?></p>
              <?php endif; ?>

              <?php if (!empty($tarifs)): ?>
                <div class="btn-group" style="margin: 10px 0 20px; flex-wrap: wrap;">
                  <?php foreach ($tarifs as $tarif): ?>
                    <form method="post" action="/commande/acheter-programme" style="display: inline-block; margin: 0 8px 8px 0;">
                      <input type="hidden" name="tarif_id" value="<?= esc($tarif['id'] ?? '') ?>">
                      <input type="hidden" name="total_price" value="<?= esc($tarif['prix'] ?? 0) ?>">
                      <button class="btn btn-primary btn-sm" type="submit">
                        <?= esc($tarif['duree_jours'] ?? '-') ?> jours · <?= number_format((float)($tarif['prix'] ?? 0), 0, ',', ' ') ?> Ar
                      </button>
                    </form>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <?php if (empty($aliments)): ?>
                <p>Aucun aliment configuré pour ce régime.</p>
              <?php else: ?>
                <?php foreach ($aliments as $aliment): ?>
                  <div style="margin-bottom: 12px;">
                    <div class="clearfix">
                      <strong><?= esc($aliment['nom'] ?? 'Aliment') ?></strong>
                      <span class="pull-right"><?= esc($aliment['pct_nourriture'] ?? 0) ?>%</span>
                    </div>
                    <p class="text-muted" style="margin-bottom: 6px;">
                      <?= esc($aliment['description'] ?? 'Composant') ?>
                    </p>
                    <div class="progress progress-sm">
                      <div class="progress-bar progress-bar-info" style="width:<?= esc($aliment['pct_nourriture'] ?? 0) ?>%"></div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <?= $this->include('templates/footer') ?>
</body>

</html>