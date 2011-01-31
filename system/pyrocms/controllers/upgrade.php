<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @name 		Upgrade Controller
 * @author 		PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Controllers
 */
class Upgrade extends Controller
{
	private $versions = array('0.9.9.1', '0.9.9.2', '0.9.9.3', '0.9.9.4', '0.9.9.5', '0.9.9.6', '0.9.9.7', '1.0.0-beta1', '1.0.0-beta2', '1.0.0', '1.0.1');

	private $_output = '';

	function _remap()
	{
  		$this->load->database();
  		$this->load->dbforge();

		// The version of the db is defined by a 'version' setting
		$db_version = $this->settings->version;

		// What version is the file system running (this is the target version to upgrade to)
  		$file_version = CMS_VERSION > '1.0.1' ? '1.0.1' : CMS_VERSION; // Only upgrade to 1.0.0

		// What is the base version of the db, no rc/beta tags.
		list($base_db_version) = explode('-', $db_version);

		if ( ! $db_version)
		{
			show_error('We have no idea what version you are using, which means something has gone seriously wrong. Please contact support@pyrocms.com.');
		}

		// Upgrade is already done
  		if ($db_version == $file_version)
  		{
  			show_error('Looks like the upgrade is already complete, you are already running v'.$db_version.'.');
  		}

		// File version is not supported
  		if ( ! in_array($file_version, $this->versions))
  		{
  			show_error('The upgrade script does not support version '.$file_version.'.');
  		}

		// DB is ahead of files
		else if ( $base_db_version > $file_version )
		{
			show_error('The database is expecting v'.$db_version.' but the version of PyroCMS you are using is v'.$file_version.'. Try downloading a newer version from ' . anchor('http://pyrocms.com/') . '.');
		}

		$this->_output .= '<style>* { font-family: arial; background-color: #E6E6E6; }</style>';

  		while($db_version != $file_version)
  		{
	  		// Find the next version
	  		$pos = array_search($db_version, $this->versions) + 1;
	  		$next_version = isset($this->versions[$pos]) ? $this->versions[$pos] : NULL;

			// next version is not supported
			$next_version or @show_error('The upgrade script does not support version '.$file_version.'.');

  			// Run the method to upgrade that specific version
	  		$function = 'upgrade_' . preg_replace('/[^0-9a-z]/i', '', $next_version);

			// If a method exists and its false fail. no method = no changes
	  		if (method_exists($this, $function) AND $this->$function() !== TRUE)
	  		{
				echo $this->_output;
	  			echo '<strong style="color:red">There was an error upgrading to "'.$next_version.'".</strong>';
				exit;
	  		}

	  		$this->settings->version = $next_version;

			$this->_output .= "<p><strong>-- Upgraded to " . $next_version . '--</strong></p>';

	  		$db_version = $next_version;
  		}

		$this->_output .= "<p>The upgrade is complete, please " . anchor('admin', 'click here') . ' to go back to the Control Panel.</p>';

		// finally, spit it out
		echo $this->_output;
 	}

	// Last time upgrade will ever need to be run
	function upgrade_101()
	{
		$this->load->library('migrations');
		$this->migrations->latest();

		$this->settings->version = CMS_VERSION;

		exit("Migrated to the latest version of the database. This upgrade script is no longer required, when you or anyone visits your website (frontend or Control Panel) it will automatically upgrade to the latest version.");
	}

	function upgrade_100()
	{
		$this->db->query('ALTER TABLE `news`
							DROP INDEX `title` ,
							ADD UNIQUE INDEX `slug` USING BTREE (`slug`);');

		$this->db->where('1', 1, FALSE);
		$this->db->delete('modules');

		// Loop through directories that hold modules
		$is_core = TRUE;

		foreach (array(APPPATH, ADDONPATH) as $directory)
    	{
    		// Loop through modules
	        foreach (glob($directory.'modules/*', GLOB_ONLYDIR) as $module_name)
	        {
				$slug = basename($module_name);

				$this->_output .=  'Re-indexing new module: <strong>' . $slug .'</strong>.<br/>';

				$path = $is_core ? APPPATH : ADDONPATH;

				// Before we can install anything we need to know some details about the module
				$details_file = $path . 'modules/' . $slug . '/details'.EXT;

				// Check the details file exists
				if ( ! is_file($details_file))
				{
					$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: File '.$details_file.' does not exist.</span><br/>';
					continue;
				}

				// Sweet, include the file
				include_once $details_file;

				// Now call the details class
				$class_name = 'Module_'.ucfirst(strtolower($slug));

				if ( ! class_exists($class_name))
				{
					$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: Class '.$class_name.' does not exist in file '.$details_file.'.</span><br/>';
					continue;
				}

				$details_class = new $class_name;

				// Get some basic info
				$module = $details_class->info();

				// Looks like it installed ok, add a record
				$this->db->insert('modules', array(
					'name' => serialize($module['name']),
					'slug' => $slug,
					'version' => $details_class->version,
					'description' => serialize($module['description']),
					'skip_xss' => !empty($module['skip_xss']),
					'is_frontend' => !empty($module['frontend']),
					'is_backend' => !empty($module['backend']),
					'menu' => !empty($module['menu']) ? $module['menu'] : FALSE,
					'enabled' => TRUE,
					'installed' => TRUE,
					'is_core' => $is_core
				));
			}

			// Going back around, 2nd time is addons
			$is_core = FALSE;
        }

		if ($page_layouts = $this->db->get('page_layouts')->result())
		{
			$this->_output .= 'Re-writing page layouts to use new tags.<br />';

			foreach ($page_layouts as $layout)
			{
				$layout->body = str_replace(array(
					'{$page.body}',
					'{$page.title}'
				), array(
					'{pyro:page:body}',
					'{pyro:page:title}'
				), $layout->body);

				$this->db
					->where('id', $layout->id)
					->update('page_layouts', array('body' => $layout->body));
			}
		}

		// Does a table contain a field?
		if ($pages = $this->db->get('revisions')->result())
		{
			$this->_output .= 'Re-writing old style links to use the new pages plugin.<br />';

			foreach ($pages as $revision)
			{
				preg_match_all('/\{page_url(\[|\()([0-9]+)(\]|\))\}/', $revision->body, $tags);

				$replace_from = $replace_to = array();

				for ($i = 0; $i < count($tags[0]);++ $i)
				{
					$replace_from[] = $tags[0][$i];
					$replace_to[] = '{pyro:pages:url id=\''.$tags[2][$i].'\'}';
				}

				$replace_from AND $revision->body = str_replace($replace_from, $replace_to, $revision->body);

				$this->db
					->where('id', $revision->id)
					->update('revisions', array('body' => $revision->body));
			}
		}

		$this->cache->delete_all('pages_m');
		
		$this->_output .= 'Adding "class" field to navigation.<br/>';

		// Not a foolproof method of column detection, but unless they have no entries in the db it'll be fine
		$nav = $this->db->get('navigation_links', 1)->row();

		if ( ! isset($nav->class))
		{
			$this->db->query("ALTER TABLE `navigation_links`
				ADD `class` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL default '' AFTER `target`");

			$this->cache->delete_all('navigation_m');
		}

		$this->_output .= 'Setting "Dashboard RSS Feed" will now show in the Settings page.<br/>';

		$this->db
			->where('slug', 'dashboard_rss')
			->update('settings', array('is_gui' => 1));

		//fix the unserialize() error
		$this->_output .= 'Correcting translation errors in the redirects module.<br />';

		$this->db
			->where('slug', 'redirects')
			->update('modules', array('description' => 'a:3:{s:2:"nl";s:38:"Verwijs vanaf een URL naar een andere.";s:2:"en";s:33:"Redirect from one URL to another.";s:2:"fr";s:34:"Redirection d\'une URL à un autre.";}'));

		// move newsletters to utilities
		$this->_output .= 'Moving Newsletter module to Utilities menu.<br />';

		$this->db->where('slug', 'newsletters')
				->update('modules', array('menu'=>'utilities'));

		// put the missing groups module record back in the modules table
		$this->_output .= 'Reactivating the groups module.<br />';

		return TRUE;
	}

	function upgrade_100beta2()
	{
		// Does a table contain a field?
		if ( ! isset($this->db->limit(1)->get('pages')->row()->js))
		{
			$this->_output .= 'Adding missing pages.js field.<br />';

			$this->db->query("ALTER TABLE `pages` ADD `js` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `css`");

			// pages.js was previously ignored from the upgrade
			$pages = $this->db->get('pages_old')->result();

			foreach ($pages as $page)
			{
				if ($page->js)
				{
					$this->db
						->where('js', '')
						->where('id', $page->id)
						->update('pages', array('js' => $page->js));
				}
			}

			$this->_output .= 'Clearing page cache.<br/>';
			$this->cache->delete_all('pages_m');
		}

		$this->_output .= 'Moving Google Tracking code from Comments to Integration.<br/>';

		$this->db
			->where('slug', 'ga_tracking')
			->update('settings', array('module' => 'integration'));

		// ------------- Assets conversion ------------------
		if ($this->db->table_exists('asset_folder'))
		{
			$this->_output .= 'Moving assets images to Files';

			$asset_folder = $this->db->get('asset_folder')->row();

			//insert the folder record
			$folder = $this->db->insert('file_folders', array(
				'slug' => 'assets-images',
				'name' => 'Assets Images',
				'date_added' => strtotime($asset_folder->dateadded)
			));

			//get all the images and put them in the files table
			$asset_images = $this->db->get('asset')->result();

			foreach ($asset_images as $image)
			{
				$this->db->insert('files', array(
					'folder_id' 	=> $folder,
					'user_id' 	=> $image->user_id,
					'type'		=> 'i',
					'name'		=> $image->name,
					'filename'	=> $image->filename,
					'description'	=> $image->description,
					'extension'	=> $image->extension,
					'mimetype'	=> $image->mimetype,
					'width'		=> $image->width,
					'height'	=> $image->height,
					'filesize'	=> $image->filesize,
					'date_added'	=> strtotime($image->dateadded)
				));

				//copy image to files folder
				copy('./uploads/assets/'.$image->id.$image->extension, './uploads/files/'.$image->filename);

			}
			//all good, drop the old assets tables
			$this->dbforge->drop_table('asset');
			$this->dbforge->drop_table('asset_folder');

            $this->_output .= '<span style="color:#339999"> -- Assets images were successfully moved to Files but you will need to re-insert all images in your pages using the wysiwyg editor.</span><br/>';
		}
		// ------------End Assets conversion ----------------

		return TRUE;
	}

	function upgrade_100beta1()
	{
		// ---- first upgrade the Modules table -------------
		$this->dbforge->modify_column('modules', array(
			'is_backend_menu' 	=> 	array(
				'name' => 'menu',
				'type' => 'varchar',
				'constraint' => '20',
				'default' => 'FALSE'
			)
		));

		$this->dbforge->modify_column('settings', array(
			'type' 	=> 	array(
				'name' => 'type',
				'type' => 'varchar',
				'constraint' => '20',
			)
		));

		$this->dbforge->add_column('modules', array(
			'installed' 	=>	array(
				'type' => 'tinyint',
				'constraint' => '1',
				'default' => '1'
			)
		));

		$this->dbforge->drop_column('modules', 'controllers');

		//get rid of old modules and modules that need to be reinstalled
		$this->db->delete('modules', array('slug' => 'permissions'));
		$this->db->delete('modules', array('slug' => 'categories'));
		$this->db->delete('modules', array('slug' => 'twitter'));
		$this->db->delete('modules', array('slug' => 'tinycimm'));

		// ---- now install any new modules -----------------
		$is_core = TRUE;
		foreach (array(APPPATH, ADDONPATH) as $directory)
    	{
    		// Loop through modules
	        foreach (array('categories', 'files', 'permissions', 'galleries', 'groups', 'redirects') as $slug)
	        {
				//don't reinstall a module
				if ( ! is_dir($directory.'modules/'.$slug)) continue;

				echo 'Installing new module: <strong>' . $slug .'</strong>.<br/>';

				$path = $is_core ? APPPATH : ADDONPATH;

				// Before we can install anything we need to know some details about the module
				$details_file = $path . 'modules/' . $slug . '/details'.EXT;

				// Check the details file exists
				if ( ! is_file($details_file))
				{
					$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: File '.$details_file.' does not exist.</span><br/>';
					continue;
				}

				// Sweet, include the file
				include_once $details_file;

				// Now call the details class
				$class_name = 'Module_'.ucfirst(strtolower($slug));

				if ( ! class_exists($class_name))
				{
					$this->_output .= '<span style="color:red">Error with <strong>' . $slug .'</strong>: Class '.$class_name.' does not exist in file '.$details_file.'.</span><br/>';
					continue;
				}

				$details_class = new $class_name;

				// TURN ME ON BABY!
				$this->db->where('slug', $slug)->update('modules', array('enabled' => 1));

				// Run the install method to get it into the database
				$details_class->install();
			}

			// Going back around, 2nd time is addons
			$is_core = FALSE;
        }

		// ---- Settings ------------------------------------

		// Rename tracking code setting
		$this->db
			->where('slug', 'google_analytic')
			->update('settings', array('slug' => 'ga_tracking', 'title' => 'Google Tracking Code', 'description' => 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing.'));

		$this->_output .= 'Adding more Google Analytic Settings.<br/>';

		$this->db->insert('settings', array(
			'slug' => 'ga_email',
			'title' => 'Google Analytic E-mail',
			'description' => 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.',
			'`default`' => '',
			'`value`' => '',
			'type' => 'text',
			'`options`' => '',
			'is_required' => 0,
			'is_gui' => 1,
			'module' => 'integration'
		));

		$this->db->insert('settings', array(
			'slug' => 'ga_password',
			'title' => 'Google Analytic Password',
			'description' => 'Google Analytics password. This is also needed this to show the graph on the dashboard.',
			'`default`' => '',
			'`value`' => '',
			'type' => 'password',
			'`options`' => '',
			'is_required' => 0,
			'is_gui' => 1,
			'module' => 'integration'
		));

		$this->db->insert('settings', array(
			'slug' => 'ga_profile',
			'title' => 'Google Analytic Profile ID',
			'description' => 'Profile ID for this website in Google Analytics.',
			'`default`' => '',
			'`value`' => '',
			'type' => 'text',
			'`options`' => '',
			'is_required' => 0,
			'is_gui' => 1,
			'module' => 'integration'
		));

		// ---- Widgets -------------------------------------

		$this->db
			->where('slug', 'widgets')
			->update('modules', array('menu'=>'content'));

		// ---- / End Widgets -------------------------------

		// ---- Variables -----------------------------------

		$this->db->where('slug', 'variables')
				->update('modules', array('menu'=>'content'));

		// ---- / End Variables -----------------------------

		// ---- Newsletters ---------------------------------

		$this->db->where('slug', 'newsletters')
				->update('modules', array('menu'=>'users'));

		// ---- / End Newsletters ---------------------------

		// ---- Navigation ----------------------------------

		$this->db->where('slug', 'navigation')
				->update('modules', array('menu'=>'design'));

		// ---- / End Navigation ----------------------------

		// ---- Themes --------------------------------------

		$this->db->where('slug', 'themes')
				->update('modules', array('menu'=>'design'));

		// ---- / End Themes --------------------------------

		// ---- Comments ------------------------------------

		$this->_output .= "Adding/updating comment settings.<br/>";

		// set module for moderate_comments to comments
		$this->db->where('slug', 'moderate_comments')
				->update('settings', array('module'=>'comments'));

		$comment_sort_setting = "
			INSERT INTO `settings` (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`) VALUES
			 ('comment_order', 'Comment Order', 'Sort order in which to display comments.', 'select', 'ASC', 'ASC', 'ASC=Oldest First|DESC=Newest First', '1', '1', 'comments')
			 ";

		$this->db->query($comment_sort_setting);

		// set menu location
		$this->db->where('slug', 'comments')
				->update('modules', array('menu'=>'content'));

		// ---- / End Comments ------------------------------

		// ---- Adding SMTP support for emails

		$insert_mail_settings = "
			INSERT INTO `settings` (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`)
			VALUES ('mail_protocol', 'Mail Protocol', 'Select desired email protocol.', 'select', 'mail', 'mail', 'mail=Mail|sendmail=Sendmail|smtp=SMTP', '1', '1', ''),
			('mail_sendmail_path', 'Sendmail Path', 'Path to server sendmail binary.', 'text', '', '', '', '0', '1', ''),
			('mail_smtp_host', 'SMTP Host Name', 'The host name of your smtp server.', 'text', '', '', '', '0', '1', ''),
			('mail_smtp_user', 'SMTP User Name', 'SMPT user name.', 'text', '', '', '', '0', '1', ''),
			('mail_smtp_pass', 'SMTP Password', 'SMPT password.', 'text', '', '', '', '0', '1', ''),
			('mail_smtp_port', 'SMTP Port', 'SMPT port number.', 'text', '', '', '', '0', '1', '');
			";
		$this->db->query($insert_mail_settings);

		// ------ End SMTP support for emails

		// ---- News ----------------------------------------

		$this->dbforge->rename_table('categories', 'news_categories');

		// set menu location
		$this->db->where('slug', 'news')
				->update('modules', array('menu'=>'content', 'is_core'=>'1'));

		// ---- / End News ----------------------------------


		// ---- Permissions ---------------------------------

		//clean up after the old permissions module
		$this->dbforge->drop_table('permission_roles');
		$this->dbforge->drop_table('permission_rules');

		// set menu location
		$this->db->where('slug', 'permissions')
				->update('modules', array('menu'=>'users'));

		// ---- / End Permissions ---------------------------


		// set menu location
		$this->db->where('slug', 'groups')
				->update('modules', array('menu'=>'users'));

		// ---- / End Groups --------------------------------


		// ---- Profiles ------------------------------------

		// Add the website column to the profiles table
	    $this->dbforge->add_column('profiles', array(
	        'website' => array(
	            'type'        => 'varchar',
	            'constraint'  => '255',
	            'null'        => TRUE
	        )
	    ));

		// ---- / End Profiles ------------------------------


		// ---- Upgrade Photos to Galleries -----------------

		$photo_albums = $this->db->get('photo_albums');

		// We have a shiny new galleries table, lets put something in it
		foreach ($photo_albums->result() as $album)
		{
			$this->_output .=  'Moving album <strong>"' . $album->title .'"</strong> from photos to galleries.<br/>';
			// prep the galleries info
			$to_insert = array(
				'id'					=> $album->id,
				'title'					=> $album->title,
				'slug'					=> $album->slug,
				'description'			=> $album->description,
				'parent'				=> $album->parent,
				'updated_on'			=> $album->updated_on,
				'enable_comments'		=> $album->enable_comments,
				'published'				=> '1'
			 );

			// Create the gallery record
			if ($this->db->insert('galleries', $to_insert))
			{
				//time for the images (woot!)
				$photos = $this->db->get_where('photos', array('album_id' => $album->id));

				foreach ($photos->result() as $photo)
				{
					// prep the image filenames
					$file = explode('.', $photo->filename);

					$filename = $file[0];

					//create the full size image folder
					if (!file_exists('./uploads/galleries/'.$album->slug.'/full'))
					{
						mkdir('./uploads/galleries/'.$album->slug.'/full', 0755, TRUE);
					}

					//copy image to galleries folder
					@copy(APPPATH.'assets/img/photos/'.$album->id.'/'.$file[0].'.'.$file[1], './uploads/galleries/'.$album->slug.'/full/'.$filename.'.'.$file[1]);

					//create the thumbnail folder
					if (!file_exists('./uploads/galleries/'.$album->slug.'/thumbs'))
					{
						mkdir('./uploads/galleries/'.$album->slug.'/thumbs', 0755, TRUE);
					}
					//copy thumbnail to galleries folder
					copy(APPPATH.'assets/img/photos/'.$album->id.'/'.$file[0].'_thumb.'.$file[1], './uploads/galleries/'.$album->slug.'/thumbs/'.$filename.'.'.$file[1]);

					$photo_to_insert = array(
						'id'					=> $photo->id,
						'gallery_id'			=> $photo->album_id,
						'filename'				=> $filename,
						'extension'				=> '.'.$file[1],
						'description'			=> $photo->caption,
						'updated_on'			=> $photo->updated_on
					 );

					$this->db->insert('gallery_images', $photo_to_insert);
				}
			}
		}

		//we got this far without erroring out, lets pull the plug on the photos module
		$this->dbforge->drop_table('photo_albums');
		$this->dbforge->drop_table('photos');
		$this->db->delete('modules', array('slug' => 'photos'));
		// ---- / End Upgrade Photos to Galleries -----------


		// ---- Page Conversion ----------------------------
		$this->_output .= "Upgrading pages to the new module.<br/>";

		// First we need to retrieve the current content from the pages table so no data gets lost
		$pages = $this->db->get('pages')->result();

		// We need to make sure no data gets lost, therefore we're renaming the pages table to pages_old
		$this->dbforge->rename_table('pages', 'pages_old');

	    // We can now recreate the pages table
	    $this->db->query("CREATE TABLE `pages` (
	      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	      `revision_id` int(11) NOT NULL DEFAULT '0',
	      `slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      `parent_id` int(11) DEFAULT '0',
	      `layout_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	      `css` text COLLATE utf8_unicode_ci,
	      `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	      `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	      `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
	      `rss_enabled` int(1) NOT NULL DEFAULT '0',
	      `comments_enabled` int(1) NOT NULL DEFAULT '0',
	      `status` enum('draft','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
	      `created_on` int(11) NOT NULL DEFAULT '0',
	      `updated_on` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	      PRIMARY KEY (`id`),
	      UNIQUE KEY `Unique` (`slug`,`parent_id`),
	      KEY `slug` (`slug`),
	      KEY `parent` (`parent_id`)
	    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Editable Pages'
	    ");

	    // Now that the new pages table has been created it's time to create the revisions table
	    $this->db->query("CREATE TABLE `revisions` (
	      `id` int(11) NOT NULL AUTO_INCREMENT,
	      `owner_id` int(11) NOT NULL,
	      `table_name` varchar(100) NOT NULL DEFAULT 'pages',
	      `body` text,
	      `revision_date` int(11) NOT NULL,
	      `author_id` int(11) NOT NULL,
	      PRIMARY KEY (`id`),
	      KEY `Owner ID` (`owner_id`)
	    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
	    ");

	    // So far so good, time to migrate the old data back to the new table
	    foreach ($pages as $page)
	    {
	        // Page data
	        $to_insert = array(
	            'id'                => $page->id,
				'revision_id'       => $page->id,
	            'slug'              => $page->slug,
	            'title'             => $page->title,
	            'parent_id'         => $page->parent_id,
	            'layout_id'         => $page->layout_id,
	            'css'               => $page->css,
	            'meta_title'        => $page->meta_title,
	            'meta_keywords'     => $page->meta_keywords,
	            'meta_description'  => $page->meta_description,
	            'rss_enabled'       => $page->rss_enabled,
	            'comments_enabled'  => $page->comments_enabled,
	            'status'            => $page->status,
	            'created_on'        => $page->created_on,
	            'updated_on'        => $page->updated_on,
	         );

	        // Insert the page
	        $this->db->insert('pages', $to_insert);
	        $page_insert_id = $this->db->insert_id();

			//the versioning lib gives up on large websites
			//so we're just doing an insert instead
			$revision_data = array(
				'id'			=> $page->id,
				'owner_id'		=> $page_insert_id,
				'table_name'	=> 'pages',
				'body'			=> $page->body,
				'revision_date' => now(),
				'author_id' 	=> 1,
			);

	        // Insert the one and only revision for this page
	        $this->db->insert('revisions', $revision_data);

	    }

		// set menu location
		$this->db
			->where('slug', 'pages')
			->update('modules', array('menu'=>'content'));

		// ---- / End Pages ---------------------------------


		// Clear some caches
		$this->_output .= "Clearing the module cache.<br/>";
		$this->cache->delete_all('module_m');

	    return TRUE;
	}

	function upgrade_0997()
	{
		$this->_output .= 'Page titles can have longer names and slugs.<br />';
		$this->db->query("ALTER TABLE `pages` CHANGE `slug` `slug` varchar(255) collate utf8_unicode_ci NOT NULL default ''");
		$this->db->query("ALTER TABLE `pages` CHANGE `title` `title` varchar(255) collate utf8_unicode_ci NOT NULL default ''");

		$this->_output .= 'Removed default value from pages js field.<br />';
		$this->db->query("ALTER TABLE `pages` CHANGE `js` `js` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");

		$this->_output .= 'Added "preview" field to photo_albums table.<br/>';
		$this->dbforge->add_column('photo_albums', array(
			'enable_comments' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0,
				'null' => FALSE
			)
		));

		return TRUE;
	}

	function upgrade_0996()
	{
		$this->_output .= 'Disabling XSS cleaning for pages.<br />';
		$this->db->where('slug', 'pages');
		$this->db->update('modules', array('skip_xss' => 1));

		return TRUE;
	}

	function upgrade_0995()
	{
		$this->_output .= 'Fixed theme_layout in strict mode.<br />';
		$this->dbforge->modify_column('page_layouts', array(
			'theme_layout' => array(
				'name' => 'theme_layout',
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => FALSE,
				'default' => ''
			),
		));

		return TRUE;
	}

	function upgrade_0994()
	{
		$this->_output .= 'Added "preview" field to photo_albums table.<br/>';
		$this->dbforge->add_column('photo_albums', array(
			'preview' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => '',
				'null' => FALSE
			),
		));

		$this->_output .= 'Fixing broken TinyCIMM record in Permissions list.<br/>';
		$this->db
			->set('name', 'a:4:{s:2:"en";s:8:"TinyCIMM";s:2:"fr";s:8:"TinyCIMM";s:2:"de";s:8:"TinyCIMM";s:2:"pl";s:8:"TinyCIMM";}')
			->where('slug', 'tinycimm')
			->update('modules');

		$this->_output .= 'Added "js" field to pages table.<br/>';
		$this->dbforge->add_column('pages', array(
			'js' => array(
				'type' => 'TEXT',
				'default' => '',
				'null' => FALSE
			),
		));

		$this->_output .= 'Clearing page cache.<br/>';
		$this->cache->delete_all('pages_m');

		$this->_output .= 'Clearing module cache.<br/>';
		$this->cache->delete_all('module_m');

		return TRUE;
	}

	function upgrade_0993()
	{
		$this->db->where('slug', 'dashboard_rss')->update('settings', array('`default`' => 'http://feeds.feedburner.com/pyrocms-installed'));

		$this->_output .= 'Updated user_id in permission_rules to accept 0 as a value.<br/>';
		$this->db->query('ALTER TABLE permission_rules CHANGE user_id user_id int(11) NOT NULL DEFAULT 0');

		$this->_output .= 'Adding Twitter token fields to user profiles<br />';
		$this->dbforge->add_column('profiles', array(
			'twitter_access_token' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'twitter_access_token_secret' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
		));

		$this->_output .= 'Adding twitter consumer key settings<br />';
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key', 'title' => 'Consumer Key', 'description' => 'Twitter Consumer Key.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));
		$this->db->insert('settings', array('slug' => 'twitter_consumer_key_secret', 'title' => 'Consumer Key Secret', 'description' => 'Twitter Consumer Key Secret.', 'type' => 'text', 'is_required' => 0, 'is_gui' => 1, 'module' => 'twitter'));

		return TRUE;
	}

	function upgrade_0992()
	{
		$this->_output .= 'Added missing theme_layout field to page_layouts table.<br />';
		$this->dbforge->add_column('page_layouts', array(
			'theme_layout' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => FALSE
			),
		));

		return TRUE;
	}
}