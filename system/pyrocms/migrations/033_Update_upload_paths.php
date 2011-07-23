<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_upload_paths extends Migration {

	public function up()
	{
		if ($chunks = $this->db->get('page_chunks')->result())
		{
			foreach ($chunks as $chunk)
			{
				// Change upload paths to point images to the site ref folder
				$chunk->body = str_replace('uploads/', 'uploads/'.SITE_REF.'/', $chunk->body);
				
				// Remove any crazy old 0.9.8 literal tags that might be sat around
				$chunk->body = str_replace(array('{literal}', '{/literal}'), '', $chunk->body);

				$this->db
					->where('id', $chunk->id)
					->update('page_chunks', array('body' => $chunk->body));
			}
		}
	}

	public function down()
	{
		
	}
}