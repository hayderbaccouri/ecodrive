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
3. Importer la base de donnees :
   ```
   mysql -u root -p < base-de-donnees/ecodrive.sql
   ```
4. Demarrer Apache et MySQL dans le panneau XAMPP
5. Ouvrir `http://localhost/ecodrive`

---

## Identifiants par defaut

| Role  | Email                  | Mot de passe |
|-------|------------------------|--------------|
| Admin | admin@ecodrive.com     | dans le SQL  |
| Client| client@ecodrive.com    | dans le SQL  |

Les mots de passe hashes se trouvent dans `base-de-donnees/ecodrive.sql` (ligne 75-76).

---

## Structure du projet

```
ecodrive/
  index.php              — page d'accueil
  404.php                — page introuvable
  .env.example           — modele de configuration
  .htaccess              — rewrites Apache
  voitures/              — pages detail par modele (14 fichiers)
  bornes/                — pages detail bornes de recharge (4 modeles Exicom)
  pages/                 — pages statiques (contact, CGV, CGU, mentions legales, confidentialite)
  php/                   — logique applicative
    bootstrap.php        — init session, autoload, DB
    connexion.php        — formulaire de connexion
    inscription.php      — creation de compte
    catalogue.php        — listing voitures
    reservation.php      — reservation d'essai
    confirmation-reservation.php
    mes-essais.php       — historique des essais
    profil.php           — edition profil
    tableau-de-bord.php  — tableau de bord utilisateur
    admin.php            — panneau administrateur
    export.php           — export CSV
    car_slider.php       — carrousel voitures
    configuration.php    — config centralisee
    partials/            — header, footer, meta, jsonld
  css/                   — feuilles de style
  js/                    — scripts cote client
  images/                — photos voitures et bornes
  base-de-donnees/       — script SQL consolidé
  private/logs/          — journaux applicatifs
```

---

## Fonctionnalites

- **Catalogue** — 14 voitures electriques avec pages detail (prix, specs, autonomie)
- **Bornes de recharge** — 4 bornes Exicom (3 kW a 22 kW) avec fiches produit
- **Reservation d'essais** — prise de rendez-vous en ligne avec creneaux horaires
- **Compte utilisateur** — inscription, connexion, profil, historique des essais
- **Panneau admin** — gestion des utilisateurs, voitures, reservations, export CSV
- **Contact** — formulaire de contact avec traitement serveur
- **Mentions legales** — CGV, CGU, politique de confidentialite
- **SEO** — sitemap.xml, robots.txt, balises meta dynamiques, JSON-LD
