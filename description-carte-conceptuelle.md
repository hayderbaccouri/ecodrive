# Description de la carte conceptuelle — EcoDrive

## Présentation générale

La carte conceptuelle ci-dessous modélise l'architecture fonctionnelle et technique du projet **EcoDrive**, plateforme de showroom et réservation de véhicules électriques en Tunisie. Elle adopte une structure **arborescente à 4 niveaux** : un nœud central, cinq modules principaux, leurs sous-fonctionnalités, une couche transverse, et enfin les technologies qui soutiennent l'ensemble.

---

## 1. Nœud central — EcoDrive

Le point d'entrée de la carte est **EcoDrive**, le nom du projet. Il représente la plateforme dans sa globalité : un site web vitrine + application métier permettant la découverte, la comparaison et la réservation de véhicules électriques et de bornes de recharge.

De ce nœud central partent **5 branches principales**, chacune correspondant à un module fonctionnel du site.

---

## 2. Modules principaux

### 2.1 Accueil (page d'entrée)
La page d'accueil joue le rôle de **vitrine**. Elle contient :
- Un **hero** avec des statistiques clés (nombre de voitures, bornes, essais effectués) pour capter l'attention et crédibiliser la plateforme.
- Un **showroom** présentant 3 voitures vedettes sélectionnées, donnant un aperçu direct du catalogue.
- Une **section bornes** avec 4 cartes des chargeurs Exicom, pour sensibiliser dès l'entrée à l'écosystème de recharge.
- Les sections **À propos** (présentation de la société) et **Contact** (formulaire + coordonnées).

### 2.2 Catalogue
Le catalogue est le **moteur de recherche** du site. Il permet à l'utilisateur de :
- **Filtrer** les véhicules par marque, prix, année et type de moteur.
- **Trier** les résultats par popularité, prix croissant/décroissant ou année.
- Naviguer avec une **pagination** (12 éléments par page).
- Visualiser rapidement les caractéristiques sous forme de **chips** (puissance, batterie, autonomie).

### 2.3 Fiches voitures (pages détail)
Chaque véhicule dispose d'une **page dédiée** organisée en deux colonnes :
- Un **slider** classant automatiquement les photos (extérieur → intérieur → autres) avec un ordre déterministe.
- Une **lightbox** plein écran avec navigation clavier (flèches ← →, Échap) et compteur d'images.
- Une **description** commerciale accompagnée des **specs mises en avant** (autonomie, prix, puissance).
- Une **fiche technique** complète répartie en 4 groupes : moteur & performances, batterie & recharge, dimensions & poids, équipements & confort.

### 2.4 Bornes de recharge
Ce module présente les **4 chargeurs Exicom** (3 à 22 kW) avec pour chacun :
- Une fiche détaillée : puissance, type de courant, connecteurs, applications recommandées.
- Des catégories d'usage : domicile, bureau, flotte professionnelle.
- Un bouton d'appel à l'action menant vers la **réservation**.

### 2.5 Authentification
Système de gestion des utilisateurs avec :
- **Inscription** et **connexion** sécurisées (bcrypt, prepared statements, CSRF).
- **Profil modifiable** (nom, email, mot de passe).
- **Mot de passe oublié** avec token de réinitialisation valable 1 heure.
- Deux **rôles distincts** : client et administrateur, chacun avec ses permissions.

---

## 3. Couche transverse

Trois fonctionnalités traversent l'ensemble des modules :

### 3.1 Administration
Interface réservée aux administrateurs permettant :
- La gestion complète des voitures et bornes **(CRUD)** : ajout, modification, suppression.
- La **gestion des réservations** : consultation, validation, annulation.
- Des **statistiques** dynamiques via Chart.js (réservations par mois, répartition par marque, évolution).
- L'**export** des données en CSV et SQL pour sauvegarde ou analyse externe.

### 3.2 Espace client
Dashboard personnel où le client peut :
- Consulter ses **réservations en cours et passées**.
- **Annuler** une réservation (avec confirmation).
- **Réserver un essai** routier pour un véhicule ou une borne.
- Modifier ses **informations personnelles**.

### 3.3 Pages légales
Pages informatives obligatoires : **Contact**, **Mentions légales**, **Politique de confidentialité**, et une page **404** personnalisée.

---

## 4. Technologies utilisées

La base technique repose sur :

| Technologie | Rôle |
|---|---|
| **PHP 8** | Langage back-end, logique métier, sessions, sécurité |
| **MySQL 8** | Base de données relationnelle (tables : voiture, borne, utilisateur, réservation) |
| **HTML5** | Structure sémantique des pages |
| **CSS3** | Design dark theme, animations, responsive (grid, flexbox) |
| **JavaScript** | Lightbox, slider, burger menu, scroll reveal, back-to-top, toasts |
| **Chart.js** | Graphiques statistiques dans le panneau d'administration |

L'architecture suit le modèle **3-tiers** :
1. **Présentation** (HTML/CSS/JS) — interface utilisateur
2. **Traitement** (PHP) — logique métier et sécurité
3. **Données** (MySQL) — persistance et requêtes

Toutes les communications entre la couche présentation et la couche données passent par PHP avec **requêtes préparées** pour prévenir les injections SQL, et un **token CSRF** pour protéger les formulaires.

---

## 5. Flux de navigation

1. Un visiteur arrive sur **l'accueil** → découvre le concept via le showroom et les statistiques.
2. Il explore le **catalogue** → filtre, trie, trouve un véhicule qui l'intéresse.
3. Il clique sur la **fiche détail** → consulte le slider, la lightbox, la fiche technique.
4. Il **s'inscrit / se connecte** → accède à son espace client.
5. Il **réserve un essai** pour le véhicule choisi.
6. L'**administrateur** reçoit la réservation et la gère depuis son panneau.
7. Le **client** suit l'état de sa réservation depuis son dashboard.

---

## Synthèse

La carte conceptuelle illustre un projet **complet et autonome**, développé sans framework PHP, qui couvre l'ensemble du cycle de vie d'une plateforme e-mobilité : de la **découverte** (catalogue, fiches) à l'**action** (réservation, essai), en passant par la **gestion** (administration, espace client) et la **conformité** (pages légales, sécurité).

Elle montre également la **séparation claire des responsabilités** entre les modules et la **cohérence technologique** de la solution.
