<?php namespace Pyro\FieldType;

use dflydev\markdown\MarkdownParser;
use Pyro\Module\Addons\ModuleManager;
use Pyro\Module\Pages\Model\PageChunk;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

class Chunks extends FieldTypeAbstract
{
    public $field_type_slug = 'chunks';

    public $db_col_type = 'string';

    public $version = '1.1.0';

    public $alt_process = true;

    public $author = array(
        'name' => 'PyroCMS Development Team',
        'url'  => 'http://pyrocms.com/'
    );

    protected $chunks;

    public function event()
    {
        $this->appendMetadata($this->view('../js/wysiwyg'));
        $this->js('form.js');
        $this->css('chunks.css');
    }

    /**
     * Form Input
     * We will grab our chunks based on the page_id
     * and display each form.
     *
     * @param    array
     * @param    array
     * @return    string
     */
    public function formInput()
    {
        $data = [];

        $this->chunks = new PageChunk();

        // If we don't have a page ID, then let's just
        // make an empty page chunks array with 1 entry.
        if ($id = $this->entry->getKey()) {
            $data['chunks'] = $this->chunks->getManyByPageId($id);
        } else {
            $data['chunks'][] = (object)array(
                'slug'  => 'default',
                'class' => null,
                'type'  => null,
                'body'  => null
            );
        }

        $data['form_slug'] = $this->getFormSlug();

        if ($_POST) {

            // Validation failed, we must repopulate the chunks form
            $chunk_slugs   = ci()->input->post('chunk_slug') ? array_values(ci()->input->post('chunk_slug')) : array();
            $chunk_classes = ci()->input->post('chunk_class') ? array_values(
                ci()->input->post('chunk_class')
            ) : array();
            $chunk_bodies  = ci()->input->post('chunk_body') ? array_values(ci()->input->post('chunk_body')) : array();
            $chunk_types   = ci()->input->post('chunk_type') ? array_values(ci()->input->post('chunk_type')) : array();

            $chunk_bodies_count = count($chunk_bodies);

            for ($i = 0; $i < $chunk_bodies_count; $i++) {
                $data['chunks'][$i] = (object)array(
                    //'id' 	=> $i,
                    'slug'  => !empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
                    'class' => !empty($chunk_classes[$i]) ? $chunk_classes[$i] : '',
                    'type'  => !empty($chunk_types[$i]) ? $chunk_types[$i] : '',
                    'body'  => !empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
                );
            }
        }

        return $this->view('chunk_form', $data);
    }

    /**
     * Pre Save
     * Process before saving to database. We have a dummy
     * value in the form so this gets processed, but we
     * ignore it and grab all the chunk inputs.
     *
     * @access    public
     * @param    array
     * @return    string
     */
    public function preSave()
    {
        $this->chunks = new PageChunk();

        $slugs = array('chunk_slug', 'chunk_class', 'chunk_body', 'chunk_type');

        $input = ci()->input->post();

        foreach ($slugs as $slug) {
            if (!isset($input[$slug])) {
                $input[$slug] = null;
            }
        }

        $chunk_slugs  = $input['chunk_slug'] ? array_values($input['chunk_slug']) : array();
        $chunk_class  = $input['chunk_class'] ? array_values($input['chunk_class']) : array();
        $chunk_bodies = $input['chunk_body'] ? array_values($input['chunk_body']) : array();
        $chunk_types  = $input['chunk_type'] ? array_values($input['chunk_type']) : array();

        $chunks = array();

        $chunk_bodies_count = count($chunk_bodies);

        for ($i = 0; $i < $chunk_bodies_count; $i++) {
            $chunks[] = (object)array(
                'slug'  => !empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
                'class' => !empty($chunk_class[$i]) ? $chunk_class[$i] : '',
                'type'  => !empty($chunk_types[$i]) ? $chunk_types[$i] : '',
                'body'  => !empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
            );
        }

        // No matter what, we are going to need to get rid of
        // old page chunks.

        $this->chunks->deleteManyByPageId($this->entry->getKey());

        // If we have chunks, let's go ahead and add them.
        if ($chunks) {
            $i = 1;
            foreach ($chunks as $chunk) {
                $row = new $this->chunks;

                $row->slug    = preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->slug);
                $row->class   = preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->class);
                $row->page_id = $this->entry->getKey();
                $row->body    = $chunk->body;
                $row->parsed  = ($chunk->type == 'markdown') ? parse_markdown($chunk->body) : '';
                $row->type    = $chunk->type;
                $row->sort    = $i++;

                $row->save();
            }
        }

        return '*';
    }

    /**
     * Run this when the field gets assigned.
     *
     * @return void
     */
    public function fieldAssignmentConstruct()
    {
        $instance = $this;

        $schema = ci()->pdb->getSchemaBuilder();

        if (!$schema->hasTable('page_chunks')) {
            $schema->create(
                'page_chunks',
                function ($table) use ($instance) {
                    $table->increments('id');
                    $table->string('page_id');
                    $table->string('slug')->nullable();
                    $table->string('class')->nullable();
                    $table->string('type');
                    $table->text('body')->nullable();
                    $table->string('parsed')->nullable();
                    $table->integer('sort')->nullable();
                }
            );
        }
    }

    /**
     * Return plugin formatted output.
     *
     * @return mixed
     */
    public function pluginOutput()
    {
        $this->chunks = new PageChunk();

        $chunks = $this->chunks->getManyByPageId($this->entry->id)->toArray();

        $markdown = new MarkdownParser();

        foreach ($chunks as &$chunk) {
            if ($chunk['type'] == 'markdown') {
                $chunk['body'] = $markdown->transformMarkdown($chunk['body']);
            }
        }

        return $chunks;
    }
}
