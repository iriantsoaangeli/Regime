-- Fichier de données du 2026-05-09

USE regime_alimentaire;

-- ============================================================
-- INSERTIONS DE RÉFÉRENCE (SECURITÉ)
-- ============================================================
INSERT IGNORE INTO ref_genres (id, libelle) VALUES 
(1, 'Homme'), 
(2, 'Femme');

-- ============================================================
--  5 UTILISATEURS
-- ============================================================
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe_hash, genre_id, date_naissance) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1990-05-15'),
('Martin', 'Marie', 'marie.martin@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '1985-11-22'),
('Durand', 'Paul', 'paul.durand@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1992-08-08'),
('Bernard', 'Alice', 'alice.bernard@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '1995-02-14'),
('Dubois', 'Marc', 'marc.dubois@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1988-06-30');

-- ============================================================
--  5 RÉGIMES
-- ============================================================
INSERT INTO regimes (nom, description) VALUES
('Régime Keto (Cétogène)', 'Régime très pauvre en glucides et riche en graisses pour favoriser la cétose.'),
('Régime Végétarien', 'Alimentation excluant la viande et le poisson, riche en nutriments végétaux.'),
('Régime Méditerranéen', 'Inspiré des habitudes alimentaires des pays de la Méditerranée. Sain et équilibré.'),
('Régime Hyperprotéiné', 'Régime riche en protéines, idéal pour la perte de poids tout en conservant la masse musculaire.'),
('Cure Détox 7 jours', 'Régime purifiant basé sur des jus, bouillons et aliments non transformés.');

-- ============================================================
--  15 CODES DE PORTEFEUILLE
-- ============================================================
INSERT INTO codes_portefeuille (code, montant) VALUES
('CODE-10EU-ABCD', 10.00),
('CODE-10EU-EFGH', 10.00),
('CODE-10EU-IJKL', 10.00),
('CODE-20EU-MNOP', 20.00),
('CODE-20EU-QRST', 20.00),
('CODE-20EU-UVWX', 20.00),
('CODE-20EU-YZAB', 20.00),
('CODE-50EU-CDEF', 50.00),
('CODE-50EU-GHIJ', 50.00),
('CODE-50EU-KLMN', 50.00),
('CODE-50EU-OPQR', 50.00),
('CODE-100E-STUV', 100.00),
('CODE-100E-WXYZ', 100.00),
('CODE-100E-ABCD', 100.00),
('CODE-200E-EFGH', 200.00);

-- ============================================================
--  NOURRITURES
-- ============================================================
INSERT INTO nourritures (nom, description) VALUES
('Avocat', 'Riche en bonnes graisses, parfait pour Keto'),
('Blanc de Poulet', 'Riche en protéines, faible en calories'),
('Brocoli', 'Légume vert plein de vitamines et fibres'),
('Saumon', 'Poisson gras riche en oméga-3'),
('Tofu', 'Protéine végétale excellente pour les végétariens'),
('Huile d''olive', 'Matière grasse saine, base du régime méditerranéen'),
('Pomme', 'Fruit détoxifiant riche en fibres et antioxydants'),
('Lentilles', 'Légumineuse excellente source de fer et de protéines végétales');

-- ============================================================
--  REGIME_NOURRITURES (Liaisons et Pourcentages)
-- ============================================================
-- Régime 1 : Keto => Avocat (50%), Saumon (50%)
INSERT INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(1, 1, 50.00),
(1, 4, 50.00);

-- Régime 2 : Végétarien => Tofu (40%), Lentilles (30%), Brocoli (30%)
INSERT INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(2, 5, 40.00),
(2, 8, 30.00),
(2, 3, 30.00);

-- Régime 3 : Méditerranéen => Saumon (50%), Brocoli (30%), Huile d'olive (20%)
INSERT INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(3, 4, 50.00),
(3, 3, 30.00),
(3, 6, 20.00);

-- Régime 4 : Hyperprotéiné => Blanc de Poulet (60%), Tofu (40%)
INSERT INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(4, 2, 60.00),
(4, 5, 40.00);

-- Régime 5 : Cure Détox => Pomme (60%), Brocoli (40%)
INSERT INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(5, 7, 60.00),
(5, 3, 40.00);
