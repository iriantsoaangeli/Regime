-- Fichier de mise à jour des liaisons et données manquantes du 2026-05-11
-- Ce fichier fait le pont entre la nouvelle structure (objectif_regime, objectif_activites, nourritures) 
-- et les concepts originaux.

USE regime_alimentaire;

-- ============================================================
-- 1. CORRECTION / INSERTION DE L'ADMINISTRATEUR
-- ============================================================
-- Ajout de l'utilisateur Admin s'il n'existe pas encore
INSERT IGNORE INTO utilisateurs (id, nom, prenom, email, mot_de_passe_hash, genre_id, date_naissance, is_active) VALUES
(999, 'Admin', 'Super', 'admin@mail.mg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '1980-01-01', 1);

-- ============================================================
-- 2. LIAISONS OBJECTIFS <-> RÉGIMES (objectif_regime)
-- ============================================================
-- Rappel Objectifs : 
-- 1 = Augmenter son poids
-- 2 = Réduire son poids
-- 3 = Atteindre son IMC idéal
-- Rappel Régimes (selon 2026-05-09) : 
-- 1 = Keto, 2 = Végétarien, 3 = Méditerranéen, 4 = Hyperprotéiné, 5 = Cure Détox

-- Augmenter son poids (besoin de protéines et calories)
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (1, 4);
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (1, 3);

-- Réduire son poids (besoin de déficit calorique, perte de graisse)
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (2, 1);
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (2, 5);

-- Atteindre son IMC idéal (besoin d'équilibre)
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (3, 2);
INSERT IGNORE INTO objectif_regime (objectif_id, regime_id) VALUES (3, 3);

-- ============================================================
-- 3. LIAISONS OBJECTIFS <-> ACTIVITÉS (objectif_activites)
-- ============================================================
-- Rappel Activités (selon 2026-05-08) :
-- 1 = Running Débutant, 2 = Musculation Full Body, 3 = Yoga Minceur, 4 = Natation Cardio, 5 = Football Fitness

-- Augmenter son poids
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (1, 2);

-- Réduire son poids
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (2, 1);
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (2, 3);
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (2, 4);

-- Atteindre son IMC idéal
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (3, 4);
INSERT IGNORE INTO objectif_activites (objectif_id, activite_id) VALUES (3, 5);

-- ============================================================
-- 4. NOURRITURES ADDITIONNELLES POUR COMPLÉTER LES POURCENTAGES
-- ============================================================
-- On s'assure d'avoir la conversion des anciennes conceptions "Viande, Poisson, Volaille" dans la nouvelle table
INSERT IGNORE INTO nourritures (id, nom, description) VALUES
(9, 'Viande Rouge Maigre', 'Excellente source de fer et de protéines pour la prise de masse.'),
(10, 'Blanc de Dinde', 'Volaille très faible en graisses, riche en protéines.'),
(11, 'Thon', 'Poisson riche en protéines et oméga-3.');

-- Ajout de ces nourritures à un régime existant (ex: Hyperprotéiné = id 4) pour simuler l'ancienne structure "pct_viande/volaille"
INSERT IGNORE INTO regime_nourritures (regime_id, nourriture_id, pct_nourriture) VALUES
(4, 9, 30.00), -- 30% Viande Rouge
(4, 10, 20.00); -- 20% Blanc de dinde

-- ============================================================
-- 5. TARIFS POUR LES RÉGIMES RÉCENTS (Table tarifs_regime)
-- ============================================================
-- Assurons-nous que tous les régimes ont des tarifs (surtout ceux du 09/05)
INSERT IGNORE INTO tarifs_regime (regime_id, duree_jours, prix, variation_poids_kg) VALUES
(1, 14, 45000.00, -2.00), -- Keto 14 jours
(2, 14, 38000.00, -1.00), -- Végétarien 14 jours
(3, 14, 40000.00, -1.20), -- Méditérranéen 14 jours
(4, 14, 60000.00, +1.50), -- Hyperprotéiné 14 jours
(5, 7, 20000.00, -1.50);  -- Détox 7 jours
