<?php

/**
 * Convert the current blog table to streams.
 */
class Migration_Convert_blog_to_streams extends CI_Migration
{
    public function up()
    {
    	$this->load->driver('streams');

    	// Our canary in the coal mine is the blog entry in,
    	// the streams table. If we don't have that, we don't
    	// have anything and need to proceed with conversion.
		if ( ! $this->db
						->select('id')->limit(1)
						->where('stream_slug', 'blog')
						->where('stream_namespace', 'blogs')
						->get('data_streams')->row()
			)
		{
			// Create the stream from the blog table!
			// This will not alter any data, just add some new fields.
			// Note: We are going to start off with 'title' and 'created' as the 
			// fields that we show in the index.
			$this->streams->utilities->convert_table_to_stream('blog', 'blogs', null, 'lang:blog:blog_title', null, 'title', array('title', 'created'));

			// Now we are going to go through each row and copy the value of
			// 'created_on' and 'updated_on' into 'created' and 'updated'.
			// Streams needs created and updated to function, so we are going to
			// just transfer the values.
			$blogs = $this->db->select('id, created_on, author_id, updated_on')->get('blog')->result();
			foreach ($blogs as $blog)
			{
				$update = array(
					'created' 		=> date('Y-m-d H:i:s', $blog->created_on),
					'created_by'	=> $blog->author_id
				);

				if ($blog->updated_on > 0)
				{
					$update['updated'] = date('Y-m-d H:i:s', $blog->updated_on);
				}
			
				$this->db->limit(1)->where('id', $blog->id)->update('blog', $update);
			}

			// Make intro a stream column.
			$this->streams->utilities->convert_column_to_field('blog', 'blogs', 'lang:blog:intro_label', 'intro', 'wysiwyg', array('editor_type' => 'simple', 'allow_tags' => 'y'), array('required' => true));

			// That should do it. We are not doing any of the other fields
			// because they are being considered core blog fields.
		}
    }

    public function down()
    {
        return true;
    }
}


