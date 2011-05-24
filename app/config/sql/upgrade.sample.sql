USE @DB_NAME@;

SET foreign_key_checks = 0;

DROP TABLE IF EXISTS proposals;
CREATE TABLE proposals(
  id            char(36)      NOT NULL,
  user_id       char(36)      NOT NULL, -- sender
  incentive_id  char(36)      NOT NULL, -- the incentive from which the request was generated
  technology_id char(36)      NOT NULL, -- the technology from which the request was generated
  scope_of_work varchar(255)  NOT NULL, -- install | repair
  timing        varchar(255)  NOT NULL, -- ready | planning
  urgency       varchar(255)  NOT NULL, -- within a week | 1-2 weeks | over 3 weeks | flexible
  comments      text          NULL,
  created       datetime      NOT NULL,
  modified      datetime      NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__proposals__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT  fk__proposals__incentive FOREIGN KEY( incentive_id )
    REFERENCES incentive( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION,
  CONSTRAINT  fk__proposals__technologies FOREIGN KEY( technology_id )
    REFERENCES technologies( id )
    ON UPDATE CASCADE
    ON DELETE NO ACTION
) ENGINE=InnoDB;

ALTER TABLE users
  ADD admin boolean NOT NULL DEFAULT 0 AFTER password;
  
UPDATE users
   SET admin = 1
 WHERE email = 'wamaull@mac.com';

ALTER TABLE incentive_weblink_verification
  MODIFY incentive_id char(36) NOT NULL,
  MODIFY source_id bigint NOT NULL,
  ADD ekg varchar(255) NULL,
  ADD CONSTRAINT fk__incentive_weblink_verification__incentive FOREIGN KEY( incentive_id )
    REFERENCES incentive(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

SET foreign_key_checks = 1;
