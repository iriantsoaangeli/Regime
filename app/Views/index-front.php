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

    <!-- Mon Objectif -->
    <section class="card card--full" id="objectif">
      <div class="card-header">
        <h2 class="section-title">Mon Objectif</h2>
        <button class="btn-modifier btn-modifier--right">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
          </svg>
          Modifier
        </button>
      </div>

      <div class="goal-card goal-card--orange">
        <div class="goal-card__text">
          <p class="goal-card__label">Perdre du poids</p>
          <p class="goal-card__sub">Atteindre votre poids idéal</p>
        </div>
        <div class="goal-card__icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6,16 18,28 28,20 42,34" />
            <polyline points="32,34 42,34 42,24" />
          </svg>
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
        </div>

        <div class="calories-row">
          <span class="calories-label">Calories journalières</span>
          <span class="calories-value">1800 kcal</span>
        </div>
        <div class="progress-bar">
          <div class="progress-bar__fill" style="width: 72%"></div>
        </div>

        <div class="macros">
          <div class="macro macro--blue">
            <span class="macro__name">Protéines</span>
            <span class="macro__value">120g</span>
          </div>
          <div class="macro macro--orange">
            <span class="macro__name">Glucides</span>
            <span class="macro__value">200g</span>
          </div>
          <div class="macro macro--yellow">
            <span class="macro__name">Lipides</span>
            <span class="macro__value">60g</span>
          </div>
        </div>
      </section>

      <!-- Activités Sportives -->
      <section class="card" id="activites">
        <div class="card-header">
          <div class="card-icon card-icon--purple">🏃</div>
          <h2 class="section-title">Activités Sportives</h2>
          <button class="btn-modifier btn-modifier--right">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Modifier
          </button>
        </div>

        <ul class="activity-list">
          <li class="activity activity--blue">
            <div class="activity__accent"></div>
            <div class="activity__info">
              <p class="activity__name">Course à pied</p>
              <p class="activity__meta">Aujourd'hui · 350 kcal brûlées</p>
            </div>
            <span class="activity__duration activity__duration--blue">45 min</span>
          </li>
          <li class="activity activity--green">
            <div class="activity__accent"></div>
            <div class="activity__info">
              <p class="activity__name">Musculation</p>
              <p class="activity__meta">Hier · 280 kcal brûlées</p>
            </div>
            <span class="activity__duration activity__duration--green">60 min</span>
          </li>
          <li class="activity activity--indigo">
            <div class="activity__accent"></div>
            <div class="activity__info">
              <p class="activity__name">Yoga</p>
              <p class="activity__meta">Il y a 2 jours · 120 kcal brûlées</p>
            </div>
            <span class="activity__duration activity__duration--indigo">30 min</span>
          </li>
        </ul>
      </section>

    </div>
  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->

  <?= $this->include('templates/footer') ?>

</body>

</html>