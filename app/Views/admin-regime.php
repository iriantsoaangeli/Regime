<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife Admin – Régimes</title>
  <link rel="stylesheet" href="/assets/admin.css" />
</head>
<body>

  <!-- ── NAVBAR ─────────────────────────────────────────────── -->
  <header class="navbar">
    <div class="navbar__brand">
      <div class="brand-icon">🍎</div>
      <span class="brand-name">HealthyLife</span>
    </div>

    <nav class="navbar__nav">
      <a href="dashboard.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>
      <a href="liste-regime.php" class="nav-link nav-link--active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
        </svg>
        Régimes
      </a>
      <a href="liste-sport.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/>
        </svg>
        Sport
      </a>
    </nav>

    <div class="navbar__right">
      <span class="admin-badge">Admin</span>
      <div class="user-pill">
        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
        Marie Dupont
      </div>
    </div>
  </header>

  <!-- ── MAIN ───────────────────────────────────────────────── -->
  <main class="main">

    <div class="page-header">
      <div>
        <h1>Gestion des Régimes</h1>
        <p>12 régimes enregistrés sur la plateforme</p>
      </div>
      <a href="creation-regime.php" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Ajouter un régime
      </a>
    </div>

    <div class="card card--full">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Nom du Régime</th>
              <th>Objectif</th>
              <th>Calories / Jour</th>
              <th>Utilisateurs</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <strong>Régime Poulet</strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Poulet, Riz complet, Brocoli, Avocat</span>
              </td>
              <td><span class="badge badge--orange">📉 Perte de poids</span></td>
              <td>1 800 kcal</td>
              <td>342 users</td>
              <td><span class="badge badge--green">Actif</span></td>
              <td>
                <div class="actions">
                  <a href="creation-regime.php?id=1" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                  </a>
                  <button class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Supprimer
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Régime Méditerranéen</strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Poisson, Huile d'olive, Légumes, Fruits</span>
              </td>
              <td><span class="badge badge--blue">⚖️ Équilibre</span></td>
              <td>2 100 kcal</td>
              <td>218 users</td>
              <td><span class="badge badge--green">Actif</span></td>
              <td>
                <div class="actions">
                  <a href="creation-regime.php?id=2" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                  </a>
                  <button class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Supprimer
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Régime Protéiné</strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Viandes maigres, Œufs, Légumineuses, Whey</span>
              </td>
              <td><span class="badge badge--indigo">💪 Gain musculaire</span></td>
              <td>2 800 kcal</td>
              <td>187 users</td>
              <td><span class="badge badge--green">Actif</span></td>
              <td>
                <div class="actions">
                  <a href="creation-regime.php?id=3" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                  </a>
                  <button class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Supprimer
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Régime Végétarien</strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Tofu, Quinoa, Lentilles, Fruits secs</span>
              </td>
              <td><span class="badge badge--orange">📉 Perte de poids</span></td>
              <td>1 600 kcal</td>
              <td>124 users</td>
              <td><span class="badge badge--green">Actif</span></td>
              <td>
                <div class="actions">
                  <a href="creation-regime.php?id=4" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                  </a>
                  <button class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Supprimer
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <strong>Régime Kéto</strong><br>
                <span style="font-size:0.78rem;color:var(--text-secondary);">Avocats, Noix, Fromages, Viandes grasses</span>
              </td>
              <td><span class="badge badge--orange">📉 Perte de poids</span></td>
              <td>1 500 kcal</td>
              <td>98 users</td>
              <td><span class="badge badge--yellow">Inactif</span></td>
              <td>
                <div class="actions">
                  <a href="creation-regime.php?id=5" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                  </a>
                  <button class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Supprimer
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

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
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="liste-regime.php">Régimes</a></li>
          <li><a href="liste-sport.php">Sport</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h3 class="footer__heading">Support</h3>
        <ul class="footer__links">
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Politique de confidentialité</a></li>
        </ul>
      </div>
      <div class="footer__col">
        <h3 class="footer__heading">Suivez-nous</h3>
        <div class="social-icons">
          <a href="#" class="social-icon" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <a href="#" class="social-icon" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
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