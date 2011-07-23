<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_upload_paths_in_blog extends Migration {

	public function up()
	{
		if ($articles = $this->db->get('blog')->result())
		{
			foreach ($articles as $article)
			{
				// Change upload paths to point images to the site ref folder
				$article->body = str_replace('uploads/', 'uploads/'.SITE_REF.'/', $article->body);
				
				// Remove any crazy old 0.9.8 literal tags that might be sat around
				$article->body = str_replace(array('{literal}', '{/literal}'), '', $article->body);

				$this->db
					->where('id', $article->id)
					->update('blog', array('body' => $article->body));
			}
		}
	}

	public function down()
	{
		
	}
}