<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This is a Robots module for PyroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	PyroCMS
 * @subpackage 	Robots Module
 */
class Module_Robots extends Module {

	public $version = '1.0.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Robots',
				'nl' => 'Robots'
			),
			'description' => array(
				'en' => 'This is a Robots.txt module.',
				'nl' => 'Dit is een robots.txt module voor PyroCMS'

			),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'utilities',
			'author'	=> 'Jaap Jolman',
		
			'roles'		=> array(
				'admin_robots'
			),
			
			'sections' => array(
			    'robots' => array(
				    'name'		=> 'robots:menu:overview',
				    'uri'		=> 'admin/robots',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'robots:menu:overview',
						   'uri'	=> 'admin/robots',
						   'class'	=> 'list'
						)
					)
				)
			)
		);
	}

	public function install()
	{
		$txt = "";
		$txt .= "# www.robotstxt.org/\n";
		$txt .= "# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449\n";
		$txt .= "User-agent: *\n";
		$txt .= "Allow: /\n";
		$txt .= "Sitemap: " . site_url('sitemap.xml');
		
		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `core_robots` (
				`robots_id` INT NOT NULL AUTO_INCREMENT ,
				`sites_id` INT(5) NOT NULL ,
				`site_ref` VARCHAR(255) NOT NULL ,
				`txt` TEXT,
				PRIMARY KEY (`robots_id`, `sites_id`) )
			ENGINE = InnoDB;");
		
		$this->db->query("INSERT INTO `core_robots` (robots_id, sites_id, site_ref, txt) VALUES (null,(SELECT `id` FROM `core_sites` WHERE ref='" . $this->site_ref . "'), '" . $this->site_ref . "', '" . $txt . "');");
		return TRUE;
	}

	public function uninstall()
	{
		$this->db->query("DELETE FROM `core_robots` WHERE sites_id=(SELECT `id` FROM `core_sites` WHERE ref='" . $this->site_ref . "');");
		$this->db->delete('settings', array('module' => 'store'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		
		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `core_robots` (
				`robots_id` INT NOT NULL AUTO_INCREMENT ,
				`sites_id` INT(5) NOT NULL ,
				`site_ref` VARCHAR(255) NOT NULL ,
				`txt` TEXT,
				PRIMARY KEY (`robots_id`, `sites_id`) )
			ENGINE = InnoDB;");
			
		$this->db->query("DELETE FROM `core_robots` WHERE sites_id=(SELECT `id` FROM `core_sites` WHERE ref='" . $this->site_ref . "');");
		$this->db->delete('settings', array('module' => 'store'));
		{
			$uninstall = TRUE;
		}
		
		
		$txt = "";
		$txt .= "# www.robotstxt.org/\n";
		$txt .= "# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449\n";
		$txt .= "User-agent: *\n";
		$txt .= "Allow: /\n";
		$txt .= "Sitemap: " . site_url('sitemap.xml');
		
		$this->db->query("INSERT INTO `core_robots` (robots_id, sites_id, site_ref, txt) VALUES (null,(SELECT `id` FROM `core_sites` WHERE ref='" . $this->site_ref . "'), '" . $this->site_ref . "', '" . $txt . "');");
		$install = TRUE;
		
		if($uninstall == TRUE AND $install == TRUE):
			
			return TRUE;
			
		endif;
		
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */