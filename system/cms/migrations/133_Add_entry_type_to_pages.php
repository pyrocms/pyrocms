<?php

use Pyro\Module\Streams\Stream\StreamModel;

class Migration_Add_entry_type_to_pages extends CI_Migration
{
    public function up()
    {	    		
		$schema = ci()->pdb->getSchemaBuilder();

		$schema->table('pages', function($table) use ($schema) {
			// 60 for stream_slug + 60 for stream_namespace + 2 for divider = 122 character limit
			if (! $schema->hasColumn($table->getTable(), 'entry_type')) {
				$table->string('entry_type', 122)->after('entry_id'); 	
			}
		});

		$page_types = ci()->pdb->table('page_types')
			->join('data_streams', 'page_types.stream_id', '=', 'data_streams.id')
			->select('page_types.id', 'data_streams.stream_slug', 'data_streams.stream_namespace')
			->get();

		// Update the pages entry types
		foreach ($page_types as $type)
		{
			ci()->pdb
                ->table('pages')
				->where('type_id', $type->id)
				->update(array(
                    'entry_type' => StreamModel::getEntryModelClass($type->stream_slug, $type->stream_namespace)
                ));
		}
		
		return true;
    }

    public function down()
    {
		$schema = ci()->pdb->getSchemaBuilder();

		$schema->table('pages', function($table) use ($schema) {
			if ($schema->hasColumn($table->getTable(), 'entry_type')) {
				$table->dropColumn('entry_type');
			}
		});

		return true;
    }
}