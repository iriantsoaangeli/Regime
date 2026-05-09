<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife – Sport</title>
  <link rel="stylesheet" href="/assets/style.css" />
</head>
<body>

  <!-- ── NAVBAR ─────────────────────────────────────────────── -->
  <header class="navbar">
    <div class="navbar__brand">
      <div class="brand-icon">🍎</div>
      <span class="brand-name">HealthyLife</span>
    </div>

    <nav class="navbar__nav">
      <a href="index.html" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        Home
      </a>
      <a href="regimes.html" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
        </svg>
        Régimes
      </a>
      <a href="sport.html" class="nav-link nav-link--active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/>
        </svg>
        Sport
      </a>
    </nav>

    <div class="navbar__right">
      <div class="user-pill">
        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
        Marie Dupont
      </div>
      <div class="points-pill">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
        </svg>
        250 pts
      </div>
    </div>
  </header>

  <!-- ── MAIN ───────────────────────────────────────────────── -->
  <main class="main">

    <!-- Bannière objectif sport -->
    <div class="sport-banner">
      <div class="sport-banner__icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6,32 18,20 28,28 42,14"/>
          <polyline points="32,14 42,14 42,24"/>
        </svg>
      </div>
      <div>
        <h2 class="sport-banner__title">Votre objectif : Gagner du poids</h2>
        <p class="sport-banner__sub">Développez votre masse musculaire avec des activités adaptées</p>
      </div>
    </div>

    <!-- Mes Activités -->
    <section class="card card--full">
      <h2 class="section-title" style="margin-bottom: 20px;">Mes Activités</h2>

      <div class="sport-activity-list">

        <!-- Cardio -->
        <div class="sport-activity sport-activity--indigo">
          <div class="sport-activity__left">
            <div class="sport-activity__icon sport-activity__icon--indigo">🏋️</div>
            <div class="sport-activity__info">
              <p class="sport-activity__name">Cardio</p>
              <p class="sport-activity__sub">Exercice cardiovasculaire</p>
            </div>
          </div>
          <div class="sport-activity__duration sport-activity__duration--indigo">
            <span class="sport-activity__num">60</span>
            <span class="sport-activity__unit">minutes</span>
          </div>
        </div>

        <!-- Musculation -->
        <div class="sport-activity sport-activity--green">
          <div class="sport-activity__left">
            <div class="sport-activity__icon sport-activity__icon--green">💪</div>
            <div class="sport-activity__info">
              <p class="sport-activity__name">Musculation</p>
              <p class="sport-activity__sub">Renforcement musculaire</p>
            </div>
          </div>
          <div class="sport-activity__duration sport-activity__duration--green">
            <span class="sport-activity__num">45</span>
            <span class="sport-activity__unit">minutes</span>
          </div>
        </div>

      </div>
    </section>

    <!-- Propositions -->
    <section class="card card--full">
      <h2 class="section-title" style="margin-bottom: 20px;">Propositions</h2>

      <div class="proposals-grid">

        <!-- Pompes -->
        <div class="proposal-card">
          <div class="proposal-card__top">
            <div class="proposal-icon proposal-icon--orange">💪</div>
            <div class="proposal-card__info">
              <p class="proposal-card__name">Pompes</p>
              <p class="proposal-card__sub">Renforcement du haut du corps</p>
            </div>
          </div>
          <div class="proposal-card__bottom">
            <span class="proposal-card__duration">45 minutes</span>
            <button class="btn-ajouter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              Ajouter
            </button>
          </div>
        </div>

        <!-- Course -->
        <div class="proposal-card">
          <div class="proposal-card__top">
            <div class="proposal-icon proposal-icon--blue">🏃</div>
            <div class="proposal-card__info">
              <p class="proposal-card__name">Course</p>
              <p class="proposal-card__sub">Endurance et cardio</p>
            </div>
          </div>
          <div class="proposal-card__bottom">
            <span class="proposal-card__duration">45 minutes</span>
            <button class="btn-ajouter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              Ajouter
            </button>
          </div>
        </div>

        <!-- Squat -->
        <div class="proposal-card">
          <div class="proposal-card__top">
            <div class="proposal-icon proposal-icon--purple">🏋️</div>
            <div class="proposal-card__info">
              <p class="proposal-card__name">Squat</p>
              <p class="proposal-card__sub">Renforcement des jambes</p>
            </div>
          </div>
          <div class="proposal-card__bottom">
            <span class="proposal-card__duration">30 minutes</span>
            <button class="btn-ajouter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              Ajouter
            </button>
          </div>
        </div>

        <!-- Yoga -->
        <div class="proposal-card">
          <div class="proposal-card__top">
            <div class="proposal-icon proposal-icon--green">🧘</div>
            <div class="proposal-card__info">
              <p class="proposal-card__name">Yoga</p>
              <p class="proposal-card__sub">Souplesse et relaxation</p>
            </div>
          </div>
          <div class="proposal-card__bottom">
            <span class="proposal-card__duration">40 minutes</span>
            <button class="btn-ajouter">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              Ajouter
            </button>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->
  <footer class="footer">
    <div class="footer__inner">
      <div class="footer__col footer__col--brand">
        <div class="footer__brand">
          <div class="brand-icon brand-icon--sm">🍎</div>
          <span class="brand-name brand-name--light">HealthyLife</span>
        </div>
        <p class="footer__desc">Votre partenaire santé pour atteindre vos objectifs de bien-être et de forme physique.</p>
      </div>
      <div class="footer__col">
        <h3 class="footer__heading">Navigation</h3>
        <ul class="footer__links">
          <li><a href="index.html">Accueil</a></li>
          <li><a href="regimes.html">Régimes</a></li>
          <li><a href="sport.html">Sport</a></li>
          <li><a href="#">Mon Profil</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h3 class="footer__heading">Support</h3>
        <ul class="footer__links">
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Conditions d'utilisation</a></li>
          <li><a href="#">Politique de confidentialité</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h3 class="footer__heading">Suivez-nous</h3>
        <div class="social-icons">
          <a href="#" class="social-icon" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="Email">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <polyline points="2,4 12,13 22,4"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <p>© 2026 HealthyLife. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>