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
		$create = $this->dbforge->add_field(array(
			'robots_id' => array(
				'type'				=> 'INT',
				'constraint'		=> 5,
				'auto_increment'	=> TRUE
			),
			'sites_id' => array(
				'type'				=> 'INT',
				'constraint'		=> 5,
			),
			'site_ref' => array(
				'type'				=>'VARCHAR',
				'constraint'		=> '255',
			),
			'txt' => array(
				'type'				=> 'TEXT',
				'null'				=> TRUE,
			),
		))->add_key('robots_id', TRUE)->add_key('sites_id', TRUE)->create_table('core_robots', TRUE);
		
		$txt = "";
		$txt .= "# www.robotstxt.org/\n";
		$txt .= "# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449\n";
		$txt .= "User-agent: *\n";
		$txt .= "Allow: /\n";
		$txt .= "Sitemap: " . site_url('sitemap.xml');
		
		$site = $this->db->where('ref',$this->site_ref)->row('core_sites');
		$insert = $this->db->insert('core_robots',array(
			'robots_id'	=>	NULL,
			'sites_id'	=>	$site->id,
			'site_ref'	=>	$this->site_ref,
			'txt'		=>	$txt,
		));
		
		if($create AND $insert)
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$delete = $this->db->where('site_ref', $this->site_ref)->delete('core_robots');
		if($delete)
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		$delete = $this->db->where('site_ref', $this->site_ref)->delete('core_robots');
		
		$create = $this->dbforge->add_field(array(
			'robots_id' => array(
				'type'				=> 'INT',
				'constraint'		=> 5,
				'auto_increment'	=> TRUE
			),
			'sites_id' => array(
				'type'				=> 'INT',
				'constraint'		=> 5,
			),
			'site_ref' => array(
				'type'				=>'VARCHAR',
				'constraint'		=> '255',
			),
			'txt' => array(
				'type'				=> 'TEXT',
				'null'				=> TRUE,
			),
		))->add_key('robots_id', TRUE)->add_key('sites_id', TRUE)->create_table('core_robots', TRUE);
		
		$txt = "";
		$txt .= "# www.robotstxt.org/\n";
		$txt .= "# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449\n";
		$txt .= "User-agent: *\n";
		$txt .= "Allow: /\n";
		$txt .= "Sitemap: " . site_url('sitemap.xml');
		
		$site = $this->db->where('ref',$this->site_ref)->row('core_sites');
		$insert = $this->db->insert('core_robots',array(
			'robots_id'	=>	NULL,
			'sites_id'	=>	$site->id,
			'site_ref'	=>	$this->site_ref,
			'txt'		=>	$txt,
		));
		
		if($delete AND $create AND $insert)
		{
			return TRUE;
		}
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */