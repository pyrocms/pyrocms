<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_stream_file_ids extends CI_Migration
{
    public function up()
    {
        // Image ids are now 15 character hashes, and not IDs. We need to
        // update that.

        // Get all of our image and file field types
        $fields = $this->db->where('field_type', 'image')->or_where('field_type', 'file')->get('data_fields')->result();

        foreach ($fields as $field)
        {
            // Get the assignments
            $assignments = $this->db
                                    ->from('data_field_assignments')
                                    ->where('data_field_assignments.field_id', $field->id)
                                    ->join('data_streams', 'data_streams.id = data_field_assignments.stream_id')
                                    ->get()->result();

            // Go through each assignment and convert into a 15
            // length char string.
            foreach ($assignments as $assign)
            {
                $columns = array(
                    $field->field_slug => array(
                        'type' => 'CHAR',
                        'constraint' => 15,
                        'null' => true
                    )
                );
                $this->dbforge->modify_column($assign->stream_prefix.$assign->stream_slug, $columns);
            }
        }

    }

    public function down()
    {
        return true;
    }
}