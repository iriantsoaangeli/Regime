-- ============================================================
--  BASE DE DONNÉES : Application Régime Alimentaire
--  Technologie : MySQL 8.0+
--  Auteur      : Projet S4
--  Date        : 2026-05-08
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
--  CRÉATION DE LA BASE
-- ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS regime_alimentaire
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE regime_alimentaire;


-- ============================================================
--  TABLES DE RÉFÉRENCE (ref_*)
-- ============================================================

-- ------------------------------------------------------------
--  ref_genres
-- ------------------------------------------------------------
CREATE TABLE ref_genres (
  id      TINYINT      UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(20)  NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_genres_libelle (libelle)
) ENGINE=InnoDB COMMENT='Référentiel des genres utilisateur';

-- ------------------------------------------------------------
--  ref_objectifs
-- ------------------------------------------------------------
CREATE TABLE ref_objectifs (
  id          TINYINT      UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(50)  NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_objectifs_libelle (libelle)
) ENGINE=InnoDB COMMENT='Objectifs de santé disponibles';

-- ------------------------------------------------------------
--  ref_statuts_commande
-- ------------------------------------------------------------
CREATE TABLE ref_statuts_commande (
  id          TINYINT      UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(30)  NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_statuts_libelle (libelle)
) ENGINE=InnoDB COMMENT='États du cycle de vie d\'une commande';

-- ------------------------------------------------------------
--  ref_types_transaction
-- ------------------------------------------------------------
CREATE TABLE ref_types_transaction (
  id      TINYINT     UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL,
  sens    ENUM('CREDIT','DEBIT') NOT NULL COMMENT 'CREDIT = entrée d\'argent, DEBIT = sortie',
  PRIMARY KEY (id),
  UNIQUE KEY uq_types_transaction_libelle (libelle)
) ENGINE=InnoDB COMMENT='Nature des mouvements du portefeuille';

-- ------------------------------------------------------------
--  ref_categories_activite
-- ------------------------------------------------------------
CREATE TABLE ref_categories_activite (
  id          TINYINT     UNSIGNED NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(50) NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_cat_activite_libelle (libelle)
) ENGINE=InnoDB COMMENT='Catégories d\'activités sportives';


-- ============================================================
--  TABLES UTILISATEURS & PROFIL
-- ============================================================

-- ------------------------------------------------------------
--  utilisateurs
-- ------------------------------------------------------------
CREATE TABLE utilisateurs (
  id                INT          UNSIGNED NOT NULL AUTO_INCREMENT,
  nom               VARCHAR(100) NOT NULL,
  prenom            VARCHAR(100) NOT NULL,
  email             VARCHAR(150) NOT NULL,
  mot_de_passe_hash VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt ou argon2',
  genre_id          TINYINT      UNSIGNED NOT NULL,
  date_naissance    DATE,
  is_active         TINYINT(1)   NOT NULL DEFAULT 1,
  created_at        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_utilisateurs_email (email),
  CONSTRAINT fk_util_genre FOREIGN KEY (genre_id) REFERENCES ref_genres(id)
) ENGINE=InnoDB COMMENT='Comptes utilisateurs (authentification + identité)';

-- ------------------------------------------------------------
--  profils_sante
--  Séparée de utilisateurs : données médicales vs identité
-- ------------------------------------------------------------
CREATE TABLE profils_sante (
  id              INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  utilisateur_id  INT      UNSIGNED NOT NULL,
  taille_cm       DECIMAL(5,2) NOT NULL COMMENT 'En centimètres',
  poids_kg        DECIMAL(5,2) NOT NULL COMMENT 'En kilogrammes',
  imc             DECIMAL(5,2) GENERATED ALWAYS AS (poids_kg / POW(taille_cm / 100, 2)) STORED
                  COMMENT 'Calculé automatiquement par MySQL',
  objectif_id     TINYINT  UNSIGNED NOT NULL,
  date_mesure     DATE     NOT NULL DEFAULT (CURRENT_DATE),
  created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_profil_utilisateur (utilisateur_id),
  CONSTRAINT fk_profil_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
  CONSTRAINT fk_profil_objectif    FOREIGN KEY (objectif_id)    REFERENCES ref_objectifs(id)
) ENGINE=InnoDB COMMENT='Données de santé actuelles de l\'utilisateur';

-- ------------------------------------------------------------
--  historique_imc
--  Chaque recalcul IMC est archivé pour les graphes back office
-- ------------------------------------------------------------
CREATE TABLE historique_imc (
  id             INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      UNSIGNED NOT NULL,
  poids_kg       DECIMAL(5,2) NOT NULL,
  taille_cm      DECIMAL(5,2) NOT NULL,
  imc            DECIMAL(5,2) NOT NULL,
  objectif_id    TINYINT  UNSIGNED NOT NULL,
  date_mesure    DATE     NOT NULL,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_himc_utilisateur (utilisateur_id),
  KEY idx_himc_date        (date_mesure),
  CONSTRAINT fk_himc_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
  CONSTRAINT fk_himc_objectif    FOREIGN KEY (objectif_id)    REFERENCES ref_objectifs(id)
) ENGINE=InnoDB COMMENT='Historique des mesures IMC pour suivi de progression';

-- ------------------------------------------------------------
--  abonnements_gold
-- ------------------------------------------------------------
CREATE TABLE abonnements_gold (
  id             INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      UNSIGNED NOT NULL,
  montant_paye   DECIMAL(10,2) NOT NULL,
  date_debut     DATE     NOT NULL,
  date_fin       DATE,
  is_actif       TINYINT(1) NOT NULL DEFAULT 1,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_gold_utilisateur (utilisateur_id),
  KEY idx_gold_actif        (is_actif),
  CONSTRAINT fk_gold_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Souscriptions à l\'option Gold (remise 15%)';


-- ============================================================
--  PORTEFEUILLE
-- ============================================================

-- ------------------------------------------------------------
--  portefeuilles
-- ------------------------------------------------------------
CREATE TABLE portefeuilles (
  id             INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      UNSIGNED NOT NULL,
  solde          DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  updated_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_portefeuille_utilisateur (utilisateur_id),
  CONSTRAINT fk_portefeuille_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Solde courant du portefeuille de chaque utilisateur';

-- ------------------------------------------------------------
--  codes_portefeuille
-- ------------------------------------------------------------
CREATE TABLE codes_portefeuille (
  id             INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  code           VARCHAR(32)  NOT NULL,
  montant        DECIMAL(10,2) NOT NULL,
  is_utilise     TINYINT(1)   NOT NULL DEFAULT 0,
  utilise_par_id INT      UNSIGNED,
  utilise_le     TIMESTAMP    NULL,
  expire_le      TIMESTAMP    NULL,
  created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_code_valeur (code),
  KEY idx_code_utilise      (is_utilise),
  CONSTRAINT fk_code_utilisateur FOREIGN KEY (utilise_par_id) REFERENCES utilisateurs(id)
) ENGINE=InnoDB COMMENT='Codes de recharge du portefeuille (générés par admin)';

-- ------------------------------------------------------------
--  mouvements_portefeuille
--  Chaque ligne archive le solde avant/après pour audit complet
-- ------------------------------------------------------------
CREATE TABLE mouvements_portefeuille (
  id                   INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  portefeuille_id      INT      UNSIGNED NOT NULL,
  type_transaction_id  TINYINT  UNSIGNED NOT NULL,
  commande_id          INT      UNSIGNED,
  code_id              INT      UNSIGNED,
  montant              DECIMAL(10,2) NOT NULL,
  solde_avant          DECIMAL(12,2) NOT NULL,
  solde_apres          DECIMAL(12,2) NOT NULL,
  libelle              TEXT,
  created_at           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_mvt_portefeuille (portefeuille_id),
  KEY idx_mvt_created_at   (created_at),
  CONSTRAINT fk_mvt_portefeuille FOREIGN KEY (portefeuille_id)     REFERENCES portefeuilles(id),
  CONSTRAINT fk_mvt_type         FOREIGN KEY (type_transaction_id) REFERENCES ref_types_transaction(id),
  CONSTRAINT fk_mvt_commande     FOREIGN KEY (commande_id)         REFERENCES commandes(id),
  CONSTRAINT fk_mvt_code         FOREIGN KEY (code_id)             REFERENCES codes_portefeuille(id)
) ENGINE=InnoDB COMMENT='Journal immuable de tous les mouvements de portefeuille';


-- ============================================================
--  RÉGIMES & ACTIVITÉS
-- ============================================================

-- ------------------------------------------------------------
--  regimes
-- ------------------------------------------------------------
CREATE TABLE regimes (
  id           INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  nom          VARCHAR(150) NOT NULL,
  description  TEXT,
  pct_viande   DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  pct_poisson  DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  pct_volaille DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  is_actif     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT chk_pct_total CHECK (ROUND(pct_viande + pct_poisson + pct_volaille, 2) = 100.00)
) ENGINE=InnoDB COMMENT='Catalogue des régimes alimentaires';

-- ------------------------------------------------------------
--  tarifs_regime
--  Un régime peut avoir plusieurs durées et prix
-- ------------------------------------------------------------
CREATE TABLE tarifs_regime (
  id               INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  regime_id        INT      UNSIGNED NOT NULL,
  duree_jours      SMALLINT UNSIGNED NOT NULL,
  prix             DECIMAL(10,2) NOT NULL,
  variation_poids_kg DECIMAL(5,2) NOT NULL COMMENT 'Positif = prise, négatif = perte',
  is_actif         TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_tarif_regime_duree (regime_id, duree_jours),
  CONSTRAINT fk_tarif_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Tarification par durée pour chaque régime';

-- ------------------------------------------------------------
--  activites_sportives
-- ------------------------------------------------------------
CREATE TABLE activites_sportives (
  id           INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  categorie_id TINYINT  UNSIGNED NOT NULL,
  nom          VARCHAR(150) NOT NULL,
  description  TEXT,
  duree_jours  SMALLINT UNSIGNED NOT NULL,
  prix         DECIMAL(10,2) NOT NULL,
  is_actif     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_activite_categorie (categorie_id),
  CONSTRAINT fk_activite_categorie FOREIGN KEY (categorie_id) REFERENCES ref_categories_activite(id)
) ENGINE=InnoDB COMMENT='Catalogue des programmes d\'activité sportive';


-- ============================================================
--  COMMANDES & SUIVI
-- ============================================================

-- ------------------------------------------------------------
--  commandes
-- ------------------------------------------------------------
CREATE TABLE commandes (
  id                   INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  utilisateur_id       INT      UNSIGNED NOT NULL,
  tarif_regime_id      INT      UNSIGNED NOT NULL,
  activite_id          INT      UNSIGNED,
  statut_id            TINYINT  UNSIGNED NOT NULL,
  sous_total           DECIMAL(10,2) NOT NULL COMMENT 'Avant remise',
  taux_remise          DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT 'En % (ex: 15.00)',
  montant_remise       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total_ttc            DECIMAL(10,2) NOT NULL COMMENT 'Montant final payé',
  paye_via_portefeuille TINYINT(1)  NOT NULL DEFAULT 0,
  created_at           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_cmd_utilisateur (utilisateur_id),
  KEY idx_cmd_created_at  (created_at),
  CONSTRAINT fk_cmd_utilisateur FOREIGN KEY (utilisateur_id)  REFERENCES utilisateurs(id),
  CONSTRAINT fk_cmd_tarif       FOREIGN KEY (tarif_regime_id) REFERENCES tarifs_regime(id),
  CONSTRAINT fk_cmd_activite    FOREIGN KEY (activite_id)     REFERENCES activites_sportives(id),
  CONSTRAINT fk_cmd_statut      FOREIGN KEY (statut_id)       REFERENCES ref_statuts_commande(id)
) ENGINE=InnoDB COMMENT='Achats de régimes et activités par les utilisateurs';

-- ------------------------------------------------------------
--  suivi_commandes
--  Audit trail de chaque changement de statut d'une commande
-- ------------------------------------------------------------
CREATE TABLE suivi_commandes (
  id          INT      UNSIGNED NOT NULL AUTO_INCREMENT,
  commande_id INT      UNSIGNED NOT NULL,
  statut_id   TINYINT  UNSIGNED NOT NULL,
  commentaire TEXT,
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_suivi_commande (commande_id),
  CONSTRAINT fk_suivi_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
  CONSTRAINT fk_suivi_statut   FOREIGN KEY (statut_id)   REFERENCES ref_statuts_commande(id)
) ENGINE=InnoDB COMMENT='Historique des changements de statut de chaque commande';


SET FOREIGN_KEY_CHECKS = 1;


-- ============================================================
--  DONNÉES DE RÉFÉRENCE (fixes)
-- ============================================================

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


-- ============================================================
--  DONNÉES MINIMALES
-- ============================================================

-- ------------------------------------------------------------
--  5 Régimes
-- ------------------------------------------------------------
INSERT INTO regimes (nom, description, pct_viande, pct_poisson, pct_volaille) VALUES
  ('Méditerranéen Équilibré',
   'Régime inspiré du bassin méditerranéen, riche en poisson et légumes frais.',
   20.00, 50.00, 30.00),

  ('Masse Musculaire Pro',
   'Programme hyperprotéiné axé sur la viande maigre et la volaille pour la prise de masse.',
   45.00, 15.00, 40.00),

  ('Minceur Douce',
   'Régime hypocalorique équilibré favorisant le poisson et la volaille pour perdre du poids sainement.',
   10.00, 45.00, 45.00),

  ('Protéine Intensive',
   'Programme pour sportifs de haut niveau avec forte proportion de viande rouge et blanche.',
   50.00, 10.00, 40.00),

  ('Équilibre Santé',
   'Régime varié et complet adapté à un retour vers un IMC idéal sans privations excessives.',
   30.00, 35.00, 35.00);

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

-- ------------------------------------------------------------
--  5 Activités sportives
-- ------------------------------------------------------------
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


-- ============================================================
--  VUES UTILES POUR LE BACK OFFICE
-- ============================================================

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

-- ============================================================
--  FIN DU SCRIPT
-- ============================================================
