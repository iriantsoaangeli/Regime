<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthyLife - Accueil</title>
  <link rel="stylesheet" href="/assets/style.css">
  <style>
    .hero-section {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(135deg, var(--green-light) 0%, var(--surface) 100%);
      border-radius: var(--radius-lg);
      margin-bottom: 40px;
      box-shadow: var(--shadow-card);
    }
    .hero-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--text-primary);
      margin-bottom: 16px;
      letter-spacing: -0.03em;
    }
    .hero-subtitle {
      font-size: 1.1rem;
      color: var(--text-secondary);
      max-width: 600px;
      margin: 0 auto 32px;
      line-height: 1.6;
    }
    .hero-actions {
      display: flex;
      gap: 16px;
      justify-content: center;
    }
    .btn-hero {
      padding: 12px 28px;
      font-size: 1rem;
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .feature-card {
      text-align: center;
      padding: 32px 24px;
    }
    .feature-icon {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      font-size: 28px;
      margin: 0 auto 20px;
      background: var(--blue-light);
    }
    .feature-card h3 {
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .feature-card p {
      font-size: 0.9rem;
      color: var(--text-secondary);
      line-height: 1.5;
    }
    @media (max-width: 768px) {
      .features-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="navbar__brand">
      <div class="brand-icon">🍎</div>
      <span class="brand-name">HealthyLife</span>
    </div>
    <div class="navbar__right">
      <a href="/login" class="nav-link">Se connecter</a>
      <a href="/register/step1" class="btn-ajouter">S'inscrire</a>
    </div>
  </header>

  <main class="main">
    <section class="hero-section">
      <h1 class="hero-title">Atteignez votre poids idéal avec HealthyLife</h1>
      <p class="hero-subtitle">Votre programme personnalisé associant nutrition équilibrée et activités sportives adaptées à votre profil et à vos objectifs.</p>
      <div class="hero-actions">
        <a href="/register/step1" class="btn-ajouter btn-hero">Commencer gratuitement</a>
        <a href="/login" class="btn-modifier btn-hero">J'ai déjà un compte</a>
      </div>
    </section>

    <div class="features-grid">
      <div class="card feature-card">
        <div class="feature-icon" style="background: var(--green-light); color: var(--green);">📊</div>
        <h3>Suivi Personnalisé</h3>
        <p>Un calcul précis de votre IMC et un suivi de vos progrès avec des tableaux de bord clairs.</p>
      </div>
      <div class="card feature-card">
        <div class="feature-icon" style="background: var(--orange-light); color: var(--orange);">🥗</div>
        <h3>Régimes sur mesure</h3>
        <p>Des suggestions alimentaires calculées pour atteindre votre objectif de poids sereinement.</p>
      </div>
      <div class="card feature-card">
        <div class="feature-icon" style="background: var(--indigo-light); color: var(--indigo);">🏃‍♂️</div>
        <h3>Programmes sportifs</h3>
        <p>Des activités adaptées pour booster votre métabolisme et rester en pleine forme.</p>
      </div>
    </div>
  </main>
  
  <?= $this->include('templates/footer') ?>
</body>
</html>
