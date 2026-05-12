<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Sport</title>
  <link rel="stylesheet" href="/assets/style.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
</head>

<body>

  <!-- ── NAVBAR ─────────────────────────────────────────────── -->
  <!-- <header class="navbar">
    <div class="navbar__brand">
      <div class="brand-icon">🍎</div>
      <span class="brand-name">HealthyLife</span>
    </div>

    <nav class="navbar__nav">
      <a href="index.html" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        Home
      </a>
      <a href="regimes.html" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
          <path d="M7 2v20" />
          <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
        </svg>
        Régimes
      </a>
      <a href="sport.html" class="nav-link nav-link--active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10" />
          <path
            d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32" />
        </svg>
        Sport
      </a>
    </nav>

    <div class="navbar__right">
      <div class="user-pill">
        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4" />
          <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
        </svg>
        Marie Dupont
      </div>
      <div class="points-pill">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="5" width="20" height="14" rx="2" />
          <line x1="2" y1="10" x2="22" y2="10" />
        </svg>
        250 pts
      </div>
    </div>
  </header> -->

  <?= $this->include('templates/header') ?>


  <!-- ── MAIN ───────────────────────────────────────────────── -->
  <main class="main">

    <?php
      $objectif = $objectif ?? null;
      $objectifType = $objectifType ?? null;
      $imc = $imc ?? null;
      $activitesRecommandees = $activitesRecommandees ?? [];
    ?>

    <!-- Bannière objectif sport -->
    <div class="sport-banner">
      <div class="sport-banner__icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6,32 18,20 28,28 42,14" />
          <polyline points="32,14 42,14 42,24" />
        </svg>
      </div>
      <div>
        <h2 class="sport-banner__title">
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
        <p class="sport-banner__sub">
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
    </div>

    <section class="card card--full">
      <h2 class="section-title" style="margin-bottom: 20px;">Activités recommandées</h2>

      <div class="sport-activity-list">
        <?php if (empty($activitesRecommandees)): ?>
          <p>Aucune activité recommandée disponible pour cet objectif.</p>
        <?php else: ?>
          <?php
            $styles = ['purple', 'blue', 'orange', 'green', 'indigo'];
          ?>
          <?php foreach ($activitesRecommandees as $index => $activite): ?>
            <?php $style = $styles[$index % count($styles)]; ?>
            <div class="sport-activity sport-activity--<?= esc($style) ?>">
              <div class="sport-activity__left">
                <div class="sport-activity__icon sport-activity__icon--<?= esc($style) ?>">✨</div>
                <div class="sport-activity__info">
                  <p class="sport-activity__name"><?= esc($activite['nom'] ?? 'Activité') ?></p>
                  <p class="sport-activity__sub"><?= esc($activite['description'] ?? 'Programme') ?></p>
                </div>
              </div>
              <div class="sport-activity__duration sport-activity__duration--<?= esc($style) ?>">
                <span class="sport-activity__num"><?= esc($activite['duree_jours'] ?? '-') ?></span>
                <span class="sport-activity__unit">jours</span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->
  <?= $this->include('templates/footer') ?>
</body>

</html>