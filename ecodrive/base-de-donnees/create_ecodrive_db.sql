-- Création de la base
CREATE DATABASE IF NOT EXISTS `ecodrive` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ecodrive`;

-- Table utilisateur avec rôle
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `role` ENUM('client','admin') NOT NULL DEFAULT 'client',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table voiture
CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `marque` VARCHAR(100) NOT NULL,
  `modele` VARCHAR(100) NOT NULL,
  `annee` YEAR NOT NULL,
  `prix` DOUBLE NOT NULL DEFAULT 0,
  `description` TEXT,
  `image` VARCHAR(255),
  `details_page` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table réservation
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

-- Table borne
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

-- Compte admin par défaut (mot de passe = admin123)
INSERT INTO `utilisateur` (`nom`, `email`, `mot_de_passe`, `role`)
VALUES ('Admin EcoDrive', 'admin@ecodrive.com', 
'$2y$10$ObNtr55dNCDiG9EhmFSFsuUxk0P2rNYmNn/JGkWiTT8pMBhn5TDna', 
'admin');

-- Compte client par défaut (mot de passe = client123)
INSERT INTO `utilisateur` (`nom`, `email`, `mot_de_passe`, `role`)
VALUES ('Client Test', 'client@ecodrive.com', 
'$2y$10$d8mvBiMijQtsJ5bh7UCqQOhHq3bqFtOTlcofTmsBtlzCGyMah3pwO', 
'client');

-- Voitures de test (15 modèles)
INSERT INTO `voiture` (`marque`, `modele`, `annee`, `prix`, `description`, `image`, `details_page`)
VALUES
('Audi', 'A6 Sportback e-tron', 2026, 239000, 'Berline premium allemande, élégante et technologique. Confort routier exceptionnel, double écran tactile MMI, autonomie élevée.', 'images/audi-a6-sportback-e-tron.avif', 'voitures/Audi-A6-Sportback-e-tron.php'),
('BMW', 'iX3', 2026, 239000, 'SUV électrique premium alliant performances et respect de l\'environnement. Design dynamique, technologies de pointe, autonomie généreuse.', 'images/bmw-ix3.jpg', 'voitures/BMW-iX3.php'),
('BYD', 'Atto 3', 2026, 95000, 'SUV compact électrique, autonomie ~420 km. Bien équipé, confortable et abordable, idéal pour la ville et les trajets quotidiens.', 'images/byd-atto-3.jpg', 'voitures/BYD-Ato3.php'),
('BYD', 'Dolphin Surf', 2026, 70000, 'Compacte électrique chinoise, autonomie ~340 km. Design moderne, bon rapport qualité/prix.', 'images/byd-dolphin.jpg', 'voitures/BYD-Dolphin.php'),
('Citroën', 'C3', 2026, 70000, 'Compacte électrique française, autonomie ~340 km. Design moderne, bon rapport qualité/prix.', 'images/C3_1.jpg', 'voitures/citroene-c3.php'),
('Kia', 'EV-3', 2026, 70000, 'Compacte électrique coréenne, autonomie ~340 km. Design moderne, bon rapport qualité/prix.', 'images/kia-ev3.png', 'voitures/kia-ev-3.php'),
('Mercedes-Benz', 'CLK', 2026, 450000, 'Coupé sportif de luxe, hybride V12 bi-turbo de 1 150 ch. Édition limitée à 50 exemplaires dans le monde.', 'images/Mercedes-Benz-Classe-C-2026.jpg', 'voitures/mercedesCLK2026.php'),
('Mercedes-Benz', 'EQC 400 4MATIC', 2026, 280000, 'SUV électrique premium, 408 ch, autonomie ~400 km. Intérieur luxueux avec MBUX et aides à la conduite avancées.', 'images/mercedes-eqc.jpg', 'voitures/mercedes-EQC.php'),
('MG', '4 Urban', 2026, 70000, 'Compacte électrique chinoise, autonomie ~340 km. Design moderne, bon rapport qualité/prix.', 'images/mg-4-urban.jpg', 'voitures/mg4-urban.php'),
('Peugeot', 'e-208', 2026, 95000, 'Citadine électrique, autonomie ~340 km. Compacte, économique et adaptée à la conduite urbaine.', 'images/peugeot-e208.jpg', 'voitures/Peugeot-e-208.php'),
('Porsche', 'Panamera', 2026, 400000, 'Limousine de luxe, hybride V8 bi-turbo de 600 ch. Édition limitée à 100 exemplaires dans le monde.', 'images/porsche-panamera.jpg', 'voitures/PorschePanamera.php'),
('Renault', 'Megane E-Tech', 2026, 120000, 'Compacte électrique française, autonomie ~450 km. Design moderne, intérieur connecté, idéale pour la ville et les trajets longue distance.', 'images/renault-megane-e-tech.jpg', 'voitures/Renault-Megane-E-Tech.php'),
('Tesla', 'Model 3', 2026, 160000, 'Berline compacte électrique, autonomie ~452 km, recharge rapide. Référence mondiale en mobilité électrique.', 'images/tesla-model3.jpg', 'voitures/Tesla-Model3.php'),
('Tesla', 'Model S Plaid', 2026, 350000, 'Berline haut de gamme, 1 020 ch, autonomie ~600 km. Accélération fulgurante de 0 à 100 km/h en 2,1 secondes.', 'images/tesla-model-s-plaid.jpg', 'voitures/Tesla-Model-S-Plaid.php'),
('Toyota', 'Yaris', 2026, 70000, 'Compacte électrique japonaise, autonomie ~340 km. Design moderne, bon rapport qualité/prix.', 'images/toyota-yaris.jpg', 'voitures/toyota-yaris.php');

-- Bornes de recharge
INSERT INTO `borne` (`nom`, `modele`, `puissance`, `prix`, `description`, `image`, `details_page`)
VALUES
('Exicom', 'Spin Air 7kW', '7 kW', 2490, 'Borne AC monophasée intelligente pour maison — 7.4 kW, Wi-Fi/Bluetooth/4G, Type 2, IP55.', 'images/SPIN-AIR-11 (2).png', 'bornes/ExicomSpinAir7kW.php'),
('Exicom', 'Spin Air 11kW', '11 kW', 3290, 'Borne AC triphasée haute performance — 11 kW, OCPP 1.6, Wi-Fi/4G, pour maisons et bureaux.', 'images/SPIN-AIR-11 (1).png', 'bornes/ExicomSpinAir11kW.php'),
('Exicom', 'Spin Air 22kW', '22 kW', 4490, 'Borne AC professionnelle — 22 kW triphasé, OCPP 1.6/2.0, RFID, pour flottes et parkings.', 'images/SPIN-AIR-11.png', 'bornes/ExicomSpinAir22kW.php'),
('Exicom', 'Spin Free 3kW', '3 kW', 1290, 'Chargeur portable compact — 3 kW monophasé, Type 2, câble 5 m, prise Schuko, IP54.', 'images/SPIN-FREE-3.png', 'bornes/ExicomSpinFree3kW.php');
