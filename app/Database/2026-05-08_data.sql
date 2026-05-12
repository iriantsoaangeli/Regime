INSERT INTO ref_genres (libelle) VALUES
  ('Homme'),
  ('Femme'),
  ('Autre');

INSERT INTO ref_objectifs (libelle, description) VALUES
  ('Augmenter son poids',   'Programme de prise de masse musculaire ou pondérale'),
  ('Réduire son poids',     'Programme de perte de poids progressive et saine'),
  ('Atteindre son IMC idéal','Maintien ou correction vers un IMC dans la norme (18.5–24.9)');

INSERT INTO ref_statuts_commande (libelle, description) VALUES
  ('En attente',  'Commande créée, paiement non encore confirmé'),
  ('Confirmée',   'Paiement reçu, programme en cours de préparation'),
  ('Active',      'Programme en cours d\'exécution par l\'utilisateur'),
  ('Terminée',    'Programme arrivé à son terme'),
  ('Annulée',     'Commande annulée avant activation');

INSERT INTO ref_types_transaction (libelle, sens) VALUES
  ('Recharge code',    'CREDIT'),
  ('Achat commande',   'DEBIT'),
  ('Remboursement',    'CREDIT'),
  ('Correction admin', 'CREDIT');

INSERT INTO ref_categories_activite (libelle, description) VALUES
  ('Cardio',        'Activités d\'endurance : course, vélo, natation'),
  ('Musculation',   'Travail de renforcement musculaire avec charges'),
  ('Yoga & Pilates','Travail de flexibilité, posture et respiration'),
  ('Arts martiaux', 'Disciplines de combat et self-défense'),
  ('Sports collectifs', 'Football, basketball, volleyball, etc.');

-- ------------------------------------------------------------
--  5 Régimes
-- ------------------------------------------------------------
INSERT INTO regimes (nom, description) VALUES
  ('Méditerranéen Équilibré',
   'Régime inspiré du bassin méditerranéen, riche en poisson et légumes frais.'),

  ('Masse Musculaire Pro',
   'Programme hyperprotéiné axé sur la viande maigre et la volaille pour la prise de masse.'),

  ('Minceur Douce',
   'Régime hypocalorique équilibré favorisant le poisson et la volaille pour perdre du poids sainement.'),

  ('Protéine Intensive',
   'Programme pour sportifs de haut niveau avec forte proportion de viande rouge et blanche.'),

  ('Équilibre Santé',
   'Régime varié et complet adapté à un retour vers un IMC idéal sans privations excessives.');

-- Tarifs pour chaque régime (3 durées par régime)
INSERT INTO tarifs_regime (regime_id, duree_jours, prix, variation_poids_kg) VALUES
  -- Méditerranéen Équilibré
  (1,  7,  25000.00, -0.50),
  (1, 14,  45000.00, -1.20),
  (1, 30,  85000.00, -2.50),
  -- Masse Musculaire Pro
  (2,  7,  30000.00,  0.80),
  (2, 14,  55000.00,  1.80),
  (2, 30, 100000.00,  4.00),
  -- Minceur Douce
  (3,  7,  22000.00, -0.70),
  (3, 14,  40000.00, -1.50),
  (3, 30,  75000.00, -3.20),
  -- Protéine Intensive
  (4,  7,  35000.00,  1.00),
  (4, 14,  65000.00,  2.20),
  (4, 30, 120000.00,  5.00),
  -- Équilibre Santé
  (5,  7,  20000.00, -0.30),
  (5, 14,  38000.00, -0.80),
  (5, 30,  70000.00, -1.80);

INSERT INTO activites_sportives (categorie_id, nom, description, duree_jours, prix) VALUES
  (1, 'Running Débutant',
   'Programme de course à pied progressif pour débutants, 30 min par jour.',
   14, 15000.00),

  (2, 'Musculation Full Body',
   'Programme de renforcement musculaire complet, 3 séances de 45 min par semaine.',
   30, 35000.00),

  (3, 'Yoga Minceur',
   'Séquences de yoga dynamique favorisant la combustion des graisses et la souplesse.',
   21, 20000.00),

  (1, 'Natation Cardio',
   'Programme de natation endurance, idéal pour les articulations fragiles.',
   14, 18000.00),

  (5, 'Football Fitness',
   'Entraînements collectifs axés sur le cardio-training à travers des exercices footballistiques.',
   30, 25000.00);

-- ------------------------------------------------------------
--  5 Utilisateurs
--  Mots de passe en clair (pour les tests) :
--    user1..user4 → "Password123!"
--    admin        → "Admin@2026"
--  En production : stocker le hash bcrypt
-- ------------------------------------------------------------
INSERT INTO admins (login, mot_de_passe_hash, nom) VALUES
  ('admin', '$2y$10$JcGjr0qCCFWCnkhhg4i/W.lLj3u3//mm90AfdBgtP8QBAiguDOK9q', 'Administrateur');

INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe_hash, genre_id, date_naissance) VALUES
  ('Rakoto',    'Andry',    'andry.rakoto@mail.mg',    '$2y$12$hashbcrypt_user1_placeholder', 1, '1995-03-14'),
  ('Rasoa',     'Miora',    'miora.rasoa@mail.mg',     '$2y$12$hashbcrypt_user2_placeholder', 2, '1998-07-22'),
  ('Randria',   'Hery',     'hery.randria@mail.mg',    '$2y$12$hashbcrypt_user3_placeholder', 1, '1990-11-05'),
  ('Ravoavy',   'Lalao',    'lalao.ravoavy@mail.mg',   '$2y$12$hashbcrypt_user4_placeholder', 2, '2000-01-30'),
  ('Rabemananjara', 'Tojo', 'tojo.rabemananajara@mail.mg','$2y$12$hashbcrypt_user5_placeholder', 1, '1988-09-18');

-- Profils santé des 5 utilisateurs
INSERT INTO profils_sante (utilisateur_id, taille_cm, poids_kg, objectif_id, date_mesure) VALUES
  (1, 172.00, 85.00, 2, '2026-05-01'),
  (2, 160.00, 48.00, 1, '2026-05-01'),
  (3, 175.00, 78.00, 3, '2026-05-01'),
  (4, 158.00, 72.00, 2, '2026-05-01'),
  (5, 180.00, 95.00, 2, '2026-05-01');

-- Historique IMC initial (copie du profil au démarrage)
INSERT INTO historique_imc (utilisateur_id, poids_kg, taille_cm, imc, objectif_id, date_mesure) VALUES
  (1, 85.00, 172.00, ROUND(85.00 / POW(1.72, 2), 2), 2, '2026-05-01'),
  (2, 48.00, 160.00, ROUND(48.00 / POW(1.60, 2), 2), 1, '2026-05-01'),
  (3, 78.00, 175.00, ROUND(78.00 / POW(1.75, 2), 2), 3, '2026-05-01'),
  (4, 72.00, 158.00, ROUND(72.00 / POW(1.58, 2), 2), 2, '2026-05-01'),
  (5, 95.00, 180.00, ROUND(95.00 / POW(1.80, 2), 2), 2, '2026-05-01');

-- Portefeuilles (un par utilisateur, soldes initiaux variés)
INSERT INTO portefeuilles (utilisateur_id, solde) VALUES
  (1, 50000.00),
  (2, 20000.00),
  (3, 75000.00),
  (4,  5000.00),
  (5, 30000.00);

-- Option Gold pour 2 utilisateurs
INSERT INTO abonnements_gold (utilisateur_id, montant_paye, date_debut, date_fin, is_actif) VALUES
  (1, 50000.00, '2026-04-01', '2027-04-01', 1),
  (3, 50000.00, '2026-03-15', '2027-03-15', 1);

-- ------------------------------------------------------------
--  15 Codes portefeuille
-- ------------------------------------------------------------
INSERT INTO codes_portefeuille (code, montant, expire_le) VALUES
  ('CODE-A1B2-C3D4-E5F6', 10000.00, '2026-12-31 23:59:59'),
  ('CODE-G7H8-I9J0-K1L2', 20000.00, '2026-12-31 23:59:59'),
  ('CODE-M3N4-O5P6-Q7R8', 50000.00, '2026-12-31 23:59:59'),
  ('CODE-S9T0-U1V2-W3X4', 10000.00, '2026-12-31 23:59:59'),
  ('CODE-Y5Z6-A7B8-C9D0', 15000.00, '2026-12-31 23:59:59'),
  ('CODE-E1F2-G3H4-I5J6', 25000.00, '2026-12-31 23:59:59'),
  ('CODE-K7L8-M9N0-O1P2', 30000.00, '2026-12-31 23:59:59'),
  ('CODE-Q3R4-S5T6-U7V8', 10000.00, '2026-12-31 23:59:59'),
  ('CODE-W9X0-Y1Z2-A3B4', 20000.00, '2026-12-31 23:59:59'),
  ('CODE-C5D6-E7F8-G9H0', 50000.00, '2026-12-31 23:59:59'),
  ('CODE-I1J2-K3L4-M5N6', 10000.00, '2026-06-30 23:59:59'),
  ('CODE-O7P8-Q9R0-S1T2', 15000.00, '2026-06-30 23:59:59'),
  ('CODE-U3V4-W5X6-Y7Z8', 25000.00, '2026-06-30 23:59:59'),
  ('CODE-A9B0-C1D2-E3F4', 40000.00, '2026-06-30 23:59:59'),
  ('CODE-G5H6-I7J8-K9L0', 50000.00, '2026-06-30 23:59:59');

-- Utilisation de 3 codes par les utilisateurs
UPDATE codes_portefeuille SET
  is_utilise = 1,
  utilise_par_id = 2,
  utilise_le = '2026-05-02 10:00:00'
WHERE code = 'CODE-A1B2-C3D4-E5F6';

UPDATE codes_portefeuille SET
  is_utilise = 1,
  utilise_par_id = 4,
  utilise_le = '2026-05-03 14:30:00'
WHERE code = 'CODE-G7H8-I9J0-K1L2';

UPDATE codes_portefeuille SET
  is_utilise = 1,
  utilise_par_id = 5,
  utilise_le = '2026-05-04 09:15:00'
WHERE code = 'CODE-M3N4-O5P6-Q7R8';

-- Mouvements portefeuille correspondants aux codes utilisés
INSERT INTO mouvements_portefeuille
  (portefeuille_id, type_transaction_id, code_id, montant, solde_avant, solde_apres, libelle) VALUES
  (2, 1, 1, 10000.00, 10000.00, 20000.00, 'Recharge via code CODE-A1B2-C3D4-E5F6'),
  (4, 1, 2, 20000.00,  5000.00, 25000.00, 'Recharge via code CODE-G7H8-I9J0-K1L2'),
  (5, 1, 3, 50000.00, 30000.00, 80000.00, 'Recharge via code CODE-M3N4-O5P6-Q7R8');

-- Mise à jour des soldes portefeuilles après recharge
UPDATE portefeuilles SET solde = 20000.00 WHERE utilisateur_id = 2;
UPDATE portefeuilles SET solde = 25000.00 WHERE utilisateur_id = 4;
UPDATE portefeuilles SET solde = 80000.00 WHERE utilisateur_id = 5;

-- ------------------------------------------------------------
--  Quelques commandes exemples
-- ------------------------------------------------------------
-- Utilisateur 1 (Gold, -15%) achète Minceur Douce 30j + Running
INSERT INTO commandes
  (utilisateur_id, tarif_regime_id, activite_id, statut_id,
   sous_total, taux_remise, montant_remise, total_ttc, paye_via_portefeuille)
VALUES
  (1, 9, 1, 3,
   90000.00, 15.00, 13500.00, 76500.00, 1);

INSERT INTO suivi_commandes (commande_id, statut_id, commentaire) VALUES
  (1, 1, 'Commande créée'),
  (1, 2, 'Paiement portefeuille confirmé'),
  (1, 3, 'Programme activé');

-- Débit portefeuille utilisateur 1
INSERT INTO mouvements_portefeuille
  (portefeuille_id, type_transaction_id, commande_id, montant, solde_avant, solde_apres, libelle) VALUES
  (1, 2, 1, 76500.00, 50000.00, -26500.00,
   'Achat : Minceur Douce 30j + Running Débutant (remise Gold 15%)');

UPDATE portefeuilles SET solde = -26500.00 WHERE utilisateur_id = 1;

-- Utilisateur 2 achète Méditerranéen 14j (sans activité, sans Gold)
INSERT INTO commandes
  (utilisateur_id, tarif_regime_id, activite_id, statut_id,
   sous_total, taux_remise, montant_remise, total_ttc, paye_via_portefeuille)
VALUES
  (2, 2, NULL, 2,
   45000.00, 0.00, 0.00, 45000.00, 0);

INSERT INTO suivi_commandes (commande_id, statut_id, commentaire) VALUES
  (2, 1, 'Commande créée'),
  (2, 2, 'Paiement reçu');
