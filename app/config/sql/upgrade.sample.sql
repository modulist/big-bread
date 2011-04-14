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

SET foreign_key_checks = 1;
