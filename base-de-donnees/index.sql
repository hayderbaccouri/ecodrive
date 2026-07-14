-- Performance indexes for EcoDrive
ALTER TABLE reservation ADD INDEX idx_res_utilisateur (utilisateur_id);
ALTER TABLE reservation ADD INDEX idx_res_voiture (voiture_id);
ALTER TABLE reservation ADD INDEX idx_res_statut (statut);
ALTER TABLE reservation ADD INDEX idx_res_date (date_essai);
ALTER TABLE reservation ADD INDEX idx_res_voiture_date_statut (voiture_id, date_essai, statut);
ALTER TABLE voiture ADD INDEX idx_voiture_marque (marque);
ALTER TABLE voiture ADD INDEX idx_voiture_featured (is_featured);
