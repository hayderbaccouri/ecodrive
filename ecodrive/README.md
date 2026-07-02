# EcoDrive — Showroom électrique (projet de fin d'étude)

Résumé
- Projet PHP/MySQL simple pour la gestion d'un showroom de véhicules électriques (site, catalogue, réservations, admin).

Prérequis
- Docker & Docker Compose (recommandé pour la démo)
- PHP/MySQL si exécution locale sans Docker

Installation rapide (Docker)

1. Copier l'exemple d'environnement :

```bash
cp .env.example .env
# Éditez .env si besoin (DB credentials)
```

2. Lancer les services :

```bash
docker-compose up --build -d
```

3. Le site sera disponible sur : http://localhost:8080

Notes importantes
- Le dossier `ecodrive/base-de-donnees` est monté dans le service MySQL pour initialiser la base (fichiers `.sql`).
- Changez les mots de passe et créez un utilisateur non-root pour la production.
- Le fichier `.env.example` fournit les variables d'environnement utilisées par `php/bootstrap.php`.

Admin / comptes seedés
- Un compte admin de démonstration est inséré dans `base-de-donnees/create_ecodrive_db.sql` (email: `admin@ecodrive.com`).

Prochaines étapes recommandées
- Ajouter tests automatisés (PHPUnit)
- Ajouter CI (GitHub Actions)
- Nettoyer et déplacer les images volumineuses hors du repo (LFS ou stockage externe)
