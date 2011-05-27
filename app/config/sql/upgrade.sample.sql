USE @DB_NAME@;

SET foreign_key_checks = 0;

-- Support proposal requests
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

-- Admin functionality
ALTER TABLE users
  ADD admin boolean NOT NULL DEFAULT 0 AFTER password;
  
UPDATE users
   SET admin = 1
 WHERE email = 'wamaull@mac.com';
 
-- Changes to support API usage
INSERT INTO user_types( id, code, name, deleted )
VALUES( UUID(), 'API', 'API Consumer', 0 );

-- Create codes for other user types
UPDATE user_types
   SET code = 'OWNER'
 WHERE name = 'Homeowner';

UPDATE user_types
   SET code = 'BUYER'
 WHERE name = 'Buyer';

UPDATE user_types
   SET code = 'REALTR'
 WHERE name = 'Realtor';

UPDATE user_types
   SET code = 'INSPCT'
 WHERE name = 'Inspector';
 
-- Manage API users separately, but link to users via POC
DROP TABLE IF EXISTS api_users;
CREATE TABLE api_users(
  id            char(36)      NOT NULL,
  user_id       char(36)      NOT NULL, -- point of contact (poc)
  name          varchar(255)  NOT NULL, -- a pretty, non-personal display name
  description   text          NULL,     -- free form field for additional info (probably admin)
  api_key       char(32)      NOT NULL,
  created       datetime      NOT NULL,
  modified      datetime      NOT NULL,
  
  PRIMARY KEY( id ),
  CONSTRAINT  fk__api_users__users FOREIGN KEY( user_id )
    REFERENCES users( id )
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Changes required by the verification tool
ALTER TABLE incentive_weblink_verification
  MODIFY incentive_id char(36) NOT NULL,
  MODIFY source_id bigint NOT NULL,
  ADD ekg varchar(255) NULL,
  ADD CONSTRAINT fk__incentive_weblink_verification__incentive FOREIGN KEY( incentive_id )
    REFERENCES incentive(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE;
    
-- Original tables no longer necessary
DROP TABLE partner_domains;
DROP TABLE partners;

SET foreign_key_checks = 1;
