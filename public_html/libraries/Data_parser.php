<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter Data Parser Class
 *
 * The Data_parser helper parses strings and replaces custom tags with PHP
 * 
 * @author		Philip Sturgeon
 * @email		phil@styledna.net
 * @filename	Data_parser.php
 * @title		Data Parser Class
 * @url			http://www.styledna.net/
 * @version		1.0
*/

class Data_parser {

	private $from = array();
	private $to = array();
	
	private $CI;
	
	function Data_parser() {
		$this->CI =& get_instance();
	}
	
	
	function parse($str) {
		
		preg_match_all('/{([_0-9a-zA-Z]+):([_\-\| 0-9a-zA-Z]+)}/', $str, $results);

		// For all found tags
		for($i=0;$i<count($results[0]); $i++) {
		
			$full_tag = $results[0][$i]; // Eg: {setting:site_name}
			$tag_type = $results[1][$i]; // Eg: setting
			$tag_params = $results[2][$i]; // Eg: site_name
			
			switch($tag_type):
				case 'setting':
				case 'link':
				case 'url':
					$this->from[] = $full_tag;
					$this->$tag_type($tag_params);
				break;
			endswitch;

		}
		
		return str_replace($this->from, $this->to, $str);
		
	}

	private function setting($setting) {
		$this->to[] = $this->CI->settings->item($setting);
	}
	
	private function link($params) {
		$this->CI->load->helper('url');
		
		list($link_url, $link_text)=explode('|', $params);

		$this->to[] = anchor($link_url, $link_text);
	}
	
	private function url($uri) {
		$this->CI->load->helper('url');
		$this->to[] = site_url($uri);
	}

}
?>