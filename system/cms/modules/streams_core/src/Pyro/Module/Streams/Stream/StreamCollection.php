<?php namespace Pyro\Module\Streams\Stream;

use Pyro\Model\EloquentCollection;

class StreamCollection extends EloquentCollection
{
    /**
     * Find a field type by slug and namespace
     *
     * @param  string $slug
     * @param  string $namespace
     *
     * @return object
     */
    public function findBySlugAndNamespace($slug = null, $namespace = null)
    {
        if (!$namespace) {
            @list($slug, $namespace) = explode('.', $slug);
        }

        return array_first(
            $this->items,
            function ($key, $stream) use ($slug, $namespace) {
                return $stream->stream_slug == $slug and $stream->stream_namespace == $namespace;
            },
            false
        );
    }

    /**
     * Find many by namespace
     *
     * @param  string $namespace
     *
     * @return array
     */
    public function findManyByNamespace($namespace = null)
    {
        return $this->filter(
            function ($stream) use ($namespace) {
                return $stream->stream_namespace == $namespace;
            }
        );
    }

    /**
     * Get stream options
     *
     * @return array The array of options
     */
    public function getStreamOptions()
    {
        $options = array();

        foreach ($this->items as $stream) {
            $options[humanize($stream->stream_namespace)][$stream->id] = lang_label($stream->stream_name);
        }

        return $options;
    }

    /**
     * Get associative Options
     *
     * @return [type] [description]
     */
    public function getStreamAssociativeOptions()
    {
        $options = array();

        foreach ($this->items as $stream) {
            $options[humanize(
                $stream->stream_namespace
            )][$stream->stream_slug . '.' . $stream->stream_namespace] = lang_label($stream->stream_name);
        }

        return $options;
    }
}
