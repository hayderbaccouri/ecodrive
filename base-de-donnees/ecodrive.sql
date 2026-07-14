-- ============================================================
-- EcoDrive — Base de données consolidée
-- ============================================================
-- Ce fichier remplace les anciens scripts :
--   create_ecodrive_db.sql, migrate_v2.sql, migrate_images_subdirs.sql
-- ============================================================

DROP DATABASE IF EXISTS `ecodrive`;
CREATE DATABASE IF NOT EXISTS `ecodrive` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ecodrive`;

-- -----------------------------------------------------------
-- Tables
-- -----------------------------------------------------------

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `role` ENUM('client','admin') NOT NULL DEFAULT 'client',
  `telephone` VARCHAR(20) DEFAULT NULL,
  `reset_token` VARCHAR(64) DEFAULT NULL,
  `reset_expires` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `marque` VARCHAR(100) NOT NULL,
  `modele` VARCHAR(100) NOT NULL,
  `annee` YEAR NOT NULL,
  `prix` DOUBLE NOT NULL DEFAULT 0,
  `description` TEXT,
  `image` VARCHAR(255),
  `details_page` VARCHAR(255),
  `is_featured` TINYINT(1) DEFAULT 0,
  `battery_kwh` DECIMAL(5,1) DEFAULT NULL,
  `horsepower` INT DEFAULT NULL,
  `range_km` INT DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `utilisateur_id` INT UNSIGNED NOT NULL,
  `voiture_id` INT UNSIGNED NOT NULL,
  `date_essai` DATE NOT NULL,
  `heure_debut` TIME NOT NULL,
  `heure_fin` TIME NOT NULL,
  `statut` ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` TEXT,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation`),
  CONSTRAINT `fk_reservation_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  CONSTRAINT `fk_reservation_voiture` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id_voiture`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `borne` (
  `id_borne` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `modele` VARCHAR(100) NOT NULL,
  `puissance` VARCHAR(50) NOT NULL,
  `prix` DOUBLE NOT NULL DEFAULT 0,
  `description` TEXT,
  `image` VARCHAR(255),
  `details_page` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_borne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `attempted_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `success` TINYINT(1) DEFAULT 0,
  INDEX idx_attempts_email (`email`),
  INDEX idx_attempts_ip (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Données : utilisateurs
-- -----------------------------------------------------------

INSERT INTO `utilisateur` (`nom`, `email`, `mot_de_passe`, `role`) VALUES
('Admin EcoDrive', 'admin@ecodrive.com', '$2y$10$ObNtr55dNCDiG9EhmFSFsuUxk0P2rNYmNn/JGkWiTT8pMBhn5TDna', 'admin'),
('Client Test',    'client@ecodrive.com', '$2y$10$d8mvBiMijQtsJ5bh7UCqQOhHq3bqFtOTlcofTmsBtlzCGyMah3pwO', 'client');

-- -----------------------------------------------------------
-- Données : voitures (14 modèles)
-- -----------------------------------------------------------

INSERT INTO `voiture` (`marque`, `modele`, `annee`, `prix`, `description`, `image`, `details_page`, `is_featured`, `battery_kwh`, `horsepower`, `range_km`) VALUES
('Audi',           'A6 Sportback e-tron',           2026, 239000, 'Berline premium allemande 100% électrique. Confort routier exceptionnel, double écran tactile MMI, autonomie élevée, design élégant et technologique.',                                                                                                                                               'images/audi-a6-sportback-e-tron-electrique/essai-audi-a6-sportback-e-tron-la-grande-routiere-allemande-passe-au-tout-electrique-107381.webp', 'voitures/Audi-A6-Sportback-e-tron.php', 1, 94.4, 462, 623),
('BMW',            'iX3',                           2026, 249900, 'SUV électrique premium BMW sur la plateforme Neue Klasse. 469 ch, transmission intégrale xDrive, autonomie jusqu''à 805 km, recharge ultra-rapide 400 kW.',                                                                                                                                    'images/bmw-ix3/BMW-iX3.jpg', 'voitures/BMW-iX3.php', 1, 80.0, 469, 805),
('BYD',            'Atto 3',                        2026, 123990, 'SUV compact 100% électrique avec batterie Blade LFP. Autonomie 420 km, design moderne, équipements de série complets, excellent rapport qualité-prix.',                                                                                                                                        'images/byd-atto-3/byd-atto-3.webp', 'voitures/BYD-Atto-3.php', 0, 60.5, 204, 420),
('BYD',            'Dolphin Surf',                  2026, 55000,  'Citadine électrique compacte BYD avec batterie Blade LFP 38,8 kWh. Autonomie jusqu''à 300 km, parfaite pour la ville, recharge rapide 60 kW.',                                                                                                                                                  'images/byd-dolphin/byd-dolphin-surf-38.88-kwh-102711.webp', 'voitures/BYD-Dolphin.php', 0, 38.8, 95, 300),
('Kia',            'EV-3',                          2026, 104980, 'SUV compact coréen 100% électrique. Grande autonomie jusqu''à 605 km WLTP, garantie 7 ans, interface utilisateur intuitive, design moderne.',                                                                                                                                                     'images/kia-ev3/kia-ev3.png', 'voitures/kia-ev3.php', 0, 81.4, 204, 605),
('Mercedes-Benz',  'Classe C 2026',                 2026, 320000, 'Berline premium Mercedes 100% électrique. Design futuriste, luxe intérieur, technologies embarquées de pointe, performances exceptionnelles.',                                                                                                                                                  'images/mercedes-classe-c-2026/1-Mercedes-Benz-Classe-C-2026.jpg', 'voitures/mercedes-classe-c-2026.php', 0, NULL, NULL, NULL),
('Mercedes-Benz',  'EQC 400 4MATIC',                2026, 280000, 'SUV premium 100% électrique Mercedes. 408 ch, transmission intégrale 4MATIC, confort absolu, système d''infodivertissement MBUX, autonomie 450 km.',                                                                                                                                           'images/mercedes-eqc/mercedes-eqc.jpg', 'voitures/mercedes-EQC.php', 0, 80.0, 408, 450),
('MG',             '4 Urban',                       2026, 54950,  'Berline électrique compacte MG. Autonomie jusqu''à 420 km, design moderne, connectivité avancée, prix attractif à partir de 54 950 DT.',                                                                                                                                                        'images/mg4/mg-4-urban.jpg', 'voitures/mg4.php', 1, 64.0, 245, 420),
('Peugeot',        'e-208',                         2026, 80000,  'Citadine électrique française au design affirmé. Autonomie 400 km, agrément de conduite, recharge rapide 100 kW, finitions soignées.',                                                                                                                                                           'images/peugeot-e-208/E-208_gallery_exterior_3_D_1920x1080.webp', 'voitures/Peugeot-e-208.php', 0, 50.0, 136, 400),
('Porsche',        'Taycan',                        2026, 450000, 'Berline sportive de luxe 100% électrique Porsche. 680 ch, 0-100 km/h en 3,2 s, design iconique, habitacle raffiné, technologies de pointe.',                                                                                                                                                    'images/porsche-taycan/porsche-taycan-taycan-91005.webp', 'voitures/Porsche-Taycan.php', 0, 93.4, 680, 510),
('Tesla',          'Model 3',                       2026, 147000, 'Berline électrique la plus vendue au monde. Autonomie jusqu''à 702 km, accès au réseau Superchargeur, mises à jour OTA, performances exceptionnelles.',                                                                                                                                            'images/tesla-model-3/tesla-model3.jpg', 'voitures/Tesla-Model-3.php', 0, 75.0, 283, 702),
('Tesla',          'Model S Plaid',                 2026, 359400, 'Berline électrique la plus rapide du monde : 1 020 ch, 0-100 km/h en 2,1 s. Autonomie 600 km, volant yoke, autonomie record.',                                                                                                                                                                 'images/tesla-model-s-plaid/tesla-model-s-plaid.jpg', 'voitures/Tesla-Model-S-Plaid.php', 0, 100.0, 1020, 600),
('Toyota',         'bZ4X 73.1 kWh',                 2026, 84900,  'SUV 100% électrique Toyota. Autonomie jusqu''à 500 km, design audacieux, habitacle spacieux, fiabilité légendaire.',                                                                                                                                                                            'images/toyota-bz4x-73.1-kwh/toyota-bz4x-73.1-kwh-109445.webp', 'voitures/toyota-bz4x.php', 0, 71.4, 204, 500),
('Geely',          'EX2',                           2026, 89900,  'SUV compact 100% électrique Geely. Autonomie jusqu''à 320 km, design robuste, habitacle spacieux, idéal pour la ville et les trajets quotidiens.',                                                                                                                                                'images/geely-ex2/geely-ex2-39.4-kwh-max-101691.webp', 'voitures/Geely-EX2.php', 0, 39.4, 95, 320);

-- -----------------------------------------------------------
-- Données : bornes de recharge (4 modèles)
-- -----------------------------------------------------------

INSERT INTO `borne` (`nom`, `modele`, `puissance`, `prix`, `description`, `image`, `details_page`) VALUES
('Exicom', 'Spin Air 7kW',    '7 kW',  2490, 'Borne AC monophasée intelligente pour maison — 7.4 kW, Wi-Fi/Bluetooth/4G, Type 2, IP55.',                                                                   'images/bornes/SPIN-AIR-11-2.png', 'bornes/ExicomSpinAir7kW.php'),
('Exicom', 'Spin Air 11kW',   '11 kW', 3290, 'Borne AC triphasée haute performance — 11 kW, OCPP 1.6, Wi-Fi/4G, pour maisons et bureaux.',                                                              'images/bornes/SPIN-AIR-11-1.png', 'bornes/ExicomSpinAir11kW.php'),
('Exicom', 'Spin Air 22kW',   '22 kW', 4490, 'Borne AC professionnelle — 22 kW triphasé, OCPP 1.6/2.0, RFID, pour flottes et parkings.',                                                                   'images/bornes/SPIN-AIR-11.png', 'bornes/ExicomSpinAir22kW.php'),
('Exicom', 'Spin Free 3kW',   '3 kW',  1290, 'Chargeur portable compact — 3 kW monophasé, Type 2, câble 5 m, prise Schuko, IP54.',                                                                        'images/bornes/SPIN-FREE-3.png', 'bornes/ExicomSpinFree3kW.php');
