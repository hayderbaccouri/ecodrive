-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ecodrive
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `borne`
--

DROP TABLE IF EXISTS `borne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borne` (
  `id_borne` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `puissance` varchar(50) NOT NULL,
  `prix` double NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `details_page` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_borne`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borne`
--

LOCK TABLES `borne` WRITE;
/*!40000 ALTER TABLE `borne` DISABLE KEYS */;
INSERT INTO `borne` VALUES (1,'Exicom','Spin Air 7kW','7 kW',2490,'Borne compacte id├®ale pour maisons.','images/bornes/SPIN-AIR-11-2.png','bornes/ExicomSpinAir7kW.php','2026-06-23 21:28:31'),(2,'Exicom','Spin Air 11kW','11 kW',3290,'Borne performante pour recharge rapide.','images/bornes/SPIN-AIR-11.png','bornes/ExicomSpinAir11kW.php','2026-06-23 21:28:31'),(3,'Exicom','Spin Air 22kW','22 kW',4490,'Borne semi-rapide pour pros.','images/bornes/SPIN-AIR-11.png','bornes/ExicomSpinAir22kW.php','2026-06-23 21:28:31'),(4,'Exicom','Spin Free 3kW','3 kW',1290,'Borne portable ├®conomique.','images/bornes/SPIN-FREE-3.png','bornes/ExicomSpinFree3kW.php','2026-06-23 21:28:31');
/*!40000 ALTER TABLE `borne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_audit`
--

DROP TABLE IF EXISTS `admin_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `admin_name` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_audit_action` (`action`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_audit`
--

LOCK TABLES `admin_audit` WRITE;
/*!40000 ALTER TABLE `admin_audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_message`
--

DROP TABLE IF EXISTS `contact_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `sujet` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_contact_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_message`
--

LOCK TABLES `contact_message` WRITE;
/*!40000 ALTER TABLE `contact_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `success` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_ip_email` (`ip_address`,`email`,`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `subscribed_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_limits`
--

DROP TABLE IF EXISTS `rate_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bucket` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_bucket_created` (`bucket`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_limits`
--

LOCK TABLES `rate_limits` WRITE;
/*!40000 ALTER TABLE `rate_limits` DISABLE KEYS */;
/*!40000 ALTER TABLE `rate_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `id_reservation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(10) unsigned NOT NULL,
  `voiture_id` int(10) unsigned NOT NULL,
  `date_essai` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `statut` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_reservation`),
  KEY `fk_reservation_utilisateur` (`utilisateur_id`),
  KEY `fk_reservation_voiture` (`voiture_id`),
  CONSTRAINT `fk_reservation_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  CONSTRAINT `fk_reservation_voiture` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id_voiture`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id_utilisateur` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('client','admin') NOT NULL DEFAULT 'client',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'Admin EcoDrive','admin@ecodrive.com','90311428','$2y$10$ObNtr55dNCDiG9EhmFSFsuUxk0P2rNYmNn/JGkWiTT8pMBhn5TDna','admin','2026-06-23 21:28:31',NULL,NULL),(2,'Client Test','client@ecodrive.com',NULL,'$2y$10$d8mvBiMijQtsJ5bh7UCqQOhHq3bqFtOTlcofTmsBtlzCGyMah3pwO','client','2026-06-23 21:28:31',NULL,NULL);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voiture` (
  `id_voiture` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `marque` varchar(100) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `annee` year(4) NOT NULL,
  `prix` double NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `details_page` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `battery_kwh` decimal(5,1) DEFAULT NULL,
  `horsepower` int(11) DEFAULT NULL,
  `range_km` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_voiture`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voiture`
--

LOCK TABLES `voiture` WRITE;
/*!40000 ALTER TABLE `voiture` DISABLE KEYS */;
INSERT INTO `voiture` VALUES (1,'Audi','A6 Sportback e-tron',2026,239000,'Berline premium 100% ├®lectrique sur plateforme PPE. 367 ch, batterie 100 kWh NMC, autonomie 757 km WLTP, architecture 800V, recharge 10-80% en 21 min (270 kW). Double ├®cran MMI, Cx 0,21.','images/audi-a6-sportback-e-tron-electrique/essai-audi-a6-sportback-e-tron-la-grande-routiere-allemande-passe-au-tout-electrique-107381.webp','voitures/Audi-A6-Sportback-e-tron.php','2026-06-23 21:28:31',0,100.0,367,757),(2,'BMW','iX3',2026,249900,'SUV ├®lectrique premium sur plateforme Neue Klasse. 469 ch, transmission int├®grale xDrive, batterie 108,7 kWh, autonomie 805 km WLTP, recharge 400 kW (10-80% en 21 min). ├ëcran Panoramic iDrive 18\".','images/bmw-ix3/BMW-iX3.jpg','voitures/BMW-iX3.php','2026-06-23 21:28:31',0,108.7,469,805),(3,'BYD','Atto 3',2026,123990,'SUV compact 100% ├®lectrique BYD e-Platform 3.0. 313 ch propulsion, batterie Blade LFP 74,8 kWh, autonomie 510 km WLTP, architecture 800V, recharge DC 220 kW (10-80% en 25 min).','images/byd-atto-3/byd-atto-3.webp','voitures/BYD-Atto-3.php','2026-06-23 21:28:31',0,74.8,313,510),(4,'BYD','Dolphin Surf',2026,55000,'Citadine ├®lectrique BYD batterie Blade LFP 43,2 kWh. 156 ch, autonomie 310 km WLTP, recharge DC 85 kW (10-80% en 30 min). ├ëcran rotatif 10,1\", V2L, id├®ale pour la ville.','images/byd-dolphin/byd-dolphin-surf-38.88-kwh-102711.webp','voitures/BYD-Dolphin.php','2026-06-23 21:28:31',0,43.2,156,310),(6,'Kia','EV-3',2026,104980,'SUV compact cor├®en 100% ├®lectrique plateforme E-GMP. 204 ch traction avant, batterie 81,4 kWh, autonomie 605 km WLTP, recharge DC 128 kW (10-80% en 31 min). Garantie 7 ans.','images/kia-ev3/kia-ev3.png','voitures/kia-ev3.php','2026-06-23 21:28:31',1,81.4,204,605),(7,'Mercedes-Benz','Classe C 2026',2026,320000,'Berline premium ├®lectrique Mercedes. 489 ch, transmission int├®grale 4MATIC, batterie 94,5 kWh, autonomie 753 km WLTP, architecture 800V, recharge 330 kW (10-80% en 22 min). MBUX Hyperscreen.','images/mercedes-classe-c-2026/1-Mercedes-Benz-Classe-C-2026.jpg','voitures/mercedes-classe-c-2026.php','2026-06-23 21:28:31',0,94.5,489,753),(8,'Mercedes-Benz','EQC 400 4MATIC',2026,280000,'SUV premium ├®lectrique Mercedes. 408 ch, transmission int├®grale 4MATIC, batterie 80 kWh, autonomie 432 km WLTP, recharge DC 112 kW. Confort absolu, syst├¿me MBUX, design ├®l├®gant.','images/mercedes-eqc/mercedes-eqc.jpg','voitures/mercedes-EQC.php','2026-06-23 21:28:31',1,80.0,408,432),(9,'MG','4 Urban',2026,54950,'Berline compacte ├®lectrique MG plateforme MSP. 149 ch propulsion, batterie LFP 43 kWh, autonomie 335 km WLTP, recharge DC 88 kW (10-80% en 28 min). ├ëcran 12,8\", garantie 7 ans.','images/mg4/mg-4-urban.jpg','voitures/mg4.php','2026-06-23 21:28:31',0,53.9,160,420),(10,'Peugeot','e-208',2026,80000,'Citadine ├®lectrique fran├ºaise au design affirm├®. 156 ch, batterie 54 kWh, autonomie 433 km WLTP, recharge DC 100 kW (20-80% en 27 min). i-Cockpit, agr├®ment de conduite.','images/peugeot-e-208/E-208_gallery_exterior_3_D_1920x1080.jpg','voitures/Peugeot-e-208.php','2026-06-23 21:28:31',0,54.0,156,433),(11,'Porsche','Taycan',2026,448000,'Berline sportive 100% ├®lectrique Porsche. 408 ch propulsion, batterie 89 kWh, autonomie 503 km WLTP, architecture 800V, recharge 320 kW (10-80% en 18 min). Bo├«te 2 rapports, design iconique.','images/porsche-taycan/porsche-taycan-taycan-91005.webp','voitures/Porsche-Taycan.php','2026-06-23 21:28:31',1,89.0,408,503),(13,'Tesla','Model 3',2026,147000,'Berline ├®lectrique la plus vendue au monde. Autonomie jusqu\'├á 702 km WLTP, acc├¿s r├®seau Superchargeur, mises ├á jour OTA, performances exceptionnelles, minimalisme technologique.','images/tesla-model-3/tesla-model3.jpg','voitures/Tesla-Model-3.php','2026-06-23 21:28:31',0,82.0,498,702),(14,'Tesla','Model S Plaid',2026,359400,'Berline ├®lectrique la plus rapide au monde : 1 020 ch, 0-100 km/h en 2,1 s. Autonomie 600 km WLTP, volant yoke, 3 moteurs, transmission int├®grale, autonomie record.','images/tesla-model-s-plaid/tesla-model-s-plaid.jpg','voitures/Tesla-Model-S-Plaid.php','2026-06-23 21:28:31',0,100.0,1020,600),(15,'Toyota','bZ4X 73.1 kWh',2026,129800,'SUV 100% ├®lectrique Toyota plateforme e-TNGA. 227 ch traction avant, batterie NMC 73,1 kWh, autonomie 573 km WLTP, recharge DC (10-80% en 28 min). Design futuriste, fiabilit├® l├®gendaire.','images/toyota-bz4x-73.1-kwh/toyota-bz4x-73.1-kwh-109445.webp','voitures/toyota-bz4x.php','2026-06-23 21:28:31',0,73.1,227,573),(16,'Geely','EX2',2026,52000,'SUV compact 100% ├®lectrique Geely. 115 ch propulsion, batterie LFP 39,4 kWh, autonomie 325 km WLTP, recharge DC 30-80% en 21 min. ├ëcran 14,6\", Flyme Auto, id├®ale pour la ville.','images/geely-ex2/geely-ex2-39.4-kwh-max-101691.webp','voitures/Geely-EX2.php','2026-06-28 21:07:39',0,39.4,115,325);
/*!40000 ALTER TABLE `voiture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Performance indexes
--

ALTER TABLE reservation ADD INDEX idx_res_utilisateur (utilisateur_id);
ALTER TABLE reservation ADD INDEX idx_res_voiture (voiture_id);
ALTER TABLE reservation ADD INDEX idx_res_statut (statut);
ALTER TABLE reservation ADD INDEX idx_res_date (date_essai);
ALTER TABLE reservation ADD INDEX idx_res_voiture_date_statut (voiture_id, date_essai, statut);
ALTER TABLE voiture ADD INDEX idx_voiture_marque (marque);
ALTER TABLE voiture ADD INDEX idx_voiture_featured (is_featured);
ALTER TABLE voiture ADD INDEX idx_voiture_prix (prix);
ALTER TABLE voiture ADD INDEX idx_voiture_annee (annee);

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-20 23:51:23