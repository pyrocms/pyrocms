CREATE TABLE `core_sites` (
    `id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `ref` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `domain` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `created_on` INT(11) NOT NULL default '0',
    `updated_on` INT(11) NOT NULL default '0',
    UNIQUE KEY `Unique ref` (`ref`),
    UNIQUE KEY `Unique domain` (`domain`),
    KEY `ref` (`ref`),
    KEY `domain` (`domain`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- command split --

DROP TABLE IF EXISTS `{PREFIX}users`;

-- command split --

CREATE TABLE IF NOT EXISTS `{PREFIX}users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registered User Information';

-- command split --

INSERT INTO `{PREFIX}users` (`id`, `email`, `password`, `salt`, `group_id`, `ip_address`, `active`, `activation_code`, `created_on`, `last_login`, `username`, `forgotten_password_code`, `remember_code`) VALUES
    (1,'{EMAIL}', '{PASSWORD}', '{SALT}', 1, '', 1, '', {NOW}, {NOW}, '{USER-NAME}', NULL, NULL);

-- command split --

CREATE TABLE core_users SELECT * FROM {PREFIX}users;

-- command split --

DROP TABLE IF EXISTS `{PREFIX}profiles`;

-- command split --

CREATE TABLE IF NOT EXISTS `{PREFIX}profiles` (
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
  `msn_handle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yim_handle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aim_handle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gtalk_handle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_access_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_access_token_secret` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- command split --
			
INSERT INTO `{PREFIX}profiles` (`id`, `user_id`, `first_name`, `last_name`, `display_name`, `company`, `lang`, `bio`, `dob`, `gender`, `phone`, `mobile`, `address_line1`, `address_line2`, `address_line3`, `postcode`, `msn_handle`, `yim_handle`, `aim_handle`, `gtalk_handle`, `gravatar`, `updated_on`) VALUES
    (1, 1, '{FIRST-NAME}', '{LAST-NAME}', '{DISPLAY-NAME}', '', 'en', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- command split --

CREATE TABLE {PREFIX}schema_version (
  `version` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- command split --

INSERT INTO {PREFIX}schema_version VALUES ('{MIGRATION}');