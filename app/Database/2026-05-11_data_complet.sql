-- Fichier complet de données du 2026-05-11
-- Ce fichier contient TOUTES les données de référence et de tests nécessaires, sans dépendre des fichiers précédents.

USE regime_alimentaire;

-- ============================================================
--  1. TABLES DE RÉFÉRENCE (ref_*)
-- ============================================================
INSERT IGNORE INTO ref_genres (id, libelle) VALUES
(1, 'Homme'),
(2, 'Femme'),
(3, 'Autre');

INSERT IGNORE INTO ref_objectifs (id, libelle, description) VALUES
(1, 'Augmenter son poids', 'Programme de prise de masse musculaire ou pondérale'),
(2, 'Réduire son poids', 'Programme de perte de poids progressive et saine'),
(3, 'Atteindre son IMC idéal', 'Maintien ou correction vers un IMC dans la norme (18.5–24.9)');

INSERT IGNORE INTO ref_statuts_commande (id, libelle, description) VALUES
(1, 'En attente', 'Commande créée, paiement non encore confirmé'),
(2, 'Confirmée', 'Paiement reçu, programme en cours de préparation'),
(3, 'Active', 'Programme en cours d\'exécution par l\'utilisateur'),
(4, 'Terminée', 'Programme arrivé à son terme'),
(5, 'Annulée', 'Commande annulée avant activation');

INSERT IGNORE INTO ref_types_transaction (id, libelle, sens) VALUES
(1, 'Recharge code', 'CREDIT'),
(2, 'Achat commande', 'DEBIT'),
(3, 'Remboursement', 'CREDIT'),
(4, 'Correction admin', 'CREDIT');

INSERT IGNORE INTO ref_categories_activite (id, libelle, description) VALUES
(1, 'Cardio', 'Activités d\'endurance : course, vélo, natation'),
(2, 'Musculation', 'Travail de renforcement musculaire avec charges'),
(3, 'Yoga & Pilates', 'Travail de flexibilité, posture et respiration'),
(4, 'Arts martiaux', 'Disciplines de combat et self-défense'),
(5, 'Sports collectifs', 'Football, basketball, volleyball, etc.');

-- ============================================================
--  2. RÉGIMES, NOURRITURES ET Leurs Liaisons
-- ============================================================
INSERT IGNORE INTO regimes (id, nom, description) VALUES
(1, 'Méditerranéen Équilibré', 'Régime inspiré du bassin méditerranéen, riche en poisson et légumes frais.'),
(2, 'Masse Musculaire Pro', 'Programme hyperprotéiné axé sur la viande maigre et la volaille pour la prise de masse.'),
(3, 'Minceur Douce', 'Régime hypocalorique équilibré favorisant le poisson et la volaille pour perdre du poids sainement.'),
(4, 'Protéine Intensive', 'Programme pour sportifs de haut niveau avec forte proportion de viande rouge et blanche.'),
(5, 'Équilibre Santé', 'Régime varié et complet adapté à un retour vers un IMC idéal sans privations excessives.');

INSERT IGNORE INTO nourritures (id, nom, description) VALUES
(1, 'Viande Rouge Maigre', 'Excellente source de fer et de protéines pour la prise de masse.'),
(2, 'Blanc de Dinde/Poulet', 'Volaille très faible en graisses, riche en protéines.'),
(3, 'Poisson Gras (Saumon)', 'Poisson riche en protéines et oméga-3.'),
(4, 'Légumes Verts (Brocoli)', 'Légume vert plein de vitamines et fibres'),
(5, 'Fruits (Pomme)', 'Fruit détoxifiant riche en fibres et antioxydants'),
(6, 'Huile d''olive', 'Matière grasse saine, base du régime méditerranéen');

INSERT IGNORE INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(1, 3, 50.00), -- Méditerranéen: 50% Poisson
(1, 4, 30.00), -- 30% Légumes
(1, 6, 20.00), -- 20% Huile
(2, 1, 45.00), -- Masse Pro: 45% Viande rouge
(2, 2, 40.00), -- 40% Volaille
(2, 3, 15.00), -- 15% Poisson
(3, 2, 45.00), -- Minceur: 45% Volaille
(3, 3, 45.00), -- 45% Poisson
(3, 4, 10.00), -- 10% Légumes
(4, 1, 50.00), -- Protéine Instense: 50% Viande rouge
(4, 2, 40.00), -- 40% Volaille
(4, 3, 10.00); -- 10% Poisson

INSERT IGNORE INTO tarifs_regime (regime_id, duree_jours, prix, variation_poids_kg) VALUES
(1, 7, 25000.00, -0.50), (1, 14, 45000.00, -1.20), (1, 30, 85000.00, -2.50),
(2, 7, 30000.00, 0.80),  (2, 14, 55000.00, 1.80),  (2, 30, 100000.00, 4.00),
(3, 7, 22000.00, -0.70), (3, 14, 40000.00, -1.50), (3, 30, 75000.00, -3.20),
(4, 7, 35000.00, 1.00),  (4, 14, 65000.00, 2.20),  (4, 30, 120000.00, 5.00),
(5, 7, 20000.00, -0.30), (5, 14, 38000.00, -0.80), (5, 30, 70000.00, -1.80);

-- ============================================================
--  3. ACTIVITÉS SPORTIVES
-- ============================================================
INSERT IGNORE INTO activites_sportives (id, categorie_id, nom, description, duree_jours, prix) VALUES
(1, 1, 'Running Débutant', 'Programme de course à pied progressif pour débutants', 14, 15000.00),
(2, 2, 'Musculation Full Body', 'Programme de renforcement musculaire complet', 30, 35000.00),
(3, 3, 'Yoga Minceur', 'Séquences de yoga dynamique favorisant la combustion des graisses', 21, 20000.00),
(4, 1, 'Natation Cardio', 'Programme de natation endurance', 14, 18000.00),
(5, 5, 'Football Fitness', 'Entraînements collectifs axés sur le cardio-training', 30, 25000.00);

-- ============================================================
--  4. LIAISONS OBJECTIFS <-> RÉGIMES / ACTIVITÉS
-- ============================================================
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES 
(1, 2), (1, 4), -- Grossir: Masse Pro, Protéine Intensive
(2, 3), -- Maigrir: Minceur Douce
(3, 1), (3, 5); -- IMC: Méditerranéen, Équilibre

INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES
(1, 2), -- Grossir: Musculation
(2, 1), (2, 3), (2, 4), -- Maigrir: Running, Yoga, Natation
(3, 4), (3, 5); -- IMC: Natation, Football

-- ============================================================
--  5. UTILISATEURS EXEMPLES + ADMIN
-- ============================================================
INSERT IGNORE INTO utilisateurs (id, nom, prenom, email, mot_de_passe_hash, genre_id, date_naissance, is_active) VALUES
(999, 'Admin', 'Super', 'admin@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1980-01-01', 1),
(1, 'Rakoto', 'Andry', 'andry.rakoto@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1995-03-14', 1),
(2, 'Rasoa', 'Miora', 'miora.rasoa@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '1998-07-22', 1),
(3, 'Randria', 'Hery', 'hery.randria@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1990-11-05', 1),
(4, 'Ravoavy', 'Lalao', 'lalao.ravoavy@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '2000-01-30', 1);

INSERT IGNORE INTO profils_sante (utilisateur_id, taille_cm, poids_kg, objectif_id, date_mesure) VALUES
(1, 172.00, 85.00, 2, '2026-05-01'),
(2, 160.00, 48.00, 1, '2026-05-01'),
(3, 175.00, 78.00, 3, '2026-05-01'),
(4, 158.00, 72.00, 2, '2026-05-01');

INSERT IGNORE INTO historique_imc (utilisateur_id, poids_kg, taille_cm, imc, objectif_id, date_mesure) VALUES
(1, 85.00, 172.00, ROUND(85.00 / POW(1.72, 2), 2), 2, '2026-05-01'),
(2, 48.00, 160.00, ROUND(48.00 / POW(1.60, 2), 2), 1, '2026-05-01'),
(3, 78.00, 175.00, ROUND(78.00 / POW(1.75, 2), 2), 3, '2026-05-01'),
(4, 72.00, 158.00, ROUND(72.00 / POW(1.58, 2), 2), 2, '2026-05-01');

INSERT IGNORE INTO portefeuilles (utilisateur_id, solde) VALUES
(1, 50000.00),
(2, 20000.00),
(3, 75000.00),
(4, 5000.00);

-- ============================================================
--  6. CODES DE PORTEFEUILLE
-- ============================================================
INSERT IGNORE INTO codes_portefeuille (code, montant) VALUES
('CODE-10EU-ABCD', 10000.00),
('CODE-10EU-EFGH', 10000.00),
('CODE-20EU-MNOP', 20000.00),
('CODE-20EU-QRST', 20000.00),
('CODE-50EU-CDEF', 50000.00),
('CODE-50EU-GHIJ', 50000.00),
('CODE-100E-STUV', 100000.00),
('CODE-100E-WXYZ', 100000.00);
