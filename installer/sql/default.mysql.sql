DROP TABLE IF EXISTS `core_users`, `core_settings`, `core_sites`, `{site_ref}_modules`, `{site_ref}_schema_version`;
	
CREATE TABLE core_settings (
	`slug` varchar( 30 ) COLLATE utf8_unicode_ci NOT NULL ,
	`default` text COLLATE utf8_unicode_ci NOT NULL,
	`value` text COLLATE utf8_unicode_ci NULL,
	PRIMARY KEY ( `slug` ) ,
	UNIQUE KEY `unique - slug` ( `slug` ) ,
	KEY `index - slug` ( `slug` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores settings for the multi-site interface';

INSERT INTO `core_settings` (`slug`, `default`) VALUES 
	('date_format', 'g:ia -- m/d/y'),
	('lang_direction', 'ltr'),
	('status_message', 'This site has been disabled by a super-administrator.');

CREATE TABLE `core_sites` (
  `id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ref` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `domain` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	`active` TINYINT(1) NOT NULL default '1',
  `created_on` INT(11) NOT NULL default '0',
  `updated_on` INT(11) NOT NULL default '0',
  UNIQUE KEY `Unique ref` (`ref`),
  UNIQUE KEY `Unique domain` (`domain`),
  KEY `ref` (`ref`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `{site_ref}_users`;

CREATE TABLE IF NOT EXISTS `{site_ref}_users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  UNIQUE KEY `Unique email` (`email`),
  UNIQUE KEY `Unique username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registered User Information';

INSERT INTO `{site_ref}_users` (`id`, `email`, `password`, `salt`, `group_id`, `ip_address`, `active`, `activation_code`, `created_on`, `last_login`, `username`) 
VALUES (1, :email, :password, :salt, 1, '', 1, '', :unix_now, :unix_now, :username);
	
CREATE TABLE IF NOT EXISTS `core_users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Super User Information';

INSERT INTO core_users SELECT * FROM {site_ref}_users;

DROP TABLE IF EXISTS `{site_ref}_profiles`;

CREATE TABLE `{site_ref}_profiles` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `bio` text COLLATE utf8_unicode_ci,
  `dob` int(11) DEFAULT NULL,
  `gender` set('m','f','') COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

INSERT INTO `{site_ref}_profiles` (`id`, `user_id`, `first_name`, `last_name`, `display_name`, `company`, `lang`)
VALUES (1, 1, :firstname, :lastname, :displayname, '', 'en');

CREATE TABLE IF NOT EXISTS {site_ref}_migrations (
  `version` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO {site_ref}_migrations VALUES (:migration);

CREATE TABLE IF NOT EXISTS `{site_ref}_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `slug` varchar(50) NOT NULL,
  `version` varchar(20) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `skip_xss` tinyint(1) NOT NULL,
  `is_frontend` tinyint(1) NOT NULL,
  `is_backend` tinyint(1) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `installed` tinyint(1) NOT NULL,
  `is_core` tinyint(1) NOT NULL,
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  INDEX `enabled` (`enabled`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `{session_table}` (
 `session_id` varchar(40) DEFAULT '0' NOT NULL,
 `ip_address` varchar(16) DEFAULT '0' NOT NULL,
 `user_agent` varchar(120) NOT NULL,
 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
 `user_data` text NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
