# To-Do List par Couches de Difficulté - Projet S4

## 🟢 Phase 1 : La Fondation (Facile)
*Objectif : Mise en place de l'environnement et du visuel.*

- [X] **Base de données (SQL)**
    - [X] Créer les tables 
      - [X] tables de references
        - [X] ref_genres, ref_objectifs, ref_statuts_commande, ref_types_transaction, ref_categories_activite
      - [X] tables des utilisateurs
        - [X] utilisateurs, profils_sante, historique_imc, abonnement_gold
      - [X] tables des portefeuilles
        - [X] portefeuilles, codes_portefeuille, mouvements_portefeuille
      - [X] tables des regimes et des activites
        - [X] regimes, tarifs_regimes, activites_sportives, nourritures, regime_nourritures,
      - [X] tables des objectifs et leurs relations
        - [X] objectif_regime, objectif_activites
      - [X] tables des commandes
        - [X] commandes, suivi_commandes
    - [X] Exporter le script SQL initial. 
- [ ] **Vues (HTML/CSS)**
    - [ ] Créer les maquettes statiques du Front Office.
      - [x] Accueil 
      - [x] Regime 
      - [x] Sports
      - [ ] Accueil sans compte
      - [ ] Login
      - [ ] Inscription
    - [ ] Créer les maquettes statiques du Back Office. 
      - [x] Dashboard
      - [x] Liste des regimes
      - [ ] Editer regimer
      - [ ] Creer regime
      - [x] Liste des activites sportives
      - [ ] Creation activite
      - [ ] Modif activite  
- [ ] **Données de test**
    - [x] Insérer manuellement 5 utilisateurs. 
    - [x] Insérer 5 régimes et 5 sports. 
    - [x] Insérer 15 codes de recharge. 

## 🟡 Phase 2 : Connectivité & CRUD (Moyenne)
*Objectif : Rendre l'application dynamique.*

- [ ] **Affichage Back-Office**
    - [ ] Lister les données existantes (Régimes, Sports). 
- [ ] **Formulaires CRUD (Admin)**
    - [ ] Créer/Modifier/Supprimer des régimes (avec les % viande, poisson, volaille). 
    - [ ] Créer/Modifier/Supprimer des activités sportives. 
- [ ] **Formulaires Inscription (User)**
    - [ ] Étape 1 : Infos personnelles. 
    - [ ] Étape 2 : Infos santé (Poids, Taille). 
- [x] **Creation des modeles**
    - [x] Etape 1 : Modeles des references :
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
    - [x] Etape 3 : Portefeille
      - [x] Portefeuille.php
      - [x] CodePortefeuille.php
      - [x] MouvementPortefeuille.php
    - [ ] Etape 4 : Regimes & nourritures
      - [x] Regime.php
      - [x] Nourriture.php
      - [x] TarifRegime.php
      - [ ] RegimeNourriture.php
      - [ ] ObjectifRegime.php
      - [ ] ObjectifActivite.php
    - [ ] Etape 5 : Activites sportives
      - [ ] Activite.php
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
    - [ ] Etape 4 : Activites sportives
      - [ ] ActiviteController.php

## 🟠 Phase 3 : Logique d'Accès & Sécurité (Intermédiaire)
*Objectif : Gérer les comptes et les transactions simples.*

- [ ] **Authentification**
    - [ ] Gestion du Login / Logout avec sessions PHP. 
    - [ ] Sécuriser l'accès au Back-Office (Admin uniquement). 
- [ ] **Porte-monnaie & Paiement**
    - [ ] Logique de saisie et validation de code pour créditer le compte. 
    - [ ] Logique d'achat de l'option "Gold". 

## 🔴 Phase 4 : Algorithmes & Calculs (Avancée)
*Objectif : Coder l'intelligence métier.*

- [ ] **Moteur de Santé**
    - [ ] Calcul automatique de l'IMC ($IMC = poids / taille^2$). 
- [ ] **Système de Suggestion**
    - [ ] Algorithme de sélection régime + sport selon l'objectif choisi. 
    - [ ] Calcul de la durée du programme pour atteindre l'objectif. 
- [ ] **Gestion des Tarifs**
    - [ ] Application de la remise de 15% pour les membres Gold sur les régimes. 

## 🟣 Phase 5 : Finalisation Technique (Technique)
*Objectif : Rapports, graphiques et livraison.*

- [ ] **Statistiques (Admin)**
    - [ ] Générer des graphiques et tableaux croisés sur le Dashboard. 
- [ ] **Export PDF**
    - [ ] Générer le PDF récapitulatif pour l'utilisateur. 
- [ ] **Livraison Finale**
    - [ ] Merge final sur la branche `Main`. 
    - [ ] Vérifier la présence de tous les fichiers (Git, SQL, Liste membres, Suivi tâches). 