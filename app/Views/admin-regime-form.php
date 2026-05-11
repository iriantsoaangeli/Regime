<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife Admin – <?= isset($regime) ? 'Modifier' : 'Ajouter' ?> un Régime</title>
  <link rel="stylesheet" href="/assets/admin.css" />
  <link rel="shortcut icon" type="image/png" href="/image.png">
  <style>
      .form-group { margin-bottom: 15px; }
      .form-label { display: block; margin-bottom: 5px; font-weight: 500;}
      .form-control { width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px;}
  </style>
</head>

<body>
 <?= $this->include('templates/header-admin') ?>

  <main class="main">
    <div class="page-header">
      <div>
        <h1><?= isset($regime) ? 'Modifier le Régime' : 'Ajouter un Régime' ?></h1>
      </div>
      <a href="/admin/regime" class="btn-secondary">Retour à la liste</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card">
      <form action="<?= isset($regime) ? '/admin/regime/edit/'.$regime['id'] : '/admin/regime/create' ?>" method="post">
          <div class="form-group">
              <label class="form-label">Nom du Régime</label>
              <input type="text" name="nom" class="form-control" value="<?= isset($regime) ? esc($regime['nom']) : old('nom') ?>" required>
          </div>
          
          <div class="form-group">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required><?= isset($regime) ? esc($regime['description']) : old('description') ?></textarea>
          </div>
          
          <h3 style="margin-top: 25px; margin-bottom: 10px; font-size: 1.1rem;">Composition (%) - Doit totaliser 100%</h3>
          <div style="display: flex; gap: 15px;">
              <div class="form-group" style="flex: 1;">
                  <label class="form-label">% Viande</label>
                  <input type="number" step="0.01" name="pct_viande" class="form-control" value="<?= isset($regime) ? esc($regime['pct_viande']) : (old('pct_viande') ?? 0) ?>" required>
              </div>
              <div class="form-group" style="flex: 1;">
                  <label class="form-label">% Poisson</label>
                  <input type="number" step="0.01" name="pct_poisson" class="form-control" value="<?= isset($regime) ? esc($regime['pct_poisson']) : (old('pct_poisson') ?? 0) ?>" required>
              </div>
              <div class="form-group" style="flex: 1;">
                  <label class="form-label">% Volaille</label>
                  <input type="number" step="0.01" name="pct_volaille" class="form-control" value="<?= isset($regime) ? esc($regime['pct_volaille']) : (old('pct_volaille') ?? 0) ?>" required>
              </div>
          </div>
          
          <div class="form-group" style="margin-top: 20px;">
              <label class="form-label">
                  <input type="checkbox" name="is_actif" value="1" <?= (isset($regime) && $regime['is_actif'] == 1) || !isset($regime) ? 'checked' : '' ?>>
                  Régime Actif
              </label>
          </div>
          
          <div style="margin-top: 30px;">
              <button type="submit" class="btn-primary">Enregistrer le Régime</button>
          </div>
      </form>
    </div>
  </main>
</body>
</html>
