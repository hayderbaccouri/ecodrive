# Cahier des Charges — EcoDrive

## 1. Présentation du projet

**EcoDrive** est une plateforme web de showroom virtuel spécialisé dans les véhicules électriques en Tunisie. Le site permet aux visiteurs de découvrir une sélection de voitures électriques, de consulter leurs fiches techniques détaillées, de réserver des essais routiers, et de découvrir une gamme de bornes de recharge.

- **Porteur du projet** : Hayder Baccouri
- **Type** : Projet de fin de formation 2026
- **Cible** : Grand public tunisien, particuliers et professionnels
- **Site web** : `http://localhost/ecodrive/`

---

## 2. Objectifs

### Objectifs fonctionnels
- Présenter un catalogue de véhicules 100 % électriques disponibles en Tunisie
- Permettre aux visiteurs de comparer les modèles (prix, autonomie, puissance, batterie)
- Offrir un système de réservation d'essai routier en ligne
- Fournir un espace client pour le suivi des réservations
- Permettre à un administrateur de gérer le catalogue, les réservations et les bornes
- Présenter une gamme de bornes de recharge avec fiches détaillées
- Assurer la gestion des comptes utilisateurs (inscription, connexion, mot de passe oublié)

### Objectifs techniques
- Architecture PHP/MySQL sans framework
- Design responsive (mobile, tablette, desktop)
- Thème sombre moderne (vert néon sur fond noir)
- Accessibilité et sécurité (CSRF, protection des données, hachage des mots de passe)
- Export des données (CSV, SQL)

---

## 3. Profils utilisateurs

### 3.1 Visiteur (non connecté)
- Parcourir le catalogue avec filtres (marque, prix, année)
- Consulter les fiches détaillées des voitures (photos, specs, slider, lightbox)
- Consulter les fiches des bornes de recharge
- Voir la page d'accueil et les sections "À propos", "Contact"
- Lire les mentions légales et la politique de confidentialité
- S'inscrire ou se connecter

### 3.2 Client (connecté)
- Tous les droits du visiteur
- Réserver un essai routier (choix du véhicule, date, créneau horaire)
- Consulter et annuler ses réservations depuis son tableau de bord
- Modifier son profil (nom, email, mot de passe)
- Voir l'historique complet de ses essais

### 3.3 Administrateur
- Tous les droits du client
- Gérer les réservations (confirmer, annuler) avec notification email
- Gérer le catalogue voitures (ajout, modification, suppression avec upload d'image)
- Gérer les bornes de recharge (ajout, modification, suppression avec upload d'image)
- Accéder aux statistiques (réservations mensuelles, statuts, top véhicules, top clients)
- Exporter les données (backup SQL, CSV réservations/voitures/bornes)

---

## 4. Arborescence du site

```
Accueil (index.php)
├── Catalogue (php/catalogue.php)
│   ├── Fiche voiture (voitures/*.php) — 14 modèles
│   └── Réservation d'essai (php/reservation.php)
├── Bornes de recharge (ancrée #bornes sur accueil)
│   ├── Exicom Spin Free 3 kW (bornes/ExicomSpinFree3kW.php)
│   ├── Exicom Spin Air 7 kW (bornes/ExicomSpinAir7kW.php)
│   ├── Exicom Spin Air 11 kW (bornes/ExicomSpinAir11kW.php)
│   └── Exicom Spin Air 22 kW (bornes/ExicomSpinAir22kW.php)
├── Espace client
│   ├── Connexion (php/connexion.php)
│   ├── Inscription (php/inscription.php)
│   ├── Mot de passe oublié (php/mot-de-passe-oublie.php)
│   ├── Réinitialisation (php/reinitialiser-mot-de-passe.php)
│   ├── Tableau de bord client (php/tableau-de-bord.php)
│   ├── Mes essais (php/mes-essais.php)
│   └── Profil (php/profil.php)
├── Administration (php/admin.php)
│   └── Export (php/export.php)
├── Contact (pages/contact.php)
├── Mentions légales (pages/mentions-legales.php)
├── Confidentialité (pages/confidentialite.php)
└── Page 404 (404.php)
```

---

## 5. Spécifications fonctionnelles par module

### 5.1 Accueil (index.php)
- Bannière de bienvenue personnalisée (prénom de l'utilisateur connecté)
- Barre d'information "Premier showroom de voitures électriques en Tunisie"
- Header avec logo, navigation, menu utilisateur
- Section Héro : accroche, description, CTA (Explorer / S'inscrire), image mise en avant, statistiques (100 % électrique, 0 émissions CO₂, nombre de modèles)
- Section Showroom : 3 voitures vedettes en grille avec image, nom, prix, lien détail
- Section Bornes de recharge : 4 cartes (3, 7, 11, 22 kW) avec image, puissance, nom, description, prix, tag
- Section À propos : mission, valeurs (4 items)
- Section Contact : formulaire avec prénom, email, modèle, message + coordonnées
- Footer : logo, copyright, liens légaux
- Bouton retour en haut

### 5.2 Catalogue (php/catalogue.php)
- Barre de filtres : recherche texte, marque (select), prix min/max, année, tri (popularité, prix croissant/décroissant, année), bouton Réinitialiser
- Grille de cartes (responsive 3-2-1 colonnes)
  - Image du véhicule
  - Nom (marque + modèle)
  - Année
  - Prix en DT
  - Puce specs (puissance, batterie, autonomie)
  - Boutons "Voir détails" + "Réserver un essai" (ou "Connectez-vous" si non connecté)
- Pagination (12 par page)
- État vide si aucun résultat

### 5.3 Fiche voiture (voitures/*.php) — 14 modèles
- Slider d'images (car_slider.php)
  - Photos triées : extérieur puis intérieur, classées par numéro
  - Flèches de navigation `‹` `›`
  - Points indicateurs
  - Click sur l'image → lightbox plein écran
- Barre de prix + bouton "Réserver un essai"
- Aperçu 2 colonnes
  - Colonne gauche : description textuelle
  - Colonne droite : cartes specs (Puissance, Batterie, Autonomie, 0-100 km/h, Poids)
- Section "Fiche technique"
  - Grille 2 colonnes de groupes de specs (Motorisation, Batterie & Autonomie, Recharge, Dimensions)
  - Barre visuelle de batterie avec animation au scroll
- Section CTA "Essayez la [Modèle]" → lien vers réservation
- Lightbox : overlay plein écran avec navigation clavier (← →), compteur 1/N, fermeture (Esc, clic hors image, ×)

### 5.4 Système de réservation (php/reservation.php)
- Formulaire protégé CSRF
- Champs : voiture (select), date, heure début, heure fin, notes
- Validation :
  - Voiture doit exister
  - Date >= aujourd'hui
  - Heure fin > heure début
  - Pas de chevauchement avec une réservation existante (même voiture, même date, même créneau)
- Statut initial : "pending"
- Page accessible uniquement aux clients connectés

### 5.5 Tableau de bord client (php/tableau-de-bord.php)
- Message de bienvenue personnalisé
- Cartes récapitulatives : En attente, Confirmés, Annulés, Total
- Graphiques Chart.js : barres mensuelles + donut des statuts
- Tableau des réservations : voiture, date, horaire, statut (avec couleur), actions (annuler si pending)

### 5.6 Administration (php/admin.php)
- Accès réservé au rôle "admin"
- Gestion des réservations
  - Tableau paginé avec nom client, email, voiture, date, horaire, statut
  - Boutons Confirmer / Annuler avec envoi d'email au client
  - Filtrage par statut
- Gestion des voitures (CRUD)
  - Formulaire d'ajout : marque, modèle, année, prix, description, image (upload), page détail
  - Liste avec modification inline et suppression
  - Upload d'images (jpg, png, webp, avif)
- Gestion des bornes (CRUD)
  - Même pattern que les voitures
- Statistiques
  - Graphique : réservations par mois (barres)
  - Graphique : répartition par statut (donut)
  - Graphique : top 5 voitures les plus réservées (barres horizontales)
  - Tableau : top clients (nombre de réservations)
- Export
  - Backup SQL complet
  - CSV Réservations, Voitures, Bornes

### 5.7 Bornes de recharge (bornes/*.php) — 4 modèles
- Fil d'Ariane
- Hero 2 colonnes : image produit (gauche) + informations (droite)
  - Puissance en grand format
  - Prix
  - Liste de specs (type, phases, câble, protection, usage)
- Section "Comment ça marche" : 3 étapes
- Tableau des specs complet
- Grille de compatibilité (4 colonnes)
- CTA "Réserver une borne" → page réservation

### 5.8 Authentification
- Inscription : nom, email, mot de passe, confirmation ; vérification email unique
- Connexion : email + mot de passe ; création de session ; redirection selon rôle
- Déconnexion : destruction complète de la session
- Mot de passe oublié : token 32 bytes, expiration 1h, envoi par email
- Profil : modification nom/email/mot de passe avec vérification d'unicité

### 5.9 Pages légales
- Mentions légales : éditeur, propriété intellectuelle, responsabilité, collecte de données, cookies, loi applicable (Tunisie)
- Confidentialité : 12 articles couvrant collecte, utilisation, partage, sécurité, cookies, conservation, droits utilisateur (accès, rectification, effacement, portabilité, opposition)

### 5.10 Lightbox (composant partagé)
- Déclenché par click sur le slider
- Overlay plein écran (fond noir 92 %)
- Image centrée avec animation d'entrée (scale)
- Navigation : flèches `‹` `›` + touches clavier ← → + compteur "X / N"
- Fermeture : clic sur overlay, bouton ×, touche Esc
- Animation de sortie (fade + scale)

---

## 6. Spécifications techniques

### 6.1 Environnement
- **Serveur** : Apache (XAMPP)
- **PHP** : 8.x (procédural avec mysqli)
- **Base de données** : MySQL 8 (InnoDB, utf8mb4)
- **Frontend** : HTML5, CSS3, JavaScript (vanilla)
- **Graphiques** : Chart.js 4.x (CDN)
- **Polices** : Google Fonts (Cormorant Garamond + DM Sans)

### 6.2 Base de données — 4 tables

#### utilisateur
| Champ | Type | Contraintes |
|---|---|---|
| id_utilisateur | INT UNSIGNED | PK, AUTO_INCREMENT |
| nom | VARCHAR(255) | NOT NULL |
| email | VARCHAR(255) | NOT NULL, UNIQUE |
| mot_de_passe | VARCHAR(255) | NOT NULL (bcrypt) |
| role | ENUM('client','admin') | DEFAULT 'client' |
| reset_token | VARCHAR(64) | NULLABLE |
| reset_expires | DATETIME | NULLABLE |
| created_at | DATETIME | DEFAULT CURRENT_TIMESTAMP |

#### voiture
| Champ | Type | Contraintes |
|---|---|---|
| id_voiture | INT UNSIGNED | PK, AUTO_INCREMENT |
| marque | VARCHAR(100) | NOT NULL |
| modele | VARCHAR(100) | NOT NULL |
| annee | YEAR | NOT NULL |
| prix | DOUBLE | NOT NULL DEFAULT 0 |
| description | TEXT | NULLABLE |
| image | VARCHAR(255) | NULLABLE |
| details_page | VARCHAR(255) | NULLABLE |
| created_at | DATETIME | DEFAULT CURRENT_TIMESTAMP |

#### reservation
| Champ | Type | Contraintes |
|---|---|---|
| id_reservation | INT UNSIGNED | PK, AUTO_INCREMENT |
| utilisateur_id | INT UNSIGNED | FK → utilisateur (CASCADE) |
| voiture_id | INT UNSIGNED | FK → voiture (CASCADE) |
| date_essai | DATE | NOT NULL |
| heure_debut | TIME | NOT NULL |
| heure_fin | TIME | NOT NULL |
| statut | ENUM('pending','confirmed','cancelled') | DEFAULT 'pending' |
| notes | TEXT | NULLABLE |
| created_at | DATETIME | DEFAULT CURRENT_TIMESTAMP |

#### borne
| Champ | Type | Contraintes |
|---|---|---|
| id_borne | INT UNSIGNED | PK, AUTO_INCREMENT |
| nom | VARCHAR(100) | NOT NULL |
| modele | VARCHAR(100) | NOT NULL |
| puissance | VARCHAR(50) | NOT NULL |
| prix | DOUBLE | NOT NULL DEFAULT 0 |
| description | TEXT | NULLABLE |
| image | VARCHAR(255) | NULLABLE |
| details_page | VARCHAR(255) | NULLABLE |
| created_at | DATETIME | DEFAULT CURRENT_TIMESTAMP |

### 6.3 Données initiales
- 1 administrateur : admin@ecodrive.com / admin123
- 1 client test : client@ecodrive.com / client123
- 14 voitures électriques
- 4 bornes de recharge Exicom

### 6.4 Sécurité
- Mots de passe hachés avec `password_hash()` (bcrypt)
- Protection CSRF via token en session sur tous les formulaires critiques
- Préparation des requêtes SQL (prepared statements)
- Échappement HTML avec `htmlspecialchars()` à l'affichage
- Headers de sécurité dans `.htaccess` (X-Content-Type-Options, X-Frame-Options, etc.)
- Blocage des fichiers sensibles (`.sql`, `.md`, `.env`) dans `.htaccess`
- Aucune énumération d'email sur le formulaire "mot de passe oublié"
- Vérification de rôle avant accès à l'administration

### 6.5 Architecture frontend
- CSS personnalisé (7 fichiers) : style.css, header.css, catalogue.css, voitures.css, bornes.css, dashboard.css, animations.css
- JavaScript vanilla (1 fichier) : app.js (247 lignes, 12 fonctionnalités)
- Variables CSS personnalisées (design tokens)
- Animations au scroll via IntersectionObserver
- Design responsive : 4 breakpoints (900px, 700px, 420px)
- Thème sombre (noir, gris foncé, vert néon #00e5a0)

---

## 7. Contenu éditorial

### 7.1 Voitures (14 modèles)

| # | Modèle | Puissance | Batterie | Autonomie | Prix (DT) |
|---|---|---|---|---|---|
| 1 | Audi A6 Sportback e-tron | 367 ch | 100 kWh | 757 km | 239 000 |
| 2 | BMW iX3 | 469 ch | 108,7 kWh | 805 km | 265 000 |
| 3 | BYD Atto 3 | 313 ch | 74,8 kWh | 510 km | 149 000 |
| 4 | BYD Dolphin Surf | 156 ch | 43,2 kWh | 310 km | 89 000 |
| 5 | Geely EX2 | 115 ch | 39,4 kWh | 325 km | 79 000 |
| 6 | Kia EV3 | 204 ch | 81,4 kWh | 605 km | 159 000 |
| 7 | Mercedes Classe C 2026 | 489 ch | 94,5 kWh | 753 km | 289 000 |
| 8 | Mercedes EQC 400 | 408 ch | 80 kWh | 432 km | 219 000 |
| 9 | MG 4 Urban | 149 ch | 43 kWh | 335 km | 99 000 |
| 10 | Peugeot e-208 | 156 ch | 54 kWh | 433 km | 109 000 |
| 11 | Porsche Taycan | 408 ch | 89 kWh | 503 km | 359 000 |
| 12 | Tesla Model 3 | — | — | 702 km | 189 000 |
| 13 | Tesla Model S Plaid | 1 020 ch | — | 600 km | 459 000 |
| 14 | Toyota bZ4X | 227 ch | 73,1 kWh | 573 km | 169 000 |

### 7.2 Bornes (4 modèles)

| Modèle | Puissance | Prix (DT) | Usage |
|---|---|---|---|
| Exicom Spin Free | 3 kW | 1 290 | Portable |
| Exicom Spin Air | 7,4 kW | 2 490 | Résidentiel |
| Exicom Spin Air | 11 kW | 3 290 | Semi-professionnel |
| Exicom Spin Air | 22 kW | 4 490 | Professionnel |

---

## 8. Contraintes et limites

### 8.1 Contraintes techniques
- Environnement XAMPP (localhost), non déployé en production
- Fonction mail PHP non configurée (emails non envoyés en local)
- Pas de framework CSS ou JS (vanilla uniquement)
- Images stockées localement dans `/images/`

### 8.2 Évolutions possibles
- Internationalisation (support anglais / arabe)
- Paiement en ligne pour les réservations
- API REST pour application mobile
- Mode clair (alternance thème)
- Notifications en temps réel (WebSocket)
- Upload d'avis clients
- Comparateur de véhicules
- Géolocalisation des bornes sur carte interactive
- Intégration CRM

---

## 9. Annexes

### 9.1 Fichiers du projet (38 fichiers PHP, 7 CSS, 1 JS)

```
ecodrive/
├── .htaccess
├── 404.php
├── index.php
├── base-de-donnees/
│   ├── create_ecodrive_db.sql
│   ├── migrate_images_subdirs.sql
│   └── migrate_v2.sql
├── bornes/
│   ├── ExicomSpinAir7kW.php
│   ├── ExicomSpinAir11kW.php
│   ├── ExicomSpinAir22kW.php
│   └── ExicomSpinFree3kW.php
├── css/
│   ├── animations.css
│   ├── bornes.css
│   ├── catalogue.css
│   ├── dashboard.css
│   ├── header.css
│   ├── style.css
│   └── voitures.css
├── images/
│   └── (15 sous-répertoires par modèle + bornes)
├── js/
│   └── app.js
├── pages/
│   ├── contact.php
│   ├── mentions-legales.php
│   └── confidentialite.php
├── php/
│   ├── _update_slider.php
│   ├── admin.php
│   ├── car_slider.php
│   ├── catalogue.php
│   ├── configuration.php
│   ├── connexion.php
│   ├── deconnexion.php
│   ├── export.php
│   ├── inscription.php
│   ├── mes-essais.php
│   ├── mot-de-passe-oublie.php
│   ├── profil.php
│   ├── reinitialiser-mot-de-passe.php
│   ├── reservation.php
│   └── tableau-de-bord.php
└── voitures/
    ├── Audi-A6-Sportback-e-tron.php
    ├── BMW-iX3.php
    ├── BYD-Atto-3.php
    ├── BYD-Dolphin.php
    ├── Geely-EX2.php
    ├── kia-ev3.php
    ├── mercedes-classe-c-2026.php
    ├── mercedes-EQC.php
    ├── mg4.php
    ├── Peugeot-e-208.php
    ├── Porsche-Taycan.php
    ├── Tesla-Model-3.php
    ├── Tesla-Model-S-Plaid.php
    └── toyota-bz4x.php
```

### 9.2 Schéma de navigation
```
[Visiteur]
   │
   ├── Accueil ──┬── Catalogue ──┬── [Filtres] ── Fiche voiture ──┬── Réservation
   │             │               │                                └── Lightbox
   │             │               └── Pagination
   │             ├── Bornes ── Fiche borne
   │             ├── Contact
   │             ├── Mentions légales
   │             ├── Confidentialité
   │             ├── Connexion
   │             └── Inscription
   │
[Client]
   │
   ├── (Visiteur) +
   ├── Réservation d'essai
   ├── Tableau de bord ──┬── Graphiques
   │                     └── Mes réservations ── [Annuler]
   ├── Mes essais
   └── Profil ── [Modifier]
   │
[Administrateur]
   │
   ├── (Client) +
   └── Administration ──┬── Réservations ── [Confirmer/Annuler]
                        ├── Voitures ── [Ajouter/Modifier/Supprimer]
                        ├── Bornes ── [Ajouter/Modifier/Supprimer]
                        ├── Statistiques ── Graphiques
                        └── Export ── CSV / SQL
```
