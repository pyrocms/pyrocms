DROP TABLE IF EXISTS `core_users`;
DROP TABLE IF EXISTS `core_settings`;
DROP TABLE IF EXISTS `core_sites`;
  
CREATE TABLE core_settings (
  `slug` TEXT PRIMARY KEY,
  `default` TEXT NOT NULL,
  `value` TEXT NULL,
  UNIQUE ( `slug` )
);

INSERT INTO `core_settings` (`slug`, `default`) 
VALUES ('date_format', 'g:ia -- m/d/y');

INSERT INTO `core_settings` (`slug`, `default`) 
  VALUES ('lang_direction', 'ltr');

  INSERT INTO `core_settings` (`slug`, `default`) 
VALUES ('status_message', 'This site has been disabled by a super-administrator.');

CREATE TABLE `core_sites` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `ref` VARCHAR(20) NOT NULL,
  `domain` VARCHAR(100),
  `active` INTEGER NOT NULL default '1',
  `created_on` INTEGER NOT NULL default '0',
  `updated_on` INTEGER null,
  UNIQUE (`ref`),
  UNIQUE (`domain`)
);

DROP TABLE IF EXISTS `{site_ref}_users`;

CREATE TABLE `{site_ref}_users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` TEXT NOT NULL DEFAULT '',
  `salt` varchar(6) NOT NULL DEFAULT '',
  `group_id` INTEGER,
  `ip_address` TEXT,
  `active` int(1),
  `activation_code` TEXT,
  `created_on` INTEGER NOT NULL,
  `last_login` INTEGER NOT NULL,
  `username` TEXT,
  `forgotten_password_code` TEXT,
  `remember_code` TEXT,
  UNIQUE (`email`),
  UNIQUE ('username')
);

INSERT INTO `{site_ref}_users` (`id`, `email`, `password`, `salt`, `group_id`, `ip_address`, `active`, `activation_code`, `created_on`, `last_login`, `username`) 
VALUES (1, :email, :password, :salt, 1, '', 1, '', :unix_now, :unix_now, :username);
  
CREATE TABLE IF NOT EXISTS `core_users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` TEXT NOT NULL DEFAULT '',
  `salt` varchar(6) NOT NULL DEFAULT '',
  `group_id` INTEGER,
  `ip_address` TEXT,
  `active` int(1),
  `activation_code` TEXT,
  `created_on` INTEGER NOT NULL,
  `last_login` INTEGER NOT NULL,
  `username` TEXT,
  `forgotten_password_code` TEXT,
  `remember_code` TEXT,
  UNIQUE (`email`)
);

INSERT INTO core_users SELECT * FROM {site_ref}_users;

DROP TABLE IF EXISTS `{site_ref}_profiles`;

CREATE TABLE IF NOT EXISTS `{site_ref}_profiles` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` INTEGER NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `company` TEXT,
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `bio` text,
  `dob` INTEGER,
  `gender` TEXT NOT NULL DEFAULT ('m'),
  `phone` TEXT,
  `mobile` TEXT,
  `address_line1` TEXT,
  `address_line2` TEXT,
  `address_line3` TEXT,
  `postcode` TEXT,
  `website` TEXT,
  `updated_on` INTEGER,
  UNIQUE (`user_id`)
);

INSERT INTO `{site_ref}_profiles` (`id`, `user_id`, `first_name`, `last_name`, `display_name`, `company`, `lang`)
VALUES (1, 1, :firstname, :lastname, :displayname, '', 'en');

DROP TABLE IF EXISTS `{site_ref}_migrations`;

CREATE TABLE `{site_ref}_migrations` (
  `version` INTEGER
);

INSERT INTO {site_ref}_migrations VALUES (:migration);

DROP TABLE IF EXISTS `{site_ref}_modules`;

CREATE TABLE `{site_ref}_modules` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `slug` varchar(50) NOT NULL,
  `version` TEXT NOT NULL,
  `type` TEXT,
  `description` TEXT,
  `skip_xss` tinyint(1) NOT NULL,
  `is_frontend` tinyint(1) NOT NULL,
  `is_backend` tinyint(1) NOT NULL,
  `menu` TEXT NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `installed` tinyint(1) NOT NULL,
  `is_core` tinyint(1) NOT NULL,
  `updated_on` int(11) NOT NULL DEFAULT '0',
  UNIQUE (`slug`)
);


DROP TABLE IF EXISTS `{session_table}`;

CREATE TABLE `{session_table}` (
 `session_id` INTEGER PRIMARY KEY AUTOINCREMENT,
 `ip_address` TEXT DEFAULT '0' NOT NULL,
 `user_agent` TEXT NOT NULL,
 `last_activity` int(10) DEFAULT 0 NOT NULL,
 `user_data` text NULL
);
