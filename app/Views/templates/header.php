<?php
  $activePage = $activePage ?? '';
?>

<header id="masthead" class="site-header" role="banner">
  <nav class="navbar navbar-default" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">HealthyLife</a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li class="<?= $activePage === 'home' ? 'active' : '' ?>"><a href="/">Accueil</a></li>
          <li class="<?= $activePage === 'regime' ? 'active' : '' ?>"><a href="/regime">Régimes</a></li>
          <li class="<?= $activePage === 'sport' ? 'active' : '' ?>"><a href="/sport">Sport</a></li>
          <li class="<?= $activePage === 'dashboard' ? 'active' : '' ?>"><a href="/mon-espace">Mon espace</a></li>
        </ul>

        <?php
          $userName = session()->get('user_name') ?? 'Invité';
          $solde = null;
          if (session()->get('is_logged_in')) {
            $portefeuilleModel = new \App\Models\Portefeuilles\Portefeuille();
            $portefeuille = $portefeuilleModel->where('utilisateur_id', session()->get('user_id'))->first();
            $solde = $portefeuille ? $portefeuille['solde'] : 0;
          }
        ?>

        <ul class="nav navbar-nav navbar-right navbar-user">
          <?php if (session()->get('is_logged_in')): ?>
            <li class="navbar-text">
              <span aria-hidden="true">👤</span>
              <a href="/mon-espace"><?= esc($userName) ?></a>
            </li>
            <li class="navbar-text">
              <span aria-hidden="true">💳</span>
              <?= $solde === null ? '0 Ar' : number_format((float) $solde, 0, ',', ' ') . ' Ar' ?>
            </li>
            <li>
              <a href="/logout" class="btn btn-default navbar-btn">Déconnexion</a>
            </li>
          <?php else: ?>
            <li><a href="/login">Connexion</a></li>
            <li><a href="/register/step1">Inscription</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>