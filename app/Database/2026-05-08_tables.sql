SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS regime_alimentaire
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE regime_alimentaire;


-- ============================================================
--  TABLES DE RÉFÉRENCE (ref_*)
-- ============================================================
CREATE TABLE ref_genres (
  id      TINYINT      NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(20)  NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_genres_libelle (libelle)
);

-- ------------------------------------------------------------
--  ref_objectifs
-- ------------------------------------------------------------
CREATE TABLE ref_objectifs (
  id          TINYINT      NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(50)  NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_objectifs_libelle (libelle)
);

-- ------------------------------------------------------------
--  ref_statuts_commande
-- ------------------------------------------------------------
CREATE TABLE ref_statuts_commande (
  id          TINYINT      NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(30)  NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_statuts_libelle (libelle)
);

-- ------------------------------------------------------------
--  ref_types_transaction
-- ------------------------------------------------------------
CREATE TABLE ref_types_transaction (
  id      TINYINT     NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(30) NOT NULL,
  sens    ENUM('CREDIT','DEBIT') NOT NULL COMMENT 'CREDIT = entrée d\'argent, DEBIT = sortie',
  PRIMARY KEY (id),
  UNIQUE KEY uq_types_transaction_libelle (libelle)
);

-- ------------------------------------------------------------
--  ref_categories_activite
-- ------------------------------------------------------------
CREATE TABLE ref_categories_activite (
  id          TINYINT     NOT NULL AUTO_INCREMENT,
  libelle     VARCHAR(50) NOT NULL,
  description TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_cat_activite_libelle (libelle)
);


-- ============================================================
--  TABLES UTILISATEURS & PROFIL
-- ============================================================

-- ------------------------------------------------------------
--  utilisateurs
-- ------------------------------------------------------------
CREATE TABLE utilisateurs (
  id                INT          NOT NULL AUTO_INCREMENT,
  nom               VARCHAR(100) NOT NULL,
  prenom            VARCHAR(100) NOT NULL,
  email             VARCHAR(150) NOT NULL,
  mot_de_passe_hash VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt ou argon2',
  genre_id          TINYINT      NOT NULL,
  date_naissance    DATE,
  is_active         TINYINT(1)   NOT NULL DEFAULT 1,
  created_at        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_utilisateurs_email (email),
  CONSTRAINT fk_util_genre FOREIGN KEY (genre_id) REFERENCES ref_genres(id)
);

-- ------------------------------------------------------------
--  profils_sante
--  Séparée de utilisateurs : données médicales vs identité
-- ------------------------------------------------------------
CREATE TABLE profils_sante (
  id              INT      NOT NULL AUTO_INCREMENT,
  utilisateur_id  INT      NOT NULL,
  taille_cm       DECIMAL(5,2) NOT NULL COMMENT 'En centimètres',
  poids_kg        DECIMAL(5,2) NOT NULL COMMENT 'En kilogrammes',
  imc             DECIMAL(5,2)
                  COMMENT 'Calculé automatiquement par MySQL',
  objectif_id     TINYINT  NOT NULL,
  date_mesure     DATE     NOT NULL DEFAULT (CURRENT_DATE),
  created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_profil_utilisateur (utilisateur_id),
  CONSTRAINT fk_profil_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
  CONSTRAINT fk_profil_objectif    FOREIGN KEY (objectif_id)    REFERENCES ref_objectifs(id)
);

-- ------------------------------------------------------------
--  historique_imc
--  Chaque recalcul IMC est archivé pour les graphes back office
-- ------------------------------------------------------------
CREATE TABLE historique_imc (
  id             INT      NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      NOT NULL,
  poids_kg       DECIMAL(5,2) NOT NULL,
  taille_cm      DECIMAL(5,2) NOT NULL,
  imc            DECIMAL(5,2) NOT NULL,
  objectif_id    TINYINT  NOT NULL,
  date_mesure    DATE     NOT NULL,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_himc_utilisateur (utilisateur_id),
  KEY idx_himc_date        (date_mesure),
  CONSTRAINT fk_himc_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
  CONSTRAINT fk_himc_objectif    FOREIGN KEY (objectif_id)    REFERENCES ref_objectifs(id)
);

-- ------------------------------------------------------------
--  abonnements_gold
-- ------------------------------------------------------------
CREATE TABLE abonnements_gold (
  id             INT      NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      NOT NULL,
  montant_paye   DECIMAL(10,2) NOT NULL,
  date_debut     DATE     NOT NULL,
  date_fin       DATE,
  is_actif       TINYINT(1) NOT NULL DEFAULT 1,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_gold_utilisateur (utilisateur_id),
  KEY idx_gold_actif        (is_actif),
  CONSTRAINT fk_gold_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);


-- ============================================================
--  PORTEFEUILLE
-- ============================================================

-- ------------------------------------------------------------
--  portefeuilles
-- ------------------------------------------------------------
CREATE TABLE portefeuilles (
  id             INT      NOT NULL AUTO_INCREMENT,
  utilisateur_id INT      NOT NULL,
  solde          DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  updated_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_portefeuille_utilisateur (utilisateur_id),
  CONSTRAINT fk_portefeuille_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
--  codes_portefeuille
-- ------------------------------------------------------------
CREATE TABLE codes_portefeuille (
  id             INT      NOT NULL AUTO_INCREMENT,
  code           VARCHAR(32)  NOT NULL,
  montant        DECIMAL(10,2) NOT NULL,
  is_utilise     TINYINT(1)   NOT NULL DEFAULT 0,
  utilise_par_id INT     ,
  utilise_le     TIMESTAMP    NULL,
  expire_le      TIMESTAMP    NULL,
  created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_code_valeur (code),
  KEY idx_code_utilise      (is_utilise),
  CONSTRAINT fk_code_utilisateur FOREIGN KEY (utilise_par_id) REFERENCES utilisateurs(id)
);

-- ------------------------------------------------------------
--  mouvements_portefeuille
--  Chaque ligne archive le solde avant/après pour audit complet
-- ------------------------------------------------------------
CREATE TABLE mouvements_portefeuille (
  id                   INT      NOT NULL AUTO_INCREMENT,
  portefeuille_id      INT      NOT NULL,
  type_transaction_id  TINYINT  NOT NULL,
  commande_id          INT     ,
  code_id              INT     ,
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
);


-- ============================================================
--  RÉGIMES & ACTIVITÉS
-- ============================================================

-- ------------------------------------------------------------
--  regimes
-- ------------------------------------------------------------
CREATE TABLE regimes (
  id           INT      NOT NULL AUTO_INCREMENT,
  nom          VARCHAR(150) NOT NULL,
  description  TEXT,
  pct_viande   DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  pct_poisson  DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  pct_volaille DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  is_actif     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
);

-- ------------------------------------------------------------
--  tarifs_regime
--  Un régime peut avoir plusieurs durées et prix
-- ------------------------------------------------------------
CREATE TABLE tarifs_regime (
  id               INT      NOT NULL AUTO_INCREMENT,
  regime_id        INT      NOT NULL,
  duree_jours      SMALLINT NOT NULL,
  prix             DECIMAL(10,2) NOT NULL,
  variation_poids_kg DECIMAL(5,2) NOT NULL COMMENT 'Positif = prise, négatif = perte',
  is_actif         TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_tarif_regime_duree (regime_id, duree_jours),
  CONSTRAINT fk_tarif_regime FOREIGN KEY (regime_id) REFERENCES regimes(id) ON DELETE CASCADE
);

-- ------------------------------------------------------------
--  activites_sportives
-- ------------------------------------------------------------
CREATE TABLE activites_sportives (
  id           INT      NOT NULL AUTO_INCREMENT,
  categorie_id TINYINT  NOT NULL,
  nom          VARCHAR(150) NOT NULL,
  description  TEXT,
  duree_jours  SMALLINT NOT NULL,
  prix         DECIMAL(10,2) NOT NULL,
  is_actif     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_activite_categorie (categorie_id),
  CONSTRAINT fk_activite_categorie FOREIGN KEY (categorie_id) REFERENCES ref_categories_activite(id)
);


-- ============================================================
--  COMMANDES & SUIVI
-- ============================================================

-- ------------------------------------------------------------
--  commandes
-- ------------------------------------------------------------
CREATE TABLE commandes (
  id                   INT      NOT NULL AUTO_INCREMENT,
  utilisateur_id       INT      NOT NULL,
  tarif_regime_id      INT      NOT NULL,
  activite_id          INT     ,
  statut_id            TINYINT  NOT NULL,
  sous_total           DECIMAL(10,2) NOT NULL COMMENT 'Avant remise',
  taux_remise          DECIMAL(5,2)  NOT NULL DEFAULT 0.00 COMMENT 'En % (ex: 15.00)',
  montant_remise       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total_ttc            DECIMAL(10,2) NOT NULL COMMENT 'Montant final payé',
  paye_via_portefeuille TINYINT(1)  NOT NULL DEFAULT 0,
  created_at           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_cmd_utilisateur (utilisateur_id),
  KEY idx_cmd_created_at  (created_at),
  CONSTRAINT fk_cmd_utilisateur FOREIGN KEY (utilisateur_id)  REFERENCES utilisateurs(id),
  CONSTRAINT fk_cmd_tarif       FOREIGN KEY (tarif_regime_id) REFERENCES tarifs_regime(id),
  CONSTRAINT fk_cmd_activite    FOREIGN KEY (activite_id)     REFERENCES activites_sportives(id),
  CONSTRAINT fk_cmd_statut      FOREIGN KEY (statut_id)       REFERENCES ref_statuts_commande(id)
);

-- ------------------------------------------------------------
--  suivi_commandes
--  Audit trail de chaque changement de statut d'une commande
-- ------------------------------------------------------------
CREATE TABLE suivi_commandes (
  id          INT      NOT NULL AUTO_INCREMENT,
  commande_id INT      NOT NULL,
  statut_id   TINYINT  NOT NULL,
  commentaire TEXT,
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_suivi_commande (commande_id),
  CONSTRAINT fk_suivi_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
  CONSTRAINT fk_suivi_statut   FOREIGN KEY (statut_id)   REFERENCES ref_statuts_commande(id)
);

SET FOREIGN_KEY_CHECKS = 1;
