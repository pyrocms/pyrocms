<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_page_chunk_class extends CI_Migration
{
	public function up()
	{
		// Make null false
		$this->dbforge->modify_column('page_chunks', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => false),
		));

		// Add class field
		$this->dbforge->add_column('page_chunks', array(
			'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '', 'after' => 'slug'),
		));

		$chunks = $this->db->get('page_chunks')->result();

		foreach ($chunks as $chunk)
		{
			$this->db
				->where('id', $chunk->id)
				->update('page_chunks', array(

					// People have been using these as classes, so take the first "class" to reuse
					'slug' => current(explode(' ', $chunk->slug)),

					// Set the class as whatever slug used to be
					'class' => $chunk->slug,
				)
			);
		}
	}

	public function down()
	{
		// Put the default back to ''
		$this->dbforge->modify_column('page_chunks', array(
			'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
		));

		// Remove the class field
		if ( $this->db->field_exists('class', 'page_chunks'))
		$this->dbforge->drop_column('page_chunks', 'class');
	}
}