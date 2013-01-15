<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update Pages for Streams/Page Types
 *
 * This migration replaces the existing page layout
 * structure with page types, which are built
 * on streams.
 */
class Migration_Update_pages_for_streams extends CI_Migration
{
    public function up()
    {
        // Here we go.

        // Step 0: Make sure that data_streams can accept null as a value for 'about'.
        // Somehow this is still an issue.
        $streams_columns = array(
            'about' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            )
        );
        $this->dbforge->modify_column('data_streams', $streams_columns);

        // Step 0b: The 2.2 codebase expects these columns. However they aren't added
        // until migration 114/115 so we'll add them here, then remove again at the end of this migration.
       if ( ! $this->db->field_exists('is_hidden', 'data_streams'))
       {
            $this->dbforge->add_column('data_streams', array(
                'is_hidden' => array(
                    'type' => 'ENUM',
                    'null' => true,
                    'constraint' => array('yes', 'no'),
                    'default' => 'no'
                ),
            ));
        } 
        if ( ! $this->db->field_exists('menu_path', 'data_streams'))
        {
            $this->dbforge->add_column('data_streams', array(
                'menu_path' => array(
                    'type' => 'VARCHAR',
                    'null' => true,
                    'constraint' => 255
                ),
            ));
        }

        // Step 1: Rename page_layouts to page_types.
        if ($this->db->table_exists('page_layouts'))
        {
            $this->dbforge->rename_table('page_layouts', 'page_types');

            // Step 2: Add some new columns to page_types
            $this->dbforge->add_column('page_types', array(
                'slug'              => array('type' => 'VARCHAR', 'constraint' => 60, 'null' => true),
                'stream_id'         => array('type' => 'INT', 'constraint' => 11),
                'meta_title'        => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
                'meta_keywords'     => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
                'meta_description'  => array('type' => 'TEXT', 'null' => true),
                'save_as_files'     => array('type' => 'CHAR', 'constraint' => 1, 'default' => 'n'),
                'content_label'     => array('type' => 'VARCHAR', 'constraint' => 60, 'null' => true),
                'title_label'       => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true)
            ));
        }

        // Step 2.1: Generate slugs for the page_types
        $pts = $this->db->get('page_types')->result();
        foreach ($pts as $pt)
        {
            $this->db->limit(1)->where('id', $pt->id)->update('page_types', array('slug' => url_title($pt->title, 'dash', true)));
        }

        // Step 3: Create a new default page stream
        // This stream has a single page chunks field, and can be
        // modified to suit needs further on down the road.
        $this->dbforge->drop_table('def_page_fields', true);
        
        // Avoid stream conflicts
        $this->db->where('stream_slug', 'def_page_fields')->delete('data_streams');

        $this->load->driver('Streams');
        $stream_id = $this->streams->streams->add_stream('Default Page Stream', 'def_page_fields', 'pages');

        // Step 3.5: Assign this stream to every page type
        $this->db->update('page_types', array('stream_id' => $stream_id));

        // Step 4: Add a chunks field type to the new stream.
        // The field type goes through and grabs the chunks 
        // based on the page ID.

        // We need to have the chunks field type available or else fits will be thrown.
        $this->type->load_types_from_folder(APPPATH.'modules/pages/field_types/', 'addon');
       
        // Remove it if its in there somehow already
        $this->db->where(array('field_name' => 'lang:streams:chunks.name'))->delete('data_fields');

        $this->streams->fields->add_field(array(
            'name'          => 'lang:streams:chunks.name',
            'slug'          => 'chunks',
            'namespace'     => 'pages',
            'type'          => 'chunks',
            'assign'        => 'def_page_fields'
        ));
    
        // Step 5: Rename layout_id to type_id for pages table.
        if ($this->db->field_exists('layout_id', 'pages'))
        {
            $this->dbforge->modify_column('pages', array(
                'layout_id' => array(
                     'name' => 'type_id',
                     'type' => 'INT',
                     'constraint' => 11,
                     'null' => false
                )
            ));
        }

        if ( ! $this->db->field_exists('entry_id', 'pages'))
        {
            // Step 6: Add some columns to the pages table.
            $this->dbforge->add_column('pages', array(
                'entry_id' => array('type' => 'INT', 'contstraint' => 11, 'null' => true)
            ));
        }

        // Step 7: Go through and create an entry for each page.
        // This could be a bit of an issue if a site has thousands of pages,
        // but this is unlikely on PyroCMS currently.
        $pages = $this->db->get('pages')->result();
        foreach ($pages as $page)
        {
            // New entry for this page!
            $this->db->insert('def_page_fields', array('chunks' => '0', 'ordering_count' => '1', 'created' => date('Y-m-d H:i:s', time())));
            $id = $this->db->insert_id();
            $this->db->limit(1)->where('id', $page->id)->update('pages', array('entry_id' => $id));
            unset($id);
        }

        // Step 8: Add page_types folder. This is not 100%
        // necessary since this is only used as an opt in
        // and can be easily added, but hey, let's try.
        $pt_folder = FCPATH.'assets/page_types/';

        if ( ! is_dir($pt_folder))
        {
            if ( ! @mkdir($pt_folder, 0777))
            {
                // Make an .htaccess file
                $this->load->helper('file');
                write_file($pt_folder.'.htaccess', 'deny from all');
            }
        }

        // remove our temporary columns, they get added back later with proper setup
        $this->dbforge->drop_column('data_streams', 'is_hidden');
        $this->dbforge->drop_column('data_streams', 'menu_path');

        // clear the page cache so it will retrieve data with page types data
        $this->pyrocache->delete_all('page_m');

        // Whew! We made it!
    }

    public function down()
    {
        return null;
    }
}