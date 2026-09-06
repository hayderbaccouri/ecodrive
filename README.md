# EcoDrive — Showroom electrique Tunisie

Site vitrine et catalogue pour un concessionnaire de vehicules electriques en Tunisie.
14 modeles de voitures, bornes de recharge Exicom, reservation d'essais et panneau administrateur.

---

## Stack

- PHP 8+ (vanilla, pas de framework)
- MySQL 8
- XAMPP (Apache + MySQL)
- CSS/JS vanilla, HTML semantique

---

## Mise en place

1. Cloner le depot dans `C:\xampp\htdocs\ecodrive`
2. Copier `.env.example` en `.env` et adapter les identifiants MySQL
3. Creer la base de donnees puis importer le script :
   ```
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS ecodrive CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   mysql -u root -p ecodrive < base-de-donnees/ecodrive.sql
   ```
4. Demarrer Apache et MySQL dans le panneau XAMPP
5. Ouvrir `http://localhost/ecodrive`

---

## Identifiants par defaut

| Role  | Email                  | Mot de passe |
|-------|------------------------|--------------|
| Admin | admin@ecodrive.com     | dans le SQL  |
| Client| client@ecodrive.com    | dans le SQL  |

Les mots de passe hashes se trouvent dans `base-de-donnees/ecodrive.sql`, table `utilisateur` (ligne ~246).

---

## Structure du projet

```
ecodrive/
  index.php              — page d'accueil
  404.php                — page introuvable
  sitemap.php            — sitemap XML dynamique (voitures + bornes)
  .env.example           — modele de configuration
  .htaccess              — rewrites Apache
  voitures/              — pages detail par modele (14 fichiers)
  bornes/                — pages detail bornes de recharge (stubs auto-generes depuis l'admin)
  pages/                 — pages statiques (contact, CGV, CGU, mentions legales, confidentialite)
  php/                   — logique applicative
    bootstrap.php        — init session, autoload, DB, CSRF, rate limiting
    connexion.php        — formulaire de connexion
    inscription.php      — creation de compte
    catalogue.php        — listing voitures
    reservation.php      — reservation d'essai
    confirmation-reservation.php
    mes-essais.php       — historique des essais
    profil.php           — edition profil
    tableau-de-bord.php  — tableau de bord utilisateur
    admin.php            — panneau administrateur (reservations, stats, voitures, bornes, messages, newsletter, utilisateurs)
    export.php           — export CSV / backup SQL
    car_slider.php       — carrousel voitures
    car_data.php         — helper pages detail (data.php + fallback base de donnees)
    configuration.php    — config centralisee
    partials/            — header, footer, meta, jsonld
  css/                   — feuilles de style
  js/                    — scripts cote client
  images/                — photos voitures et bornes
  base-de-donnees/       — script SQL consolidé
  ecodrive-private/logs/ — journaux applicatifs hors de la racine publique
```

---

## Fonctionnalites

- **Catalogue** — 14 voitures electriques avec pages detail (prix, specs, autonomie), filtres et pagination (12 par page)
- **Bornes de recharge** — 4 bornes Exicom (3 kW a 22 kW) avec fiches produit
- **Reservation d'essais** — prise de rendez-vous en ligne avec creneaux horaires
- **Compte utilisateur** — inscription, connexion, profil, historique des essais
- **Panneau admin** — gestion des utilisateurs, voitures (dont mise en avant accueil), bornes, reservations, messages de contact, abonnes newsletter, export CSV
- **Journal d'audit** — chaque action admin (voitures, bornes, reservations, utilisateurs) est tracee dans `admin_audit`, consultable dans l'onglet « Audit » avec pagination et export CSV
- **Pages detail auto-generees** — une voiture ajoutee depuis l'admin sans page detail recoit un stub `voitures/<slug>.php` ; une borne ajoutee recoit `bornes/<slug>.php` ; le template `car-page.php` / `borne-page.php` retombe automatiquement sur la base de donnees (`php/car_data.php`)
- **Marques dynamiques** — la section « Explorer par marque » de l'accueil affiche automatiquement les marques presentes en base
- **Contact** — formulaire persiste en base + notification email + vue admin
- **Newsletter** — inscription avec anti-spam, liste et export dans l'admin
- **Mentions legales** — CGV, CGU, politique de confidentialite
- **SEO** — sitemap.php dynamique, robots.txt, balises meta dynamiques, JSON-LD
- **Securite** — tokens CSRF, requetes preparees, rate limiting (connexion, inscription, mot de passe, contact, newsletter), session regeneree, deconnexion POST

## Tests

Depuis la racine du projet :

```powershell
C:\xampp\php\php.exe tests\smoke_test.php
C:\xampp\php\php.exe tests\db_check.php
```

Le parcours E2E utilise Apache et MySQL demarres dans XAMPP :

```powershell
Set-ExecutionPolicy -Scope Process Bypass
.\tests\e2e_http_test.ps1
```

Les liens de verification et journaux de test sont stockes dans `C:\xampp\ecodrive-private\logs`.
