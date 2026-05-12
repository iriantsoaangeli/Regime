<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthyLife - Accueil</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Lora:400,400i,700" />
  <link rel="stylesheet" href="/assets/activello/bootstrap.min.css" />
  <link rel="stylesheet" href="/assets/activello/activello.css" />
  <link rel="stylesheet" href="/assets/activello/app.css" />
</head>
<body>
  <?php $activePage = 'home'; ?>
  <?= $this->include('templates/header') ?>

  <main id="main" class="site-main">
    <div class="container">
      <section class="hero-image">
        <img src="/people/feelinggood.jpg" alt="Bien-être et énergie" />
        <div class="hero-overlay">
          <h1>Atteignez votre poids idéal avec HealthyLife</h1>
          <p>Votre programme personnalisé associant nutrition équilibrée et activités sportives adaptées à votre profil et à vos objectifs.</p>
          <div>
            <a href="/register/step1" class="btn btn-primary">Commencer gratuitement</a>
            <a href="/login" class="btn btn-default">J'ai déjà un compte</a>
          </div>
        </div>
      </section>

      <div class="row">
        <div class="col-md-4">
          <div class="feature-media">
            <img src="/people/jogging.jpg" alt="Suivi personnalisé" />
          </div>
          <h3>Suivi personnalisé</h3>
          <p class="text-muted">Un calcul précis de votre IMC et un suivi de vos progrès avec des tableaux de bord clairs.</p>
        </div>
        <div class="col-md-4">
          <div class="feature-media">
            <img src="/people/workingout.jpg" alt="Régimes sur mesure" />
          </div>
          <h3>Régimes sur mesure</h3>
          <p class="text-muted">Des suggestions alimentaires calculées pour atteindre votre objectif de poids sereinement.</p>
        </div>
        <div class="col-md-4">
          <div class="feature-media">
            <img src="/people/cyclists.jpg" alt="Programmes sportifs" />
          </div>
          <h3>Programmes sportifs</h3>
          <p class="text-muted">Des activités adaptées pour booster votre métabolisme et rester en pleine forme.</p>
        </div>
      </div>
    </div>
  </main>
  
  <?= $this->include('templates/footer') ?>
</body>
</html>
