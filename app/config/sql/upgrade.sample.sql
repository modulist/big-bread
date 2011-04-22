USE @DB_NAME@;

SET foreign_key_checks = 0;

UPDATE technologies
   SET questionnaire_product = 1
 WHERE incentive_tech_id = 'RFRG';
 
UPDATE technologies
   SET name = 'Range/Cooktop/Oven'
 WHERE incentive_tech_id = 'COOK';
       
SET foreign_key_checks = 1;

