# To-Do List par Couches de Difficulté - Projet S4

## 🟢 Phase 1 : La Fondation (Facile)
*Objectif : Mise en place de l'environnement et du visuel.*

- [x] **Base de données (SQL)**
    - [x] Etape 1 : Créer les tables 
      - [x] Tables de references (ref_genres, ref_objectifs, ref_statuts_commande, ref_types_transaction, ref_categories_activite)
      - [x] Tables des utilisateurs (utilisateurs, profils_sante, historique_imc, abonnement_gold)
      - [x] Tables des portefeuilles (portefeuilles, codes_portefeuille, mouvements_portefeuille)
      - [x] Tables des regimes et des activites (regimes, tarifs_regimes, activites_sportives, nourritures, regime_nourritures)
      - [x] Tables des objectifs et leurs relations (objectif_regime, objectif_activites)
      - [x] Tables des commandes (commandes, suivi_commandes)
    - [x] Etape 2 : Exporter le script SQL initial (2026-05-08_tables.sql)

- [ ] **Vues (HTML/CSS)**
    - [ ] Etape 1 : Créer les maquettes du Front Office (Templates & Pages)
      - [x] templates/header.php & footer.php (à créer/vérifier)
      - [x] index-front.php (Accueil)
      - [x] regime.php (Détail/Liste Régime)
      - [x] sport.php (Détail/Liste Sports)
      - [ ] accueil-invite.php (Accueil sans compte)
      - [ ] login.php (Login)
      - [ ] register.php (Inscription)
    - [ ] Etape 2 : Créer les maquettes du Back Office (Admin)
      - [x] dashboard.php (Tableau de bord)
      - [x] admin-regime.php (Liste des regimes)
      - [ ] admin-regime-edit.php (Editer regime)
      - [ ] admin-regime-create.php (Creer regime)
      - [x] admin-sport.php (Liste des activites sportives)
      - [ ] admin-sport-create.php (Creation activite)
      - [ ] admin-sport-edit.php (Modif activite)

- [x] **Données de test**
    - [x] Etape 1 : Scripts de données
      - [x] 2026-05-08_data.sql (ou seeders) avec 5 utilisateurs
      - [x] Insérer 5 régimes et 5 sports
      - [x] Insérer 15 codes de recharge

## 🟡 Phase 2 : Modèles, Controllers & CRUD (Moyenne)
*Objectif : Mettre en place le cœur dynamique MVC de l'application.*

- [x] **Creation des modeles**
    - [x] Etape 1 : Modeles des references
      - [x] Genre.php
      - [x] Objectif.php
      - [x] StatutCommande.php
      - [x] TypeTransaction.php
      - [x] CategorieActivite.php
    - [x] Etape 2 : Modeles utilisateurs & profils
      - [x] Utilisateur.php
      - [x] ProfilSante.php
      - [x] HistoriqueImc.php
      - [x] AbonnementGold.php
    - [x] Etape 3 : Portefeuille
      - [x] Portefeuille.php
      - [x] CodePortefeuille.php
      - [x] MouvementPortefeuille.php
    - [x] Etape 4 : Regimes & nourritures
      - [x] Regime.php
      - [x] Nourriture.php
      - [x] TarifRegime.php
      - [x] RegimeNourriture.php
      - [x] ObjectifRegime.php
      - [x] ObjectifActivite.php
    - [x] Etape 5 : Activites sportives
      - [x] Activite.php
    - [x] Etape 6 : Commandes et Suivis
      - [x] Commande.php
      - [x] SuiviCommande.php

- [x] **Creation des Controllers**
    - [x] Etape 1 : Controllers utilisateurs & profils
      - [x] UtilisateurController.php
      - [x] ProfilSanteController.php
      - [x] AbonnementGoldController.php
    - [x] Etape 2 : Controllers portefeuille
      - [x] CodePortefeuilleController.php
    - [x] Etape 3 : Controllers regimes et nourritures
      - [x] RegimeController.php
      - [x] NourritureController.php
      - [x] TarifRegimeController.php
    - [x] Etape 4 : Activites sportives
      - [x] ActiviteController.php
    - [x] Etape 5 : Commandes
      - [x] CommandeController.php

- [x] **Affichage Back-Office & CRUD Admin**
    - [x] Etape 1 : CRUD Régime
      - [x] Lister les régimes (View + Controller action)
      - [x] Créer un régime (Validation des % viande, poisson, volaille)
      - [x] Modifier un régime 
      - [x] Supprimer un régime
    - [x] Etape 2 : CRUD Sports/Activités
      - [x] Lister les disciplines sportives
      - [x] Créer une activité
      - [x] Modifier une activité
      - [x] Supprimer une activité

## 🟠 Phase 3 : Logique métier (Intermédiaire)
*Objectif : Gérer les inscriptions, comptes et l'argent.*

- [ ] **Inscription Utilisateur (User)**
    - [ ] Etape 1 : Formulaire d'inscription (Infos personnelles)
    - [ ] Etape 2 : Informations de santé (Poids, Taille) pour le profil
- [ ] **Authentification & Sécurité**
    - [ ] Etape 1 : LoginController (Connexion / Déconnexion avec sessions PHP)
    - [ ] Etape 2 : Sécurisation par Filtre/Middleware (Admin vs User)
- [ ] **Porte-monnaie & Transactions**
    - [ ] Etape 1 : Saisie de code de recharge (validation et crédit)
    - [ ] Etape 2 : Achat et validation de l'abonnement "Gold"

## 🔴 Phase 4 : Algorithmes & Calculs (Avancée)
*Objectif : Coder l'intelligence métier de la plateforme.*

- [x] **Moteurs de la plateforme**
    - [x] Etape 1 : Calcul de santé
      - [x] Calcul automatique de l'IMC (IMC = poids / taille²)
      - [x] Mise à jour du profil de santé
    - [x] Etape 2 : Matching (Système de Suggestion)
      - [x] Algorithme de sélection régime + sport selon objectif de l'utilisateur
      - [x] Calcul de la durée estimée pour atteindre le poids cible
    - [ ] Etape 3 : Facturation / Tarifs
      - [ ] Panier total et génération de la commande
      - [ ] Application automatique de la remise 15% pour membres Gold

## 🟣 Phase 5 : Finalisation Technique (Technique)
*Objectif : Rapports, graphiques et livraison.*

- [ ] **Fonctionnalités avancées**
    - [ ] Etape 1 : Dashboard Admin
      - [ ] Générer des graphiques des ventes/utilisateurs
      - [ ] Tableaux récapitulatifs
    - [ ] Etape 2 : Exports
      - [ ] Générer le PDF récapitulatif du programme pour l'utilisateur
- [ ] **Livraison**
    - [ ] Vérifier les routes et Controller
    - [ ] Tests fonctionnels (inscription, achat, matching)
    - [ ] Merge final sur la branche `Main` 