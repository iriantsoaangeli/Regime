-- Vue tableau de bord : profil complet utilisateur
CREATE OR REPLACE VIEW v_profils_utilisateurs AS
SELECT
  u.id,
  CONCAT(u.prenom, ' ', u.nom)        AS nom_complet,
  u.email,
  rg.libelle                           AS genre,
  ps.taille_cm,
  ps.poids_kg,
  ps.imc,
  CASE
    WHEN ps.imc < 18.5  THEN 'Insuffisance pondérale'
    WHEN ps.imc < 25.0  THEN 'Poids normal'
    WHEN ps.imc < 30.0  THEN 'Surpoids'
    ELSE 'Obésité'
  END                                  AS categorie_imc,
  ro.libelle                           AS objectif,
  IF(ag.id IS NOT NULL, 'Oui', 'Non')  AS est_gold,
  pw.solde                             AS solde_portefeuille,
  u.created_at
FROM utilisateurs u
JOIN ref_genres           rg ON u.genre_id       = rg.id
JOIN profils_sante        ps ON u.id             = ps.utilisateur_id
JOIN ref_objectifs        ro ON ps.objectif_id   = ro.id
LEFT JOIN abonnements_gold ag ON u.id = ag.utilisateur_id AND ag.is_actif = 1
JOIN portefeuilles        pw ON u.id             = pw.utilisateur_id;

-- Vue statistiques commandes pour tableau de bord
CREATE OR REPLACE VIEW v_stats_commandes AS
SELECT
  DATE_FORMAT(c.created_at, '%Y-%m') AS mois,
  COUNT(*)                            AS nb_commandes,
  SUM(c.total_ttc)                    AS chiffre_affaires,
  SUM(c.montant_remise)               AS total_remises_gold,
  AVG(c.total_ttc)                    AS panier_moyen
FROM commandes c
GROUP BY DATE_FORMAT(c.created_at, '%Y-%m')
ORDER BY mois DESC;
