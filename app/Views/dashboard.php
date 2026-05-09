<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife Admin – Dashboard</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
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
      <a href="dashboard.php" class="nav-link nav-link--active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" />
          <rect x="14" y="3" width="7" height="7" />
          <rect x="3" y="14" width="7" height="7" />
          <rect x="14" y="14" width="7" height="7" />
        </svg>
        Dashboard
      </a>
      <a href="liste-regime.php" class="nav-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
          <path d="M7 2v20" />
          <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7" />
        </svg>
        Régimes
      </a>
      <a href="liste-sport.php" class="nav-link">
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
      <span class="admin-badge">Admin</span>
      <div class="user-pill">
        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4" />
          <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
        </svg>
        Marie Dupont
      </div>
    </div>
  </header> -->

  <?= $this->include('templates/header-admin') ?>

  <!-- ── MAIN ───────────────────────────────────────────────── -->
  <main class="main">

    <div class="page-header">
      <div>
        <h1>Dashboard</h1>
        <p>Vue d'ensemble de la plateforme HealthyLife</p>
      </div>
    </div>

    <!-- KPI Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon stat-icon--blue">👥</div>
        <div>
          <div class="stat-val stat-val--blue">1 248</div>
          <div class="stat-label">Utilisateurs actifs</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon stat-icon--yellow">⭐</div>
        <div>
          <div class="stat-val stat-val--orange">186</div>
          <div class="stat-label">Gold Members</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon stat-icon--green">📋</div>
        <div>
          <div class="stat-val stat-val--green">12</div>
          <div class="stat-label">Régimes actifs</div>
        </div>
      </div>
    </div>

    <!-- Graphique poids par programme -->
    <div class="card card--full">
      <div class="card-header">
        <h2 class="section-title">Évolution du Poids par Programme (kg)</h2>
      </div>
      <div class="chart-legend">
        <div class="legend-item">
          <div class="legend-dot" style="background:#3b82f6;"></div>
          Régime Perte de Poids
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:#22c55e;"></div>
          Régime Gain Musculaire
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:#f97316;"></div>
          Régime Équilibre
        </div>
      </div>
      <div class="chart-area">
        <canvas id="weightChart"></canvas>
      </div>
    </div>

    <!-- Gold Members répartition -->
    <div class="card card--full">
      <div class="card-header">
        <h2 class="section-title">Répartition Gold Members vs Standard</h2>
      </div>
      <div class="grid-chart">
        <div class="chart-area" style="height:200px;">
          <canvas id="pieChart"></canvas>
        </div>
        <div>
          <div class="gold-row gold-row--yellow">
            <span class="gold-row__label">⭐ Gold Members</span>
            <span class="gold-row__val">186</span>
          </div>
          <div class="gold-row gold-row--blue">
            <span class="gold-row__label">👤 Standard</span>
            <span class="gold-row__val">1 062</span>
          </div>
          <p style="font-size:0.82rem;color:var(--text-secondary);padding:0 4px;margin-top:8px;">
            14,9 % des utilisateurs sont Gold Members
          </p>
        </div>
      </div>
    </div>

  </main>

  <!-- ── FOOTER ─────────────────────────────────────────────── -->
  <!-- <footer class="footer">
    <div class="footer__inner">
      <div class="footer__col footer__col--brand">
        <div class="footer__brand">
          <div class="brand-icon brand-icon--sm">🍎</div>
          <span class="brand-name brand-name--light">HealthyLife</span>
        </div>
        <p class="footer__desc">Votre partenaire santé pour atteindre vos objectifs de bien-être et de forme physique.
        </p>
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <p>© 2026 HealthyLife. Tous droits réservés.</p>
    </div>
  </footer> -->

  <?= $this->include('templates/footer-admin') ?>
  <script>
    const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'];

    new Chart(document.getElementById('weightChart'), {
      type: 'line',
      data: {
        labels: months,
        datasets: [
          {
            label: 'Perte de poids',
            data: [-1.2, -2.1, -3.0, -3.8, -4.5, -5.1],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.08)',
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'Gain musculaire',
            data: [0.8, 1.5, 2.2, 2.9, 3.5, 4.1],
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.08)',
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#22c55e',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'Équilibre',
            data: [-0.2, 0.1, -0.1, 0.2, 0.1, -0.3],
            borderColor: '#f97316',
            backgroundColor: 'rgba(249,115,22,0.06)',
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointBackgroundColor: '#f97316',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            grid: { color: 'rgba(0,0,0,.05)' },
            ticks: { callback: v => v + ' kg' }
          },
          x: { grid: { display: false } }
        }
      }
    });

    new Chart(document.getElementById('pieChart'), {
      type: 'doughnut',
      data: {
        labels: ['Gold Members', 'Standard'],
        datasets: [{
          data: [186, 1062],
          backgroundColor: ['#eab308', '#3b82f6'],
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '70%'
      }
    });
  </script>

</body>

</html>