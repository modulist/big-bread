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
  ADD service_out DATETIME NULL AFTER serial_number,
  CHANGE year_built service_in DATETIME NULL AFTER serial_number;
 
-- Replacing the error_log table that I deleted from the original import
CREATE TABLE IF NOT EXISTS error_log (
  id        int(11)       NOT NULL AUTO_INCREMENT,
  date_time datetime      NOT NULL,
  query     varchar(5000) NOT NULL,
  error     varchar(5000) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8;

-- Fix known character set issues
-- To discover issues, run this:
-- SELECT id, NAME FROM incentive WHERE length(NAME) != char_length(name)
UPDATE incentive
   SET name = 'Colorado Springs Utilities - Home Improvement Financing'
 WHERE id = 'ad1a745c-6f7f-11e0-be41-80593d270cc9';

UPDATE incentive
   SET name = 'City of Aurora - Residential Energy Efficiency & Conservation Rebate Program'
 WHERE id = 'ad1ab7c8-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'City of Aurora - Solar Permit Offset and Energy Audit Rebate'
 WHERE id = 'ad1ab8f4-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'City of Aurora - Solar Domestic Water Heater Rebate'
 WHERE id = 'ad1ac75e-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'MassCEC - Commonwealth Wind Incentive Program - Micro Wind Initiative'
 WHERE id = 'ad489918-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'National Grid - Residential (Gas) Energy Efficiency Programs'
 WHERE id = 'ad48b1fa-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'Taunton Municipal Lighting Plant - House ''N Home Thermal Efficiency Rebate Program'
 WHERE id = 'ad48df72-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'PECO Energy (Gas) - Heating Efficiency Rebate Program'
 WHERE id = 'ad4cc628-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'PECO Energy (Electric) - Residential Energy Efficiency Rebate Program'
 WHERE id = 'ad4cd942-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'PECO Energy - Commercial Energy Efficiency Rebate Program'
 WHERE id = 'ad4cda6e-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'National Grid - Residential (Gas) Energy Efficiency Rebate Programs'
 WHERE id = 'ad4f321e-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'National Grid - Residential (Electric) Energy Efficiency Incentive Program'
 WHERE id = 'ad4f3340-6f7f-11e0-be41-80593d270cc9'

UPDATE incentive
   SET name = 'Benton PUD - ENERGY STAR Homes'
 WHERE id = 'ad50dc90-6f7f-11e0-be41-80593d270cc9'

-- TODO: Insert updated search_view script

SET foreign_key_checks = 1;

