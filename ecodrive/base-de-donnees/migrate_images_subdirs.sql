-- Migration : mettre à jour les chemins d'images vers les sous-dossiers
-- Exécuter après avoir renommé les dossiers dans images/

UPDATE voiture SET image = REPLACE(image, 'images/audi-a6-sportback-e-tron.avif', 'images/audi-a6/audi-a6-01.jpg') WHERE image LIKE '%audi-a6%';
UPDATE voiture SET image = REPLACE(image, 'images/bmw-ix3.jpg', 'images/bmw-ix3/BMW-iX3.jpg') WHERE image LIKE '%bmw-ix3%';
UPDATE voiture SET image = REPLACE(image, 'images/byd-atto-3.jpg', 'images/byd-atto-3/byd-atto-3.jpg') WHERE image LIKE '%byd-atto-3%';
UPDATE voiture SET image = REPLACE(image, 'images/byd-dolphin.jpg', 'images/byd-dolphin/byd-dolphin.jpg') WHERE image LIKE '%byd-dolphin%';
UPDATE voiture SET image = REPLACE(image, 'images/C3_1.jpg', 'images/citroen-c3/C3_1.jpg') WHERE image LIKE '%C3_1%';
UPDATE voiture SET image = REPLACE(image, 'images/kia-ev3.png', 'images/kia-ev3/kia-ev3.png') WHERE image LIKE '%kia-ev3%';
UPDATE voiture SET image = REPLACE(image, 'images/Mercedes-Benz-Classe-C-2026.jpg', 'images/mercedes-classe-c-2026/Mercedes-Benz-Classe-C-2026.jpg') WHERE image LIKE '%Mercedes-Benz-Classe-C%';
UPDATE voiture SET image = REPLACE(image, 'images/mercedes-eqc.jpg', 'images/mercedes-eqc/mercedes-eqc.jpg') WHERE image LIKE '%mercedes-eqc%';
UPDATE voiture SET image = REPLACE(image, 'images/mg-4-urban.jpg', 'images/mg4/mg-4-urban.jpg') WHERE image LIKE '%mg-4-urban%';
UPDATE voiture SET image = REPLACE(image, 'images/peugeot-e208.jpg', 'images/peugeot-e-208/peugeot-e208.jpg') WHERE image LIKE '%peugeot-e208%';
UPDATE voiture SET image = REPLACE(image, 'images/porsche-panamera.jpg', 'images/porsche-panamera/porsche-panamera.jpg') WHERE image LIKE '%porsche-panamera%';
UPDATE voiture SET image = REPLACE(image, 'images/renault-megane-e-tech.jpg', 'images/renault-megane-e-tech/renault-megane-e-tech.jpg') WHERE image LIKE '%renault-megane-e-tech%';
UPDATE voiture SET image = REPLACE(image, 'images/tesla-model3.jpg', 'images/tesla-model-3/tesla-model3.jpg') WHERE image LIKE '%tesla-model3%';
UPDATE voiture SET image = REPLACE(image, 'images/tesla-model-s-plaid.jpg', 'images/tesla-model-s-plaid/tesla-model-s-plaid.jpg') WHERE image LIKE '%tesla-model-s-plaid%';
UPDATE voiture SET image = REPLACE(image, 'images/toyota-yaris.jpg', 'images/toyota-yaris/toyota-yaris.jpg') WHERE image LIKE '%toyota-yaris%';

UPDATE borne SET image = REPLACE(image, 'images/', 'images/bornes/') WHERE image LIKE '%SPIN%';
