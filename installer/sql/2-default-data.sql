TRUNCATE `navigation_groups`;

-- command split --

INSERT INTO `navigation_groups` VALUES
 ('1','Header','header'),
 ('2','Sidebar','sidebar'),
 ('3','Footer','footer');
 
-- command split --

TRUNCATE navigation_links;

-- command split --

INSERT INTO navigation_links (title, link_type, page_id, navigation_group_id, position) VALUES
  ('Home', 'page', 1, 1, 1);

-- command split --

TRUNCATE `pages`;

-- command split --

INSERT INTO `page_layouts` (`id`, `title`, `body`, `css`, `updated_on`) VALUES
(1, 'Default', '<h2>{$page.title}</h2>\n\n\n{$page.body}', '', NOW());

-- command split --

TRUNCATE `pages`;

-- command split --

INSERT INTO `pages` (`id`, `slug`, `title`, `revision_id`, `parent_id`, `layout_id`, `status`, `created_on`, `updated_on`) VALUES
  ('1','home', 'Home', 1, 0, 1, 'live', NOW(), NOW()),
  ('2', '404', 'Page missing', 2, 0, '1', 'live', NOW(), NOW());

-- command split --

TRUNCATE `revisions`;

-- command split --

INSERT INTO `revisions` (`id`, `owner_id`, `body`, `revision_date`) VALUES
  ('1', '1', 'Welcome to our homepage. We have not quite finished setting up our website just yet, but please add us to your bookmarks and come back soon.', NOW()),
  ('2', '2', '<p>We cannot find the page you are looking for, please click <a title=\"Home\" href=\"{page_url(1)}\">here</a> to go to the homepage.</p>', NOW());

-- command split --

TRUNCATE `settings`;

-- command split --

INSERT INTO `settings` (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`) VALUES
 ('site_name','Site Name','The name of the website for page titles and for use around the site.','text','Un-named Website','','','1','1',''),
 ('site_slogan','Site Slogan','The slogan of the website for page titles and for use around the site.','text','Add your slogan here','','','0','1',''),
 ('contact_email','Contact E-mail','All e-mails from users, guests and the site will go to this e-mail address.','text','admin@localhost','','','1','1',''),
 ('server_email','Server E-mail','All e-mails to users will come from this e-mail address.','text','admin@localhost','','','1','1',''),
 ('meta_topic','Meta Topic','Two or three words describing this type of company/website.','text','Content Management','','','0','1',''),
 ('currency','Currency','The currency symbol for use on products, services, etc.','text','&pound;','','','1','1',''),
 ('dashboard_rss', 'Dashboard RSS Feed', 'Link to an RSS feed that will be displayed on the dashboard.', 'text', 'http://pyrocms.com/news/rss/all.rss', '', '', 0, 0, ''),
 ('dashboard_rss_count', 'Dashboard RSS Items', 'How many RSS items would you like to display on the dashboard ? ', 'text', '5', '5', '', 1, 1, ''),
 ('frontend_enabled','Site Status','Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence','radio','1','','1=Open|0=Closed','1','1',''),
 ('unavailable_message','Unavailable Message','When the site is turned off or there is a major problem, this message will show to users.','textarea','Sorry, this website is currently unavailable.','','','0','1',''),
 ('default_theme','Default Theme','Select the theme you want users to see by default.','','default','','get_themes','1','0',''),
 ('activation_email','Activation Email','Send out an e-mail when a user signs up with an activation link. Disable this to let only admins activate accounts.','radio','1','','1=Enabled|0=Disabled','0','1',''),
 ('records_per_page','Records Per Page','How many records should we show per page in the admin section?','select','25','','10=10|25=25|50=50|100=100','1','1',''),
 ('rss_feed_items','Feed item count','How many items should we show in RSS/news feeds?','select','25','','10=10|25=25|50=50|100=100','1','1',''),
 ('require_lastname','Require last names?','For some situations, a last name may not be required. Do you want to force users to enter one or not?','radio','1','','1=Required|0=Optional','1','1',''),
 ('enable_profiles','Enable profiles','Allow users to add and edit profiles.','radio','1','','1=Enabled|0=Disabled','1','1','users'),
 ('google_analytic','Google Analytic','Enter your analytic key to activate Google Analytic.','text','','','','0','1','statistics'),
 ('twitter_username','Username','Twitter username.','text','','','','0','1','twitter'),
 ('twitter_consumer_key','Consumer Key','Twitter consumer key.','text','','','','0','1','twitter'),
 ('twitter_consumer_key_secret','Consumer Key Secret','Twitter consumer key secret.','text','','','','0','1','twitter'),
 ('twitter_news','Twitter &amp; News integration.','Would you like to post links to new news articles on Twitter?','radio','0','','1=Enabled|0=Disabled','0','1','twitter'),
 ('twitter_feed_count','Feed Count','How many tweets should be returned to the Twitter feed block?','text','5','','','0','1','twitter'),
 ('twitter_cache', 'Cache time', 'How many minutes should your Tweets be temporairily stored for?','text','300','','','0','1','twitter'),
 ('akismet_api_key', 'Akismet API Key', 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.', 'text', '', '', '', 0, '1', 'integration'),
 ('moderate_comments', 'Moderate Comments', 'Force comments to be approved before they appear on the site.', 'select', '0', '', '1=Enabled|0=Disabled', '0', '1', ''),
 ('version', 'Version', '', 'text', 'v0.9.8', '__VERSION__', '', '0', '0', '');
	
-- command split --

TRUNCATE `groups`;

-- command split --

INSERT INTO `groups` (`id`, `title`, `name`, `description`) VALUES
(1, 'Administator', 'admin', NULL),
(2, 'User', 'user', NULL);

-- command split --

TRUNCATE `widget_areas`;

-- command split --

INSERT INTO widget_areas (slug, title) VALUES ('unsorted', 'Unsorted');
