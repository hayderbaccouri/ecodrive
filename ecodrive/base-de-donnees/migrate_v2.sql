-- Migration: mise à jour des chemins images + nouveaux modèles
-- Date: 2026-06-28

-- 1. Supprimer Citroën C3 et Renault Megane E-Tech
DELETE FROM voiture WHERE id_voiture IN (5, 12);

-- 2. Mettre à jour Audi A6 (nouveau dossier images + hero webp)
UPDATE voiture SET image = 'images/audi-a6-sportback-e-tron-electrique/essai-audi-a6-sportback-e-tron-la-grande-routiere-allemande-passe-au-tout-electrique-107381.webp' WHERE id_voiture = 1;

-- 3. BYD Atto 3 — corriger le nom du fichier détail
UPDATE voiture SET details_page = 'voitures/BYD-Atto-3.php' WHERE id_voiture = 3;

-- 4. BYD Dolphin — corriger la typo dans details_page (DAULPHIN → Dolphin)
UPDATE voiture SET details_page = 'voitures/BYD-Dolphin.php' WHERE id_voiture = 4;

-- 5. Kia EV-3 — corriger nom fichier détail
UPDATE voiture SET details_page = 'voitures/kia-ev3.php' WHERE id_voiture = 6;

-- 6. Mercedes-Benz : CLK → Classe C 2026
UPDATE voiture SET modele = 'Classe C 2026', details_page = 'voitures/mercedes-classe-c-2026.php' WHERE id_voiture = 7;

-- 7. MG 4 Urban — corriger nom fichier détail
UPDATE voiture SET details_page = 'voitures/mg4.php' WHERE id_voiture = 9;

-- 8. Porsche : Panamera → Taycan (nouveau dossier + hero webp)
UPDATE voiture SET modele = 'Taycan', image = 'images/porsche-taycan/porsche-taycan-taycan-91005.webp', details_page = 'voitures/Porsche-Taycan.php' WHERE id_voiture = 11;

-- 9. Tesla Model 3 — corriger nom fichier détail
UPDATE voiture SET details_page = 'voitures/Tesla-Model-3.php' WHERE id_voiture = 13;

-- 10. Toyota : Yaris → bZ4X 73.1 kWh (nouveau dossier + hero webp)
UPDATE voiture SET modele = 'bZ4X 73.1 kWh', image = 'images/toyota-bz4x-73.1-kwh/toyota-bz4x-73.1-kwh-109445.webp', details_page = 'voitures/toyota-bz4x.php' WHERE id_voiture = 15;

-- 11. Ajouter Geely EX2
INSERT INTO voiture (marque, modele, annee, prix, description, image, details_page) VALUES
('Geely', 'EX2', 2026, 89900, 'SUV compact 100% électrique Geely. Autonomie jusqu''à 320 km, design robuste, habitacle spacieux, idéal pour la ville et les trajets quotidiens.', 'images/geely-ex2/geely-ex2-39.4-kwh-max-101691.webp', 'voitures/Geely-EX2.php');
