USE @DB_NAME@;

SET foreign_key_checks = 0;

ALTER TABLE building_wall_systems
  DISABLE KEYS,
  DROP FOREIGN KEY fk__building_wall_systems__buildings,
  DROP FOREIGN KEY fk__building_wall_systems__wall_systems,
  DROP KEY fk__building_wall_systems__wall_systems,
  DROP PRIMARY KEY,
  MODIFY COLUMN wall_system_id char(36) NULL,
  ADD PRIMARY KEY( id );

ALTER TABLE building_wall_systems
  ADD CONSTRAINT fk__building_wall_systems__buildings FOREIGN KEY( building_id )
    REFERENCES buildings( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION,
  ADD CONSTRAINT fk__building_wall_systems__wall_systems FOREIGN KEY( wall_system_id )
    REFERENCES wall_systems( id )
      ON UPDATE CASCADE
      ON DELETE SET NULL,
  ENABLE KEYS;
  
 
-- New title column is text that will appear in rebate bar
ALTER TABLE technology_groups
  ADD COLUMN title varchar(255) NULL AFTER name,
  ADD COLUMN rebate_bar boolean NOT NULL DEFAULT 0;
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Appliances'
 WHERE incentive_tech_group_id = 'APP';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Building Shell'
 WHERE incentive_tech_group_id = 'ENV';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Heating/Cooling'
 WHERE incentive_tech_group_id = 'HVAC';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Hot Water'
 WHERE incentive_tech_group_id = 'HW';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Lighting'
 WHERE incentive_tech_group_id = 'LIGHT';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Whole House'
 WHERE incentive_tech_group_id = 'WHOLE';
 
UPDATE technology_groups
   SET rebate_bar = 1,
       title = 'Other'
 WHERE incentive_tech_group_id = 'OTH';
       
SET foreign_key_checks = 1;
