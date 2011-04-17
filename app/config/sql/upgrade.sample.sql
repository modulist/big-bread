USE @DB_NAME@;

SET foreign_key_checks = 0;

ALTER TABLE buildings
  ADD COLUMN roof_radiant_barrier boolean NULL AFTER windows_frequently_open,
  ADD COLUMN roof_insulation_level_id char(36) NULL AFTER windows_frequently_open,
  ADD CONSTRAINT fk__building__insulation_levels FOREIGN KEY( roof_insulation_level_id )
    REFERENCES insulation_levels( id )
      ON UPDATE CASCADE
      ON DELETE SET NULL;

ALTER TABLE building_roof_systems
  DROP FOREIGN KEY fk__building_roof_systems__insulation_levels,
  DROP COLUMN insulation_level_id,
  DROP COLUMN radiant_barrier;

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
 
-- Make incentive_amount_type conform
DROP TABLE IF EXISTS incentive_amount_types;

ALTER TABLE incentive_amount_type
  RENAME TO incentive_amount_types;
  
-- Prepare for a new PK field
ALTER TABLE incentive_amount_types
  DROP PRIMARY KEY,
  ADD COLUMN id char(36) NULL FIRST,
  MODIFY COLUMN incentive_amount_type_id varchar(6) NULL;
  
-- Populate the new incentive.id
UPDATE incentive_amount_types
   SET id = UUID();
   
-- Reassign the PK and create a unique index on the old PK
ALTER TABLE incentive_amount_types
  MODIFY id char(36) NOT NULL,
  ADD PRIMARY KEY( id ),
  ADD CONSTRAINT uix__incentive_amount_type_id UNIQUE INDEX( incentive_amount_type_id );

-- Point existing associations to the new key
ALTER TABLE technology_incentives
  MODIFY incentive_amount_type_id char(36) NULL;
  
UPDATE technology_incentives, incentive_amount_types
   SET technology_incentives.incentive_amount_type_id = incentive_amount_types.id
 WHERE technology_incentives.incentive_amount_type_id = incentive_amount_types.incentive_amount_type_id;
 
ALTER TABLE technology_incentives
  ADD CONSTRAINT fk__technology_incentives__incentive_amount_types FOREIGN KEY( incentive_amount_type_id )
    REFERENCES incentive_amount_types( id )
      ON UPDATE CASCADE
      ON DELETE NO ACTION;
       
SET foreign_key_checks = 1;
