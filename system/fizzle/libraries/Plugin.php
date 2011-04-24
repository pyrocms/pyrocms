<?php

class Plugin {

	public function get_param($key, $default = '')
	{
		if(isset($this->$key) or trim($this->$key) == ''):
		
			return $this->$key;
			
		else:
		
			return $default;
		
		endif;
	}

}

/* End of file Plugin.php */