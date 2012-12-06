<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update Pages for Streams/Page Types
 *
 * This migration replaces the existing page layout
 * structure with page types, which are built
 * on streams.
 */
class Update_pages_for_streams extends CI_Migration
{
    public function up()
    {
        return null;

        // Here we go.

        // Step 0: Make sure that data_streams can accept null as a value for 'about'.
        // Somehow this is still an issue.
        $streams_columns = array(
            'about' => array(
                 'null' => true
            )
        );
        $this->dbforge->modify_column('data_streams', $streams_columns);

        // Step 1: Rename page_layouts to page_types.
        if ($this->db->table_exists('page_layouts'))
        {
            $this->dbforge->rename_table('page_layouts', 'page_types');
        }

        // Step 2: Add some new columns to page_types
        $pt_fields = array(
            'slug'              => array('type' => 'VARCHAR', 'contstraint' => 60),
            'stream_id'         => array('type' => 'INT', 'contstraint' => 11),
            'meta_title'        => array('type' => 'VARCHAR', 'contstraint' => 255),
            'meta_keywords'     => array('type' => 'CHAR', 'contstraint' => 32),
            'meta_description'  => array('type' => 'TEXT'),
            'save_as_files'     => array('type' => 'CHAR', 'contstraint' => 1, 'default' => 'n'),
            'content_label'     => array('type' => 'VARCHAR', 'contstraint' => 60),
            'title_label'       => array('type' => 'VARCHAR', 'contstraint' => 100)
        );
        $this->dbforge->add_column('page_types', $pt_fields);

        // Step 2.1: Generate slugs for the page_types
        $pts = $this->db->get('page_types')->result();
        foreach ($pts as $pt)
        {
            $this->db->limit(1)->where('id', $pt->id)->update('page_types', array('slug' => url_title($pt->title, 'dash', true)));
        }

        // Step 3: Create a new default page stream
        // This stream has a single page chunks field, and can be
        // modified to suit needs further on down the road.
        $this->load->driver('Streams');
        $stream_id = $this->streams->streams->add_stream('Default Page Stream', 'def_page_fields', 'pages');

        // Step 3.5: Assign this stream to every page type
        $this->db->update('page_types', array('stream_id' => $stream_id));

        // Step 4: Add a chunks field type to the new stream.
        // The field type goes through and grabs the chunks 
        // based on the page ID.
        $field = array(
            'name'          => 'lang:streams.chunks.name',
            'slug'          => 'chunks',
            'namespace'     => 'pages',
            'type'          => 'chunks',
            'assign'        => 'def_page_fields'
        )
        $this->streams->fields->add_field($field);
    
        // Step 5: Rename layout_id to type_id for pages table.
        $rename_layout_id = array(
            'layout_id' => array(
                 'name' => 'type_id'
            )
        );
        $this->dbforge->modify_column('page_types', $rename_layout_id);

        // Step 6: Add some columns to the pages table.
        $page_fields = array(
            'entry_id'         => array('type' => 'INT', 'contstraint' => 11)
        );
        $this->dbforge->add_column('pages', $fields);

        // Step 7: Go through and create an entry for each page.
        // This could be a bit of an issue if a site has thousands of pages,
        // but this is unlikely on PyroCMS currently.
        foreach ($pages as $page)
        {
            // New entry for this page!
            $this->db->insert('def_page_fields', array('chunks' => '0', 'created' => date('Y-m-d H:i:s', time())));
            $id = $this->db->insert_id();
            $this->db->limit(1)->where('id', $page->id)->update('pages', array('entry_id' => $id));
            unset($id);
        }

        // Whew! We made it!
    }

    public function down()
    {
        return null;
    }
}