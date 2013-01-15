<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * There is an instance where your streams will not have an ordering_count
 * column if upgrading from 2.0 to 2.2. This fixes that issue by going through
 * all streams and checking to make sure that there is an ordering count column.
 */
class Migration_Streams_ordering_sweep extends CI_Migration
{
    public function up()
    {
    	// Go through each stream
    	$streams = $this->db->get('data_streams')->result();

    	foreach ($streams as $stream)
    	{
			// Table name
			$table = $stream->stream_prefix.$stream->stream_slug;

			if ( ! $this->db->field_exists('ordering_count', $table))
			{
			    $columns = array(
			        'ordering_count' => array(
			                    'type' => 'int',
			                    'null' => true,
			                    'constraint' => 11
			                ),
			    );
			    $this->dbforge->add_column($table, $columns);
			}
    	}
    }

    public function down()
    {
        return true;
    }
}