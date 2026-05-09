# To-Do List par Couches de Difficulté - Projet S4

## 🟢 Phase 1 : La Fondation (Facile)
*Objectif : Mise en place de l'environnement et du visuel.*

- [ ] **Base de données (SQL)**
    - [ x ] Créer les tables 
    - [ x ] Exporter le script SQL initial. 
- [ ] **Vues (HTML/CSS)**
    - [ ] Créer les maquettes statiques du Front Office.
      - [ x ] Accueil 
      - [ x ] Regime 
      - [ x ] Sports
    - [ ] Créer les maquettes statiques du Back Office. 
- [ ] **Données de test**
    - [ x ] Insérer manuellement 5 utilisateurs. 
    - [ x ] Insérer 5 régimes et 5 sports. 
    - [ x ] Insérer 15 codes de recharge. 

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