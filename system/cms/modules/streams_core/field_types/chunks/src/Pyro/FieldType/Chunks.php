<?php namespace Pyro\FieldType;

use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Pages\Model\PageChunk;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Country Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Adam Fairholm
 * @copyright      Copyright (c) 2011 - 2012, Adam Fairholm
 */
class Chunks extends FieldTypeAbstract
{
    public $field_type_slug = 'chunks';

    public $db_col_type = 'string';

    public $version = '1.1.0';

    public $author = array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

    protected $chunks;

    public function __construct()
    {
        $this->chunks = new PageChunk();
    }

    /**
     * Output Form
     *
     * We will grab our chunks based on the page_id
     * and display each form.
     *
     * @param	array
     * @param	array
     * @return	string
     */
    public function formOutput()
    {
        $data = [];

        // If we dont have a page ID, then let's just
        // make an empty page chunks array with 1 entry.
        if (isset(ci()->page_id))
        {
            if ($this->entry instanceof Page) {
                $data['chunks'] = $this->entry->chunks;
            }
        }
        else
        {
            $data['chunks'] = array(
                array(
                    'slug'		=> 'default',
                    'class'		=> null,
                    'type'		=> null,
                    'body'		=> null
                )
            );
        }

        if ($_POST)
        {
            // Validation failed, we must repopulate the chunks form
            $chunk_slugs 	= ci()->input->post('chunk_slug') ? array_values(ci()->input->post('chunk_slug')) : array();
            $chunk_classes 	= ci()->input->post('chunk_class') ? array_values(ci()->input->post('chunk_class')) : array();
            $chunk_bodies 	= ci()->input->post('chunk_body') ? array_values(ci()->input->post('chunk_body')) : array();
            $chunk_types 	= ci()->input->post('chunk_type') ? array_values(ci()->input->post('chunk_type')) : array();

            $chunk_bodies_count = count($chunk_bodies);

            for ($i = 0; $i < $chunk_bodies_count; $i++)
            {
                $data['chunks'][$i] = array(
                    //'id' 	=> $i,
                    'slug' 	=> ! empty($chunk_slugs[$i]) 	? $chunk_slugs[$i] 	: '',
                    'class' => ! empty($chunk_classes[$i]) 	? $chunk_classes[$i] 	: '',
                    'type' 	=> ! empty($chunk_types[$i]) 	? $chunk_types[$i] 	: '',
                    'body' 	=> ! empty($chunk_bodies[$i]) 	? $chunk_bodies[$i] : '',
                );
            }
        }

        return $this->view('chunk_form', $data);
    }

    // --------------------------------------------------------------------------

    /**
     * Pre Save
     *
     * Process before saving to database. We have a dummy
     * value in the form so this gets processed, but we
     * ignore it and grab all the chunk inputs.
     *
     * @access	public
     * @param	array
     * @return	string
     */
    public function preSave()
    {
        $slugs = array('chunk_slug', 'chunk_class', 'chunk_body', 'chunk_type');

        foreach ($slugs as $slug)
        {
            if ( ! isset($input[$slug])) $input[$slug] = null;
        }

        $chunk_slugs 	= $input['chunk_slug'] ? array_values($input['chunk_slug']) : array();
        $chunk_class 	= $input['chunk_class'] ? array_values($input['chunk_class']) : array();
        $chunk_bodies 	= $input['chunk_body'] ? array_values($input['chunk_body']) : array();
        $chunk_types 	= $input['chunk_type'] ? array_values($input['chunk_type']) : array();

        $chunks = array();

        $chunk_bodies_count = count($chunk_bodies);

        for ($i = 0; $i < $chunk_bodies_count; $i++)
        {
            $chunks[] = (object) array(
                'slug' => ! empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
                'class' => ! empty($chunk_class[$i]) ? $chunk_class[$i] : '',
                'type' => ! empty($chunk_types[$i]) ? $chunk_types[$i] : '',
                'body' => ! empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
            );
        }

        // No matter what, we are going to need to get rid of
        // old page chunks.

        $this->chunks->deleteManyByPageId(ci()->page_id);

        // If we have chunks, let's go ahead and add them.
        if ($chunks)
        {
            $i = 1;
            foreach ($chunks as $chunk)
            {
                $this->chunks->create(array(
                        'slug' 		=> preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->slug),
                        'class' 	=> preg_replace('/[^a-zA-Z0-9_-\s]/', '', $chunk->class),
                        'page_id' 	=> ci()->page_id,
                        'body' 		=> $chunk->body,
                        'parsed'	=> ($chunk->type == 'markdown') ? parse_markdown($chunk->body) : '',
                        'type' 		=> $chunk->type,
                        'sort' 		=> $i++,
                    ));
            }
        }

        return '*';
    }

}
