SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug - unique` (`slug`),
  UNIQUE KEY `title - unique` (`title`),
  KEY `slug - normal` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product and Supplier Categories';


CREATE TABLE `comments` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `is_active` tinyint(1) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `name` varchar(40) collate utf8_unicode_ci NOT NULL,
  `email` varchar(40) collate utf8_unicode_ci NOT NULL,
  `body` text collate utf8_unicode_ci NOT NULL,
  `module` varchar(40) collate utf8_unicode_ci NOT NULL,
  `module_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created_on` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Comments by users or guests';


CREATE TABLE `emails` (
  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `registered_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='E-mail addresses for newsletter subscriptions';


CREATE TABLE `galleries` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL default '0',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Galleries (like categories) for photos';


CREATE TABLE `navigation_groups` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Navigation groupings. Eg, header, sidebar, footer, etc';


CREATE TABLE `navigation_links` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `page_id` int(11) NOT NULL default '0',
  `module_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `uri` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `navigation_group_id` int(5) NOT NULL default '0',
  `position` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `navigation_group_id - normal` (`navigation_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Links for site navigation';


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


CREATE TABLE `newsletters` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `body` text collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) default NULL,
  `sent_on` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Newsletter emails stored before being sent then archived her';


CREATE TABLE `packages` (
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `featured` enum('Y','N') collate utf8_unicode_ci NOT NULL default 'N',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL  default '0',
  PRIMARY KEY  (`slug`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Packages contain services and products';


CREATE TABLE `pages` (
 `id` int(11) unsigned NOT NULL auto_increment,
 `slug` varchar(60) collate utf8_unicode_ci NOT NULL default '',
 `title` varchar(60) collate utf8_unicode_ci NOT NULL default '',
 `body` text collate utf8_unicode_ci NOT NULL,
 `parent_id` int(11) default '0',
 `lang` varchar(2) collate utf8_unicode_ci NOT NULL,
 `layout_file` varchar(255) collate utf8_unicode_ci NOT NULL default 'default',
 `meta_title` varchar(255) collate utf8_unicode_ci NOT NULL,
 `meta_keywords` varchar(255) collate utf8_unicode_ci NOT NULL,
 `meta_description` text collate utf8_unicode_ci NOT NULL,
 `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
 PRIMARY KEY  (`id`),
 KEY `slug` (`slug`),
 KEY `parent` (`parent_id`),
 KEY `Unique` (`slug`,`parent_id`,`lang`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages';



CREATE TABLE `permission_roles` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc';


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


CREATE TABLE `photos` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `gallery_slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `description` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contains photos...';


CREATE TABLE `products` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL default '0',
  `category_slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `supplier_slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `frontpage` enum('Y','N') collate utf8_unicode_ci NOT NULL default 'N',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `supplier_slug` (`supplier_slug`),
  KEY `category_slug` (`category_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product Information';


CREATE TABLE `products_images` (
  `image_id` int(15) NOT NULL auto_increment,
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `product_id` smallint(5) unsigned NOT NULL default '0',
  `for_display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product Images';


CREATE TABLE `profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `bio` text collate utf8_unicode_ci NOT NULL,
  `dob` int(11) NOT NULL,
  `gender` set('m','f','') collate utf8_unicode_ci NOT NULL,
  `phone` varchar(20) collate utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) collate utf8_unicode_ci NOT NULL,
  `address_line1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line3` varchar(255) collate utf8_unicode_ci NOT NULL,
  `postcode` varchar(20) collate utf8_unicode_ci NOT NULL,
  `msn_handle` varchar(100) collate utf8_unicode_ci NOT NULL,
  `aim_handle` varchar(100) collate utf8_unicode_ci NOT NULL,
  `yim_handle` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gtalk_handle` varchar(100) collate utf8_unicode_ci NOT NULL,
  `gravatar` varchar(100) collate utf8_unicode_ci NOT NULL,
  `updated_on` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Extra data for users. Not always enabled';


CREATE TABLE `services` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL  default '0',
  `price` float(11,2) NOT NULL,
  `pay_per` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Services are just pages with prices involved';


CREATE TABLE `settings` (
  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `type` set('text','textarea','select','select-multiple','radio','checkbox') collate utf8_unicode_ci NOT NULL,
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


CREATE TABLE `staff` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `user_id` int(11) NOT NULL,
  `name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(40) collate utf8_unicode_ci NOT NULL,
  `position` varchar(40) collate utf8_unicode_ci default NULL,
  `body` text collate utf8_unicode_ci NOT NULL,
  `fact` text collate utf8_unicode_ci,
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Staff Member information (similar to a profile, but independ';


CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `url` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `image` varchar(40) collate utf8_unicode_ci default NULL,
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Supplier Information';


CREATE TABLE `suppliers_categories` (
  `supplier_id` int(11) NOT NULL default '0',
  `category_id` int(11) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


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