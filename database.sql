SET character_set_client = utf8;
SET character_set_connection = utf8;
-- Resume the schemas structure --

drop table if exists `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug - unique` (`slug`),
  UNIQUE KEY `title - unique` (`title`),
  KEY `slug - normal` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product and Supplier Categories';

-- --------------------------------------------------------

drop table if exists `comments`;

CREATE TABLE `comments` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `name` varchar(40) collate utf8_unicode_ci NOT NULL,
  `email` varchar(40) collate utf8_unicode_ci NOT NULL,
  `body` text collate utf8_unicode_ci NOT NULL,
  `module` varchar(40) collate utf8_unicode_ci NOT NULL,
  `module_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created_on` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Comments by users or guests';

-- --------------------------------------------------------

drop table if exists `emails`;

CREATE TABLE `emails` (
  `email` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `registered_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='E-mail addresses for newsletter subscriptions';

-- --------------------------------------------------------

drop table if exists `galleries`;

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL default '0',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Galleries (like categories) for photos';

-- --------------------------------------------------------

drop table if exists `navigation_links`;

CREATE TABLE `navigation_links` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `page_id` int(11) NOT NULL default '0',
  `module_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `uri` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `navigation_group_id` int(5) NOT NULL default '0',
  `position` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Links for site navigation';

insert into `navigation_links` values
 ('1','Home','1','','','','1','1'),
 ('2','About','2','','','','1','2'),
 ('3','Home','1','','','','2','1'),
 ('4','News','','news','','','2','2'),
 ('5','Photos','','galleries','','','2','3'),
 ('6','Services','','services','','','2','4'),
 ('7','Products','','products','','','2','5'),
 ('8','Suppliers','','suppliers','','','2','6'),
 ('9','Home','1','','','','3','1');

-- --------------------------------------------------------

drop table if exists `navigation_groups`;

CREATE TABLE `navigation_groups` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Navigation groupings. Eg, header, sidebar, footer, etc';

insert into `navigation_groups` values
 ('1','Header','header'),
 ('2','Sidebar','sidebar'),
 ('3','Footer','footer');

-- --------------------------------------------------------

drop table if exists `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `category_id` int(11) NOT NULL,
  `attachment` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `intro` text collate utf8_unicode_ci NOT NULL,
  `body` text collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL,
  `status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='News articles or blog posts.';

-- --------------------------------------------------------

drop table if exists `newsletters`;

CREATE TABLE `newsletters` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `body` text collate utf8_unicode_ci NOT NULL,
  `created_on` int(11) default NULL,
  `sent_on` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Newsletter emails stored before being sent then archived here too';

-- --------------------------------------------------------

drop table if exists `packages`;

CREATE TABLE `packages` (
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `featured` enum('Y','N') collate utf8_unicode_ci NOT NULL default 'N',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`slug`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Packages contain services and products';

-- --------------------------------------------------------

drop table if exists `pages`;

CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `body` text collate utf8_unicode_ci NOT NULL,
  `parent` int(11) default '0',
  `lang` varchar(2) collate utf8_unicode_ci NOT NULL,
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Language Unique` (`slug`,`lang`),
  KEY `slug` (`slug`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages';

INSERT INTO `pages` (`id`,`slug`,`title`,`body`,`lang`,`updated_on`,`parent`) VALUES ('1','home','Home','Welcome to our homepage. We have not quite finished setting up our website just yet, but please add us to your bookmarks and come back soon.<br /><br />You could also subscribe to your news letter, or add our RSS feed on the news page to keep up to date with goings on.<br />','EN','1219336535','0');
INSERT INTO `pages` (`id`,`slug`,`title`,`body`,`lang`,`updated_on`,`parent`) VALUES ('2','about','About','Here you can put a little info about what this site will do.\n<br />','EN','1204726000','0');

-- --------------------------------------------------------

drop table if exists `permission_roles`;

CREATE TABLE `permission_roles` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `abbrev` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc';

insert into `permission_roles` values('1','Administator','admin'),
 ('2','Staff','staff'),
 ('3','Moderator','mod'),
 ('4','User','user');

-- --------------------------------------------------------

drop table if exists `permission_rules`;

CREATE TABLE `permission_rules` (
  `id` int(11) NOT NULL auto_increment,
  `permission_role_id` int(11) NOT NULL,
  `module` varchar(50) collate utf8_unicode_ci NOT NULL,
  `controller` varchar(50) collate utf8_unicode_ci NOT NULL,
  `method` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission rules for permission roles';

-- --------------------------------------------------------

drop table if exists `photos`;

CREATE TABLE `photos` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `gallery_slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `description` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contains photos...';

-- --------------------------------------------------------

drop table if exists `products`;

CREATE TABLE `products` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `price` float NOT NULL default '0',
  `category_slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `supplier_slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `frontpage` enum('Y','N') collate utf8_unicode_ci NOT NULL default 'N',
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `supplier_slug` (`supplier_slug`),
  KEY `category_slug` (`category_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product Information';

-- --------------------------------------------------------

drop table if exists `products_images`;

CREATE TABLE `products_images` (
  `image_id` int(15) NOT NULL auto_increment,
  `filename` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `product_id` smallint(5) unsigned NOT NULL default '0',
  `for_display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Product Images';

-- --------------------------------------------------------

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `bio` text collate utf8_unicode_ci NOT NULL,
  `dob` int(11) NOT NULL,
  `gender` set('m','f','') NOT NULL,
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
  `updated_on` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Extra data for users. Not always enabled';

-- --------------------------------------------------------

drop table if exists `services`;

CREATE TABLE `services` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `slug` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  `price` float(11,2) NOT NULL,
  `pay_per` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Services are just pages with prices involved';

-- --------------------------------------------------------

drop table if exists `settings`;

CREATE TABLE `settings` (
  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
  `title` varchar(100) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `type` set('text','textarea','select','select-multiple','radio','checkbox') NOT NULL,
  `default` varchar(255) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  `options` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `is_gui` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores all sorts of settings for the admin to change';

insert into `settings` values ("site_name","Site Name","The name of the website for page titles and for use around the site.","text","Un-named Website","","","1","1");
insert into `settings` values ("site_slogan","Site Slogan","The slogan of the website for page titles and for use around the site.","text","Add your slogan here","","","0","1");
insert into `settings` values ("contact_email","Contact E-mail","All e-mails from users, guests and the site will go to this e-mail address.","text","admin@localhost","","","1","1");
insert into `settings` values ("server_email","Server E-mail","All e-mails to users will come from this e-mail address.","text","admin@localhost","","","1","1");
insert into `settings` values ("meta_keywords","Meta Keywords","Descriptive words seperated by comma to be read by search engines.","text","cms, styledna, website management, content management system","","","0","1");
insert into `settings` values ("meta_topic","Meta Topic","Two or three words describing this type of company/website.","text","Content Management","Content Management","","0","1");
insert into `settings` values ("meta_description","Meta Description","A short paragraph describing this website.","textarea","A website made using StyleDNA's CMS. Full description goes here.","","","0","1");
insert into `settings` values ("currency","Currency","The currency symbol for use on products, services, etc.","text","£","","","1","1");
insert into `settings` values ("captcha_enabled","Use Captcha","Captcha boxes are used to make sure spammers and other unwanted fake guests do not abuse input forms.","radio","1","","1=Enabled|0=Disabled","0","1");
insert into `settings` values ("captcha_folder","Captcha Folder","Where should captcha image files be stored?","text","temp/captcha/","","","0","1");
insert into `settings` values ("frontend_enabled","Site Status","Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence","radio","1","","1=Open|0=Closed","1","1");
insert into `settings` values ("unavailable_message","Unavailable Message","When the site is turned off or there is a major problem, this message will show to users.","textarea","Sorry, this website is currently unavailable.","","","0","1");
insert into `settings` values ("default_theme","Default Theme","Select the theme you want users to see by default.","","advertising","","get_themes","1","0");
insert into `settings` values ("activation_email","Activation Email","Send out an e-mail when a user signs up with an activation link. Disable this to let only admins activate accounts.","radio","1","","1=Enabled|0=Disabled","0","1");
insert into `settings` values ("records_per_page","Records Per Page","How many records should we show per page in the admin section?","select","25","","10=10|25=25|50=50|100=100","1","1");
insert into `settings` values ("rss_feed_items","Feed item count","How many items should we show in RSS/news feeds?","select","25","","10=10|25=25|50=50|100=100","1","1");
insert into `settings` values ("require_lastname","Require last names?","For some situations, a last name may not be required. Do you want to force users to enter one or not?","radio","1","","1=Required|0=Optional","1","1");
insert into `settings` values ("enable_profiles","Enable profiles","Allow users to add and edit profiles.","radio","1","","1=Enabled|0=Disabled","1","1");

-- --------------------------------------------------------

drop table if exists `staff`;

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
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Staff Member information (similar to a profile, but independant of profiles module)';

-- --------------------------------------------------------

drop table if exists `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL auto_increment,
  `slug` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `description` text collate utf8_unicode_ci NOT NULL,
  `url` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `image` varchar(40) collate utf8_unicode_ci default NULL,
  `updated_on` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Supplier Information';

-- --------------------------------------------------------

drop table if exists `suppliers_categories`;

CREATE TABLE `suppliers_categories` (
  `supplier_id` int(11) NOT NULL default '0',
  `category_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

drop table if exists `users`;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registered User Information';

insert into `users` values(1,'demo@example.com','8cd2e9971eeea0b7a5afcd810270fa605bde14e8','vQwbJ','Demo','User','admin','EN','','1','','1220982658','0');