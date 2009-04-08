<?php
/**
 * SPAW Editor v.2 Main include file
 * 
 * Include this file in your script
 *
 * Edited for use with the CodeIgniter framework. Use in your controller like so: $this->load->library('spaw', $config);
 * Where $config is an array containing the name for your SPAW instance and content for the editor upon loading.
 *   
 * @package spaw2
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra   
 */ 
session_start();
require_once('spaw2/config/config.php');
require_once('spaw2/class/editor.class.php');
class Spaw extends SpawEditor
{
	var $instance;
	var $content;
	function Spaw($config)
	{
		$this->instance	= $config['name'];
		$this->content	= $config['content'];
		parent::SpawEditor($this->instance, $this->content);
		// load plugin configs
		$spaw_pgdir = SpawConfig::getStaticConfigValue('SPAW_ROOT').'plugins/';
		if (is_dir($spaw_pgdir)) 
		{
		  if ($spaw_dh = opendir($spaw_pgdir)) 
		  {
		    while (($spaw_pg = readdir($spaw_dh)) != false) 
		    {
		      if ($spaw_pg != '.' && $spaw_pg != '..')
		      {
		        if (is_dir($spaw_pgdir.$spaw_pg.'/config'))
		        {
		          if ($spaw_pgdh = opendir($spaw_pgdir.$spaw_pg.'/config')) 
		          {
		            while (($spaw_fn = readdir($spaw_pgdh)) !== false) 
		            {
		              if ($spaw_fn != '.' && $spaw_fn != '..' && !is_dir($spaw_pgdir.$spaw_pg.'/config/'.$spaw_fn))
		                include($spaw_pgdir.$spaw_pg.'/config/'.$spaw_fn);
		            }
		            closedir($spaw_pgdh);
		          }
		        }
		      }
		    }
		    closedir($spaw_dh);
		  }
		}
	}
	/**
   	 * Outputs editor's HTML code to the client
     */
  	function show()
  	{
    	print $this->getHtml();
  	}
}