<?php

class Migration_Add_entry_type_to_pages extends CI_Migration
{
    public function up()
    {	
    	// The try catch block will suppress errors if the column exists
    	// This is a simple solution since schema->hasColumn still has issues with enum types
    	// and the pages table status column is an enum
    	try {
    		
			$schema = ci()->pdb->getSchemaBuilder();
			$prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

			$schema->table('pages', function($table) {
				// 60 for stream_slug + 60 for stream_namespace + 2 for divider = 122 character limit
				$success = $table->string('entry_type', 122)->after('entry_id'); 
			});

			$page_types = ci()->pdb->table('page_types')
				->join('data_streams', 'page_types.stream_id', '=', 'data_streams.id')
				->select('page_types.id', 'data_streams.stream_slug', 'data_streams.stream_namespace')
				->get();

			// Update the pages entry types
			foreach ($page_types as $type)
			{
				ci()->pdb->table('pages')
					->where('type_id', $type->id)
					->update(array('entry_type' => $type->stream_slug.'.'.$type->stream_namespace));
			}
			
			return true;

    	} catch (Exception $e) {

    		log_message('error', 'Migration_Add_entry_type_to_pages exception: '.$e->getMessage());

    		return false;
    	}
    }

    public function down()
    {
    	try {
	    	
	    	$schema = ci()->pdb->getSchemaBuilder();
	    	$prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

			$schema->table('pages', function($table) {
				$table->dropColumn('entry_type');
			});

			return true;

    	} catch (Exception $e) {

    		log_message('error', 'Migration_Add_entry_type_to_pages exception: '.$e->getMessage());

    		return false;
    	}
    }
}