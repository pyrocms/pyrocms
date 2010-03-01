DROP TABLE IF EXISTS `asset`;

-- command split --

CREATE TABLE `asset` (
  `id` int(5) NOT NULL auto_increment,
  `folder_id` int(5) NOT NULL default '0',
  `user_id` int(5) NOT NULL default '1',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `filename` varchar(255) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  `extension` varchar(5) collate utf8_unicode_ci NOT NULL,
  `mimetype` varchar(255) collate utf8_unicode_ci NOT NULL,
  `width` int(5) default NULL COMMENT 'Width of type image in pixels',
  `height` int(5) default NULL COMMENT 'Height of type image in pixels',
  `filesize` int(11) NOT NULL default '0',
  `dateadded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Assets used in the wysiwyg image manager';

-- command split --

DROP TABLE IF EXISTS `asset_folder`;

-- command split --

CREATE TABLE `asset_folder` (
  `id` int(5) NOT NULL auto_increment,
  `user_id` int(5) NOT NULL default '1',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `smart` int(1) NOT NULL default '0',
  `dateadded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Asset folder categories';

-- command split --

DROP TABLE IF EXISTS `categories`;

-- command split --

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug - unique` (`slug`),
  UNIQUE KEY `title - unique` (`title`),
  KEY `slug - normal` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product and Supplier Categories';

-- command split --

DROP TABLE IF EXISTS `comments`;

-- command split --

CREATE TABLE `comments` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `is_active` tinyint(1) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `name` varchar(40) collate utf8_unicode_ci NOT NULL,
  `email` varchar(40) collate utf8_unicode_ci NOT NULL,
  `website` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `module` varchar(40) collate utf8_unicode_ci NOT NULL,
  `module_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created_on` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Comments by users or guests';

-- command split --

DROP TABLE IF EXISTS `emails`;

-- command split --

CREATE TABLE `emails` (
  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `registered_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='E-mail addresses for newsletter subscriptions';

-- command split --

DROP TABLE IF EXISTS `navigation_groups`;

-- command split --

CREATE TABLE `navigation_groups` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Navigation groupings. Eg, header, sidebar, footer, etc';

-- command split --

DROP TABLE IF EXISTS `navigation_links`;

-- command split --

CREATE TABLE `navigation_links` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `link_type` VARCHAR( 20 ) collate utf8_unicode_ci NOT NULL default 'uri',
  `page_id` int(11) NOT NULL default '0',
  `module_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '', 
  `uri` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `navigation_group_id` int(5) NOT NULL default '0',
  `position` int(5) NOT NULL default '0',
  `target` varchar(10) NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `navigation_group_id - normal` (`navigation_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Links for site navigation';

-- command split --

DROP TABLE IF EXISTS `news`;

-- command split --

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `category_id` int(11) NOT NULL,
  `attachment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `intro` text collate utf8_unicode_ci NOT NULL,
  `body` text collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL default 0,
  `status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `category_id - normal` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='News articles or blog posts.';

-- command split --

DROP TABLE IF EXISTS `newsletters`;

-- command split --

CREATE TABLE `newsletters` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `body` text collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) default NULL,
  `sent_on` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Newsletter emails stored before being sent then archived her';

-- command split --

DROP TABLE IF EXISTS `page_layouts`;

-- command split --

CREATE TABLE `page_layouts` (
`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` VARCHAR( 60 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`css` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`updated_on` INT( 11 ) NOT NULL
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Store shared page layouts & CSS';

-- command split --

DROP TABLE IF EXISTS `pages`;

-- command split --

CREATE TABLE `pages` (
 `id` int(11) unsigned NOT NULL auto_increment,
 `slug` varchar(60) collate utf8_unicode_ci NOT NULL default '',
 `title` varchar(60) collate utf8_unicode_ci NOT NULL default '',
 `body` text collate utf8_unicode_ci NOT NULL,
 `parent_id` int(11) default '0',
 `layout_id` varchar(255) collate utf8_unicode_ci NOT NULL default 'default',
 `css` text collate utf8_unicode_ci,
 `meta_title` varchar(255) collate utf8_unicode_ci NOT NULL,
 `meta_keywords` varchar(255) collate utf8_unicode_ci NOT NULL,
 `meta_description` text collate utf8_unicode_ci NOT NULL,
 `status` ENUM( 'draft', 'live' ) collate utf8_unicode_ci NOT NULL DEFAULT 'draft', 
 `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
 PRIMARY KEY  (`id`),
 UNIQUE KEY `Unique` (`slug`,`parent_id`),
 KEY `slug` (`slug`),
 KEY `parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages';

-- command split --

DROP TABLE IF EXISTS `pages_lookup`;

-- command split --

CREATE TABLE `pages_lookup` (
  `id` int(11) NOT NULL,
  `path` text character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lookup table for page IDs and page paths.';

-- command split --

DROP TABLE IF EXISTS `permission_roles`;

-- command split --

CREATE TABLE `permission_roles` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc';

-- command split --

DROP TABLE IF EXISTS `permission_rules`;

-- command split --

CREATE TABLE `permission_rules` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `permission_role_id` int(11) NOT NULL,
  `module` varchar(50) collate utf8_unicode_ci NOT NULL,
  `controller` varchar(50) collate utf8_unicode_ci NOT NULL,
  `method` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission rules for permission roles';

-- command split --

DROP TABLE IF EXISTS `photo_albums`;

-- command split --

CREATE TABLE `photo_albums` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL default '0',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Unique` ( `slug` , `parent` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Photo albums contain photos';

-- command split --

DROP TABLE IF EXISTS `photos`;

-- command split --

CREATE TABLE `photos` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `album_id` int(11) NOT NULL,
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `description` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `order` INT(11)  NOT NULL default '0',
  `updated_on` INT(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contains photos...';

-- command split --

DROP TABLE IF EXISTS `profiles`;

-- command split --

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `bio` text collate utf8_unicode_ci NOT NULL default '',
  `dob` int(11) NOT NULL default '0',
  `gender` set('m','f','') collate utf8_unicode_ci NOT NULL default '',
  `phone` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `mobile` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `address_line1` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `address_line2` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `address_line3` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `postcode` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `msn_handle` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `aim_handle` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `yim_handle` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `gtalk_handle` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `gravatar` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `updated_on` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Extra data for users. Not always enabled';

-- command split --

DROP TABLE IF EXISTS `settings`;

-- command split --

CREATE TABLE `settings` (
  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `type` set('text','textarea','password','select','select-multiple','radio','checkbox') collate utf8_unicode_ci NOT NULL,
  `default` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  `options` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `is_gui` tinyint(1) NOT NULL,
  `module` varchar(50) collate utf8_unicode_ci NOT NULL,
PRIMARY KEY  (`slug`),
UNIQUE KEY `unique - slug` (`slug`),
KEY `index - slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores all sorts of settings for the admin to change';

-- command split --

DROP TABLE IF EXISTS `users`;

-- command split --

CREATE TABLE `users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `salt` varchar(5) collate utf8_unicode_ci NOT NULL default '',
  `first_name` varchar(40) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `role` varchar(40) collate utf8_unicode_ci NOT NULL,
  `lang` varchar(2) collate utf8_unicode_ci NOT NULL,
  `ip` varchar(11) collate utf8_unicode_ci NOT NULL,
  `is_active` int(1) NOT NULL,
  `activation_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registered User Information';

-- command split --

DROP TABLE IF EXISTS `variables`;

-- command split --

CREATE TABLE `variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;