<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Dashboard</title>
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
      <a href="#" class="nav-link nav-link--active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        Home
      </a>
      <a href="#" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
          <path d="M7 2v20" />
          <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
        </svg>
        Régimes
      </a>
      <a href="#" class="nav-link">
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
  $regimeActuel = $regimeActuel ?? null;
  $regimeNourritures = $regimeNourritures ?? [];
  $activitesRecommandees = $activitesRecommandees ?? [];
    ?>

    <!-- Mon Objectif -->
    <section class="card card--full" id="objectif">
      <div class="card-header">
        <h2 class="section-title">Mon Objectif</h2>
        <a class="btn-modifier btn-modifier--right" href="/mon-espace">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
          </svg>
          Modifier
        </a>
      </div>

      <div class="goal-card goal-card--orange">
        <div class="goal-card__text">
          <?php if ($objectif): ?>
            <p class="goal-card__label"><?= esc($objectif['libelle'] ?? 'Objectif') ?></p>
            <p class="goal-card__sub"><?= esc($objectif['description'] ?? 'Objectif personnalisé') ?></p>
          <?php else: ?>
            <p class="goal-card__label">Objectif non défini</p>
            <p class="goal-card__sub">Complétez votre profil pour afficher un objectif</p>
          <?php endif; ?>
        </div>
        <div class="goal-card__icon">
          <?php if ($objectifType === 'gain'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5"
              stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6,32 18,20 28,28 42,14" />
              <polyline points="32,14 42,14 42,24" />
            </svg>
          <?php elseif ($objectifType === 'perte'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5"
              stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6,16 18,28 28,20 42,34" />
              <polyline points="32,34 42,34 42,24" />
            </svg>
          <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5"
              stroke-linecap="round" stroke-linejoin="round">
              <circle cx="24" cy="24" r="18" />
              <line x1="24" y1="14" x2="24" y2="24" />
              <line x1="24" y1="24" x2="30" y2="30" />
            </svg>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Grille inférieure -->
    <div class="grid-two">

      <!-- Régime Actuel -->
      <section class="card" id="regime">
        <div class="card-header">
          <div class="card-icon card-icon--green">🍎</div>
          <h2 class="section-title">Régime Actuel</h2>
          <a class="btn-modifier btn-modifier--right" href="/regime">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Modifier
          </a>
        </div>

        <?php if ($regimeActuel): ?>
          <p style="margin: 6px 0 12px; color: var(--text-secondary);">
            <?= esc($regimeActuel['nom'] ?? 'Régime actuel') ?>
          </p>
          <p style="margin: 0 0 16px; color: var(--text-secondary); font-size: 0.9rem;">
            <?= esc($regimeActuel['description'] ?? 'Description non disponible.') ?>
          </p>

          <?php if (!empty($regimeNourritures)): ?>
            <div class="macros">
              <?php foreach ($regimeNourritures as $item): ?>
                <div class="macro macro--blue">
                  <span class="macro__name"><?= esc($item['nom'] ?? 'Aliment') ?></span>
                  <span class="macro__value"><?= esc($item['pct_nourriture'] ?? 0) ?>%</span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p style="color: var(--text-secondary);">Aucun aliment défini pour ce régime.</p>
          <?php endif; ?>
        <?php else: ?>
          <p style="color: var(--text-secondary);">Aucun régime actif trouvé.</p>
        <?php endif; ?>
      </section>

      <!-- Activités Sportives -->
      <section class="card" id="activites">
        <div class="card-header">
          <div class="card-icon card-icon--purple">🏃</div>
          <h2 class="section-title">Activités Sportives</h2>
        </div>

        <ul class="activity-list">
          <?php if (empty($activitesRecommandees)): ?>
            <li class="activity activity--blue">
              <div class="activity__accent"></div>
              <div class="activity__info">
                <p class="activity__name">Aucune activité recommandée</p>
                <p class="activity__meta">Définissez votre objectif pour voir des recommandations</p>
              </div>
              <span class="activity__duration activity__duration--blue">-</span>
            </li>
          <?php else: ?>
            <?php
              $activityStyles = [
                ['activity--blue', 'activity__duration--blue'],
                ['activity--green', 'activity__duration--green'],
                ['activity--indigo', 'activity__duration--indigo']
              ];
            ?>
            <?php foreach ($activitesRecommandees as $index => $activite): ?>
              <?php $style = $activityStyles[$index % count($activityStyles)]; ?>
              <li class="activity <?= $style[0] ?>">
                <div class="activity__accent"></div>
                <div class="activity__info">
                  <p class="activity__name"><?= esc($activite['nom'] ?? 'Activité') ?></p>
                  <p class="activity__meta">
                    <?= esc($activite['description'] ?? 'Programme en cours') ?>
                  </p>
                </div>
                <span class="activity__duration <?= $style[1] ?>">
                  <?= esc($activite['duree_jours'] ?? '-') ?> j
                </span>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </section>

    </div>
  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->

  <?= $this->include('templates/footer') ?>

</body>
</html>
