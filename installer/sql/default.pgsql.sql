DROP TYPE IF EXISTS gender CASCADE;
CREATE TYPE gender AS ENUM ('m', 'f', '');

DROP TABLE IF EXISTS core_users, core_settings, core_sites, {site_ref}_modules, {site_ref}_schema_version;

CREATE TABLE core_settings (
	"slug" varchar( 30 ) NOT NULL ,
	"default" text NOT NULL,
	"value" text NULL,
	PRIMARY KEY ( slug ) ,
	UNIQUE ( slug )
);

INSERT INTO core_settings ("slug", "default") VALUES 
	('date_format', 'g:ia -- m/d/y'),
	('lang_direction', 'ltr'),
	('status_message', 'This site has been disabled by a super-administrator.');

CREATE TABLE core_sites (
  id SERIAL,
	name VARCHAR(100) NOT NULL,
  ref VARCHAR(20) NOT NULL,
  domain VARCHAR(100),
	active bool default true,
  created_on INTEGER,
  updated_on INTEGER,
  PRIMARY KEY ( id ) ,
  UNIQUE (ref),
  UNIQUE (domain)
);

DROP TABLE IF EXISTS {site_ref}_users;

CREATE TABLE IF NOT EXISTS {site_ref}_users (
  id SERIAL,
  email varchar(60) NOT NULL,
  password varchar(100) NOT NULL,
  salt varchar(6) NOT NULL,
  group_id INTEGER ,
  ip_address varchar(16),
  active INTEGER,
  activation_code varchar(40) ,
  created_on INTEGER NOT NULL,
  last_login INTEGER NOT NULL,
  username varchar(20) ,
  forgotten_password_code varchar(40) ,
  remember_code varchar(40) ,
  PRIMARY KEY (id),
  UNIQUE (email),
  UNIQUE (username)
);

INSERT INTO {site_ref}_users (id, email, password, salt, group_id, ip_address, active, activation_code, created_on, last_login, username) 
VALUES (1, :email, :password, :salt, 1, '', 1, '', :unix_now, :unix_now, :username);
	
CREATE TABLE IF NOT EXISTS core_users (
  id SERIAL,
  email varchar(60) NOT NULL DEFAULT '',
  password varchar(100) NOT NULL DEFAULT '',
  salt varchar(6) NOT NULL DEFAULT '',
  group_id INTEGER,
  ip_address varchar(16),
  active INTEGER,
  activation_code varchar(40),
  created_on INTEGER NOT NULL,
  last_login INTEGER NOT NULL,
  username varchar(20),
  forgotten_password_code varchar(40),
  remember_code varchar(40),
  PRIMARY KEY (id)
);

INSERT INTO core_users SELECT * FROM {site_ref}_users;

DROP TABLE IF EXISTS {site_ref}_profiles;

CREATE TABLE {site_ref}_profiles (
  id SERIAL,
  user_id INTEGER,
  display_name varchar(50) NOT NULL,
  first_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  company varchar(100),
  lang varchar(2) NOT NULL DEFAULT 'en',
  bio text,
  dob INTEGER,
  gender gender,
  phone varchar(20),
  mobile varchar(20),
  address_line1 varchar(255),
  address_line2 varchar(255),
  address_line3 varchar(255),
  postcode varchar(20),
  website varchar(255),
  updated_on INTEGER,
  PRIMARY KEY (id)
);

INSERT INTO {site_ref}_profiles (id, user_id, first_name, last_name, display_name, company, lang)
VALUES (1, 1, :firstname, :lastname, :displayname, '', 'en');

CREATE TABLE IF NOT EXISTS {site_ref}_migrations (
  version INTEGER DEFAULT NULL
);

INSERT INTO {site_ref}_migrations VALUES (:migration);

CREATE TABLE IF NOT EXISTS {site_ref}_modules (
  id SERIAL,
  name TEXT NOT NULL,
  slug varchar(50) NOT NULL,
  version varchar(20) NOT NULL,
  type varchar(20),
  description TEXT,
  skip_xss bool NOT NULL,
  is_frontend bool NOT NULL,
  is_backend bool NOT NULL,
  menu varchar(20) NOT NULL,
  enabled bool NOT NULL,
  installed bool NOT NULL,
  is_core bool NOT NULL,
  updated_on INTEGER,
  PRIMARY KEY (id),
  UNIQUE (slug)
);

CREATE TABLE IF NOT EXISTS {session_table} (
  session_id varchar(40) DEFAULT '0' NOT NULL,
  ip_address varchar(16) DEFAULT '0' NOT NULL,
  user_agent varchar(120) NOT NULL,
  last_activity INTEGER,
  user_data text NULL,
  PRIMARY KEY (session_id)
);
