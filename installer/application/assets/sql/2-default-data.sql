truncate `navigation_groups`;
insert into `navigation_groups` values
 ('1','Header','header'),
 ('2','Sidebar','sidebar'),
 ('3','Footer','footer');

truncate `pages`;
insert into `pages` values('1','home','Home','Welcome to our homepage. We have not quite finished setting up our website just yet, but please add us to your bookmarks and come back soon.','0','EN','default','','','','1219336535');
	
truncate `permission_roles`;
insert into `permission_roles` values
 ('1','Administator','admin'),
 ('2','User','user');

truncate `settings`;
insert into `settings` values 
 ('site_name','Site Name','The name of the website for page titles and for use around the site.','text','Un-named Website','','','1','1',''),
 ('site_slogan','Site Slogan','The slogan of the website for page titles and for use around the site.','text','Add your slogan here','','','0','1',''),
 ('contact_email','Contact E-mail','All e-mails from users, guests and the site will go to this e-mail address.','text','admin@localhost','','','1','1',''),
 ('server_email','Server E-mail','All e-mails to users will come from this e-mail address.','text','admin@localhost','','','1','1',''),
 ('meta_topic','Meta Topic','Two or three words describing this type of company/website.','text','Content Management','','','0','1',''),
 ('currency','Currency','The currency symbol for use on products, services, etc.','text','&pound;','','','1','1',''),
 ('captcha_enabled','Use Captcha','Captcha boxes are used to make sure spammers and other unwanted fake guests do not abuse input forms.','radio','1','','1=Enabled|0=Disabled','0','1',''),
 ('captcha_folder','Captcha Folder','Where should captcha image files be stored?','text','application/cache/captcha/','','','0','1',''),
 ('frontend_enabled','Site Status','Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenence','radio','1','','1=Open|0=Closed','1','1',''),
 ('unavailable_message','Unavailable Message','When the site is turned off or there is a major problem, this message will show to users.','textarea','Sorry, this website is currently unavailable.','','','0','1',''),
 ('default_theme','Default Theme','Select the theme you want users to see by default.','','advertising','','get_themes','1','0',''),
 ('activation_email','Activation Email','Send out an e-mail when a user signs up with an activation link. Disable this to let only admins activate accounts.','radio','1','','1=Enabled|0=Disabled','0','1',''),
 ('records_per_page','Records Per Page','How many records should we show per page in the admin section?','select','25','','10=10|25=25|50=50|100=100','1','1',''),
 ('rss_feed_items','Feed item count','How many items should we show in RSS/news feeds?','select','25','','10=10|25=25|50=50|100=100','1','1',''),
 ('require_lastname','Require last names?','For some situations, a last name may not be required. Do you want to force users to enter one or not?','radio','1','','1=Required|0=Optional','1','1',''),
 ('enable_profiles','Enable profiles','Allow users to add and edit profiles.','radio','1','','1=Enabled|0=Disabled','1','1','users'),
 ('google_analytic','Google Analytic','Enter your analytic key to activate Google Analytic.','text','','','','0','1','statistics'),
 ('twitter_username','Username','Twitter username.','text','','','','0','1','twitter'),
 ('twitter_password','Password','Twitter password.','password','','','','0','1','twitter'),
 ('twitter_news','Twitter &amp; News integration.','Would you like to post links to new news articles on Twitter?','radio','0','','1=Enabled|0=Disabled','0','1','twitter'),
 ('twitter_feed_count','Feed Count','How many tweets should be returned to the Twitter feed block?','text','5','','','0','1','twitter'),
 ('twitter_cache', 'Cache time', 'How many minutes should your Tweets be temporairily stored for?','text','300','','','0','1','twitter');

truncate `users`;
insert into `users` values('1','demo@example.com','8cd2e9971eeea0b7a5afcd810270fa605bde14e8','vQwbJ','Demo','User','admin','EN','','1','','1220982658','1238925784');