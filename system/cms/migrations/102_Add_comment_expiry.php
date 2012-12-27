<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_comment_expiry extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('blog', array(
			'comments_enabled' => array(
				'type' => 'set',
				'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'),
				'null' => false,
				'default' => 'always',
			),
		));

		$this->db->update('blog', array('comments_enabled' => '3 months'));

		// Lets update the comments table with these new awesome fields
		$this->dbforge->modify_column('comments', array(
			'module_id' => array(
				'name' => 'entry_id',
				'type' => 'varchar',
				'constraint' => 255,
				'null' => true,
			),
			'name' => array(
				'name' => 'user_name',
				'type' => 'varchar',
				'constraint' => 255,
			),
			'email' => array(
				'name' => 'user_email',
				'type' => 'varchar',
				'constraint' => 255,
			),
			'website' => array(
				'name' => 'user_website',
				'type' => 'varchar',
				'constraint' => 255,
				'null' => true,
			),
		));

		$this->dbforge->add_column('comments', array(
			'entry_title' => array(
				'type' => 'char',
				'constraint' => 255,
				'null' => false,
			),
			'entry_key' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false,
			),
			'entry_plural' => array(
				'type' => 'varchar',
				'constraint' => 100,
				'null' => false,
			),
			'uri' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => true,
			),
			'cp_uri' => array(
				'type' => 'varchar',
				'constraint' => 255,
				'null' => true,
			),
		));

		$comments = $this->db->get('comments')->result();

		foreach ($comments as &$comment)
		{
			// What did they comment on
			switch ($comment->module)
			{
				case 'gallery':
					$comment->module = plural($comment->module);
					break;
				case 'gallery-image':
					$comment->module = 'galleries';
					$ci->load->model('galleries/gallery_image_m');
					if ($item = $ci->gallery_image_m->get($comment->module_id))
					{
						continue 2;
					}
					break;
			}


			$this->load->model('addons/module_m');

			// Use the old comment logic to grab title names, then we can never have to use this junk again
			if (in_array($comment->module, array('blog', 'pages')))
			{
				// Grab an item 
				switch ($comment->module)
				{
					case 'blog':

						// Get this one article out of the db
						$item = $this->db->get_where('blog', array('id' => $comment->entry_id))->row();

						$comment->entry_title = $item->title;
						$comment->uri = 'blog/'.date('Y/m', $item->created_on).'/'.$item->slug;
						$comment->entry_key = 'blog:post';
						$comment->entry_plural = 'blog:posts';
						$comment->cp_uri = 'admin/'.$comment->module.'/preview/'.$item->id;
					break;

					case 'pages':

						// Get this one page out of the db
						$item = $this->db->get_where('pages', array('id' => $comment->entry_id))->row();

						$comment->entry_title = $item->title;
						$comment->uri = $item->uri;
						$comment->entry_key = 'pages:page';
						$comment->entry_plural = 'pages:pages';
						$comment->cp_uri = 'admin/'.$comment->module.'/preview/'.$item->id;
					break;
				}
			}
			else
			{
				$comment->entry_title = $comment->module .' #'. $comment->entry_id;
				$comment->entry_key = humanize(singular($comment->module));
				$comment->entry_plural = humanize(plural($comment->module));
			}

			// Save this comment again
			$this->db->where('id', $comment->id)->update('comments', $comment);
		}
	}
	
	public function down()
	{
		$this->dbforge->modify_column('blog', array(
			'comments_enabled' => array(
				'type' => "tinyint",
				'constraint' => 1,
				'null' => false,
				'default' => 1
			),
		));
	}
}