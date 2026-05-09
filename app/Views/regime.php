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

    <!-- Bannière calorique -->
    <div class="calorie-banner">
      <div class="calorie-banner__left">
        <h2 class="calorie-banner__title">Objectif Calorique Journalier</h2>
        <p class="calorie-banner__sub">Suivez votre apport calorique quotidien</p>
      </div>
      <div class="calorie-banner__right">
        <span class="calorie-banner__number">1800</span>
        <span class="calorie-banner__unit">kcal/jour</span>
      </div>
    </div>

    <!-- Mes Ingrédients -->
    <section class="card card--full" id="ingredients">
      <div class="card-header">
        <h2 class="section-title">Regime poulet</h2>
        <button class="btn-add">
          Changer de regime
        </button>
      </div>

      <div class="ingredient-list">

        <!-- Poulet -->
        <div class="ingredient-item">
          <div class="ingredient-item__top">
            <div class="ingredient-icon ingredient-icon--blue">🍗</div>
            <div class="ingredient-item__info">
              <p class="ingredient-item__name">Poulet</p>
              <p class="ingredient-item__cat">Protéines</p>
            </div>
            <button class="ingredient-item__remove" title="Supprimer">—</button>
          </div>
          <div class="ingredient-item__bar-row">
            <span class="ingredient-item__bar-label">Pourcentage</span>
            <span class="ingredient-item__bar-pct ingredient-item__bar-pct--blue">30%</span>
          </div>
          <div class="ing-bar">
            <div class="ing-bar__fill ing-bar__fill--blue" style="width:30%"></div>
          </div>
        </div>

        <!-- Riz complet -->
        <div class="ingredient-item">
          <div class="ingredient-item__top">
            <div class="ingredient-icon ingredient-icon--orange">🍚</div>
            <div class="ingredient-item__info">
              <p class="ingredient-item__name">Riz complet</p>
              <p class="ingredient-item__cat">Glucides</p>
            </div>
            <button class="ingredient-item__remove" title="Supprimer">—</button>
          </div>
          <div class="ingredient-item__bar-row">
            <span class="ingredient-item__bar-label">Pourcentage</span>
            <span class="ingredient-item__bar-pct ingredient-item__bar-pct--orange">25%</span>
          </div>
          <div class="ing-bar">
            <div class="ing-bar__fill ing-bar__fill--orange" style="width:25%"></div>
          </div>
        </div>

        <!-- Brocoli -->
        <div class="ingredient-item">
          <div class="ingredient-item__top">
            <div class="ingredient-icon ingredient-icon--green">🥦</div>
            <div class="ingredient-item__info">
              <p class="ingredient-item__name">Brocoli</p>
              <p class="ingredient-item__cat">Fibres</p>
            </div>
            <button class="ingredient-item__remove" title="Supprimer">—</button>
          </div>
          <div class="ingredient-item__bar-row">
            <span class="ingredient-item__bar-label">Pourcentage</span>
            <span class="ingredient-item__bar-pct ingredient-item__bar-pct--green">20%</span>
          </div>
          <div class="ing-bar">
            <div class="ing-bar__fill ing-bar__fill--green" style="width:20%"></div>
          </div>
        </div>

        <!-- Avocat -->
        <div class="ingredient-item">
          <div class="ingredient-item__top">
            <div class="ingredient-icon ingredient-icon--yellow">🥑</div>
            <div class="ingredient-item__info">
              <p class="ingredient-item__name">Avocat</p>
              <p class="ingredient-item__cat">Lipides</p>
            </div>
            <button class="ingredient-item__remove" title="Supprimer">—</button>
          </div>
          <div class="ingredient-item__bar-row">
            <span class="ingredient-item__bar-label">Pourcentage</span>
            <span class="ingredient-item__bar-pct ingredient-item__bar-pct--yellow">15%</span>
          </div>
          <div class="ing-bar">
            <div class="ing-bar__fill ing-bar__fill--yellow" style="width:15%"></div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->

  <?= $this->include('templates/footer') ?>

</body>

</html>