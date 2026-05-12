<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Régimes</title>
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
      <a href="regimes.html" class="nav-link nav-link--active">
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
      $regimesData = $regimesData ?? [];
      $objectif = $objectif ?? null;
      $imc = $imc ?? null;
      $calorieTarget = $calorieTarget ?? 1600;
      $objectifType = $objectifType ?? null;
    ?>

    <div class="calorie-banner">
      <div class="calorie-banner__left">
        <h2 class="calorie-banner__title">Objectif Calorique Journalier</h2>
        <p class="calorie-banner__sub">
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
      <div class="calorie-banner__right">
        <span class="calorie-banner__number"><?= esc($calorieTarget) ?></span>
        <span class="calorie-banner__unit">kcal/jour</span>
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

    <?php if (empty($regimesData)): ?>
      <section class="card card--full">
        <div class="card-header">
          <h2 class="section-title">Régimes</h2>
        </div>
        <p>Aucun régime actif disponible pour le moment.</p>
      </section>
    <?php else: ?>
      <?php foreach ($regimesData as $index => $item): ?>
        <?php
          $regime = $item['regime'] ?? [];
          $tarifs = $item['tarifs'] ?? [];
          $aliments = $item['aliments'] ?? [];
        ?>
        <section class="card card--full" id="ingredients-<?= esc($regime['id'] ?? $index) ?>">
          <div class="card-header">
            <h2 class="section-title"><?= esc($regime['nom'] ?? 'Régime') ?></h2>
          </div>

          <?php if (!empty($regime['description'])): ?>
            <p style="margin-top: 0; color: var(--text-secondary);">
              <?= esc($regime['description']) ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($tarifs)): ?>
            <div style="margin: 16px 0; display: flex; flex-wrap: wrap; gap: 12px;">
              <?php foreach ($tarifs as $tarif): ?>
                <form method="post" action="/commande/acheter-programme" style="margin: 0;">
                  <input type="hidden" name="tarif_id" value="<?= esc($tarif['id'] ?? '') ?>">
                  <input type="hidden" name="total_price" value="<?= esc($tarif['prix'] ?? 0) ?>">
                  <button class="macro macro--blue" type="submit" style="min-width: 140px; cursor: pointer; border: none;">
                    <span class="macro__name"><?= esc($tarif['duree_jours'] ?? '-') ?> jours</span>
                    <span class="macro__value"><?= number_format((float)($tarif['prix'] ?? 0), 0, ',', ' ') ?> Ar</span>
                  </button>
                </form>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div class="ingredient-list">
            <?php if (empty($aliments)): ?>
              <p>Aucun aliment configuré pour ce régime.</p>
            <?php else: ?>
              <?php
                $colors = ['blue', 'orange', 'green', 'yellow', 'purple', 'indigo'];
              ?>
              <?php foreach ($aliments as $i => $aliment): ?>
                <?php $color = $colors[$i % count($colors)]; ?>
                <div class="ingredient-item">
                  <div class="ingredient-item__top">
                    <div class="ingredient-icon ingredient-icon--<?= esc($color) ?>">🍽️</div>
                    <div class="ingredient-item__info">
                      <p class="ingredient-item__name"><?= esc($aliment['nom'] ?? 'Aliment') ?></p>
                      <p class="ingredient-item__cat"><?= esc($aliment['description'] ?? 'Composant') ?></p>
                    </div>
                  </div>
                  <div class="ingredient-item__bar-row">
                    <span class="ingredient-item__bar-label">Pourcentage</span>
                    <span class="ingredient-item__bar-pct ingredient-item__bar-pct--<?= esc($color) ?>">
                      <?= esc($aliment['pct_nourriture'] ?? 0) ?>%
                    </span>
                  </div>
                  <div class="ing-bar">
                    <div class="ing-bar__fill ing-bar__fill--<?= esc($color) ?>" style="width:<?= esc($aliment['pct_nourriture'] ?? 0) ?>%"></div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>

  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->

  <?= $this->include('templates/footer') ?>

</body>

</html>