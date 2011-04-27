USE @DB_NAME@;

SET foreign_key_checks = 0;

-- Adding/updating technology group data
UPDATE technologies
   SET questionnaire_product = 1
 WHERE incentive_tech_id = 'RFRG';
 
UPDATE technologies
   SET name = 'Range/Cooktop/Oven'
 WHERE incentive_tech_id = 'COOK';
 
ALTER TABLE building_products
  ADD service_out datetime NULL AFTER service_in;
  CHANGE year_built service_in datetime NULL AFTER serial_number,
 
-- Replacing the error_log table that I deleted from the original import
CREATE TABLE IF NOT EXISTS error_log (
  id        int(11)       NOT NULL AUTO_INCREMENT,
  date_time datetime      NOT NULL,
  query     varchar(5000) NOT NULL,
  error     varchar(5000) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8;

-- TODO: Insert updated search_view script

SET foreign_key_checks = 1;

