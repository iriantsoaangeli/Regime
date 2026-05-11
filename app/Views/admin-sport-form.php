<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HealthyLife Admin – <?= isset($activite) ? 'Modifier' : 'Ajouter' ?> un Sport</title>
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
        <h1><?= isset($activite) ? 'Modifier \'Activité' : 'Ajouter une Activité' ?></h1>
      </div>
      <a href="/admin/sport" class="btn-secondary">Retour à la liste</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card">
      <form action="<?= isset($activite) ? '/admin/sport/edit/'.$activite['id'] : '/admin/sport/create' ?>" method="post">
          
          <div class="form-group">
              <label class="form-label">Catégorie d'activité</label>
              <select name="categorie_id" class="form-control" required>
                  <?php foreach($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= (isset($activite) && $activite['categorie_id'] == $cat['id']) ? 'selected' : '' ?>>
                      <?= esc($cat['libelle']) ?>
                  </option>
                  <?php endforeach; ?>
              </select>
          </div>

          <div class="form-group">
              <label class="form-label">Nom de l'activité</label>
              <input type="text" name="nom" class="form-control" value="<?= isset($activite) ? esc($activite['nom']) : old('nom') ?>" required>
          </div>
          
          <div class="form-group">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required><?= isset($activite) ? esc($activite['description']) : old('description') ?></textarea>
          </div>
          
          <div style="display: flex; gap: 15px;">
              <div class="form-group" style="flex: 1;">
                  <label class="form-label">Durée (en jours)</label>
                  <input type="number" name="duree_jours" class="form-control" value="<?= isset($activite) ? esc($activite['duree_jours']) : old('duree_jours') ?>" required>
              </div>
              <div class="form-group" style="flex: 1;">
                  <label class="form-label">Prix (Ar)</label>
                  <input type="number" step="0.01" name="prix" class="form-control" value="<?= isset($activite) ? esc($activite['prix']) : old('prix') ?>" required>
              </div>
          </div>
          
          <div class="form-group" style="margin-top: 20px;">
              <label class="form-label">
                  <input type="checkbox" name="is_actif" value="1" <?= (isset($activite) && $activite['is_actif'] == 1) || !isset($activite) ? 'checked' : '' ?>>
                  Activité Active
              </label>
          </div>
          
          <div style="margin-top: 30px;">
              <button type="submit" class="btn-primary">Enregistrer l'activité</button>
          </div>
      </form>
    </div>
  </main>
</body>
</html>
