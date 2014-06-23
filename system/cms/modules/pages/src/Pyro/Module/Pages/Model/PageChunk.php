<?php namespace Pyro\Module\Pages\Model;

use Pyro\Model\Eloquent;

class PageChunk extends Eloquent
{

    protected $table = 'page_chunks';

    public $timestamps = false;

    /**
     * Create page chunks
     *
     * @access    public
     * @param    array $input The sanitized $_POST
     * @return    bool
     */
    public function saveChunks($input)
    {
        $chunk_slugs  = $input['chunk_slug'] ? array_values($input['chunk_slug']) : array();
        $chunk_class  = $input['chunk_class'] ? array_values($input['chunk_class']) : array();
        $chunk_bodies = $input['chunk_body'] ? array_values($input['chunk_body']) : array();
        $chunk_types  = $input['chunk_type'] ? array_values($input['chunk_type']) : array();

        $page              = new \stdClass();
        $page->chunks      = array();
        $chunksBodiesCount = count($input['chunk_body']);

        for ($i = 0; $i < $chunksBodiesCount; $i++) {
            $page->chunks[] = (object)array(
                'id'    => $i,
                'slug'  => !empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
                'class' => !empty($chunk_class[$i]) ? $chunk_class[$i] : '',
                'type'  => !empty($chunk_types[$i]) ? $chunk_types[$i] : '',
                'body'  => !empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
            );
        }

        if ($page->chunks) {
            // get rid of the old
            $this->deleteManyByPageId($input['page_id']);

            // And add the new ones
            $i = 1;
            foreach ($page->chunks as $chunk) {
                $this->create(
                    array(
                        'slug'    => preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->slug),
                        'class'   => preg_replace('/[^a-zA-Z0-9_-\s]/', '', $chunk->class),
                        'page_id' => $input['page_id'],
                        'body'    => $chunk->body,
                        'parsed'  => ($chunk->type == 'markdown') ? parse_markdown($chunk->body) : '',
                        'type'    => $chunk->type,
                        'sort'    => $i++,
                    )
                );
            }

            return true;
        }

        return false;
    }

    public function getManyByPageId($pageId)
    {
        return $this->where('page_id', $pageId)->get();
    }

    public function deleteManyByPageId($pageId)
    {
        return $this->where('page_id', $pageId)->delete();
    }

}