<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings model
 * 
 * @author		Salmane
 * @package		PyroCMS\Core\Modules\Blog\Models
 */
class Blog_settings_m extends MY_Model
{

	public function set_config()
	{
		$blog_settings = $this->db
						 ->select('slug,value')
						 ->where(array('module' => 'blog'))
						 ->get('settings')
						 ->result();
		
		$file	=	"<?php defined('BASEPATH') OR exit('No direct script access allowed');\r\n";
		
		foreach ($blog_settings as $setting) {
		
    	$file	.=	"\$config['".$setting->slug."']= '".$setting->value."';\r\n";
    	
    	}
    	
    	$file	.=	"/* End of file blog.php */";

		$path = './system/cms/modules/blog/config/blog.php';
		
		$this->load->helper('file');
		
		@write_file($path, $file);
	}
	public function set_routes()
	{
		
		$blog_settings = $this->db
						 ->select('slug,value')
						 ->where(array('module' => 'blog','slug'=>'blog_uri'))
						 ->get('settings')
						 ->row();
						 
		$blog_uri=$blog_settings->value;				 
						 
		$categories = $this->db->get( 'blog_categories' )->result();				 					 
		
		$file	=	"<?php defined('BASEPATH') OR exit('No direct script access allowed');\r\n";
    	
    	$file	.=	"\$route['blog/rss/all.rss']='blog/rss/index';\r\n";

		if ($blog_uri==null) {
			
			$file	.=	"\$route['default_controller'] = 'blog';\r\n";
		
		} else {
		
			$file	.=	"\$route['".$blog_uri."']	= 'blog';\r\n";
			
			$blog_uri = $blog_uri."/";
			
		}
		
		foreach( $categories as $category ) {
		    
		    $file	.=	"\$route['".$blog_uri.$category->slug."/(:num)?']	= 'blog/category/".$category->slug."/\$2';\r\n"; 
		    $file	.=	"\$route['".$blog_uri.$category->slug."/(:any)?']	= 'blog/view/\$1';\r\n"; 
		    $file	.=	"\$route['".$blog_uri.$category->slug."']= 'blog/category/".$category->slug."';\r\n";
		}

		$file	.=	"\$route['".$blog_uri."search']					= 'blog/search';\r\n";
		$file	.=	"\$route['".$blog_uri."tagged/(:any)?']			= 'blog/tagged/\$1';\r\n";
		$file	.=	"\$route['".$blog_uri."rss/all.rss']			= 'blog/rss/index';\r\n";
		$file	.=	"\$route['".$blog_uri."(:num)?']				= 'blog/index/$1';\r\n";
		$file	.=	"\$route['".$blog_uri."rss/(:any).rss']		    = 'blog/rss/category/\$1';\r\n";
			
		// admin
		$file	.=	"\$route['blog/admin/categories(/:any)?']		= 'admin_categories$1';\r\n";
	
    	$file	.=	"/* End of file routes.php */";	
		
		$path = './system/cms/modules/blog/config/routes.php';
		
		$this->load->helper('file');
		
		@write_file($path, $file);
	}	
}