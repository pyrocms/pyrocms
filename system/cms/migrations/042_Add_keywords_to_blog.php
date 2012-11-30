<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_keywords_to_blog extends CI_Migration {

	public function up()
	{	
		$this->dbforge->add_column('blog', array(
			'keywords' => array(
				'type'			=> 'char',
				'constraint'	=> 32,
				'null'			=> false,
			)
		));
	}

	public function down()
	{
		$this->dbforge->drop_table('keywords, keywords_applied');
	}
}