<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
// Company: Cloudmanic Labs, http://cloudmanic.com
// By: Spicer Matthews, spicer@cloudmanic.com
// Date: 9/17/2011
// Description: Example class / method for building custom 
//							authenticated urls for Rackspace. 
//

class Rackspace_Cf_Url
{
	function get_url($cont, $file, $seconds)
	{
		return site_url("/files/rackspace/$cont/$seconds/$file");
	}
}

/* End File */