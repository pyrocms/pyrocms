<?php namespace Pyro\Module\Addons;

use Pyro\Model\EloquentCollection;

class ExtensionCollection extends EloquentCollection
{
    /**
     * By slug
     * @var array
     */
    protected $by_slug = null;

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------	  METHODS 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Construct
     * @param array $extensions
     */
    public function  __construct($extensions = array())
    {
        parent::__construct($extensions);

        foreach ($extensions as $extension) {
            // Index by slug
            if (isset($extension->slug))
                $this->by_slug[$extension->slug] = $extension;
        }
    }

    /**
     * Find extension by slug
     * @param  string $slug
     * @return object
     */
    public function findBySlug($slug = null)
    {
        return isset($this->by_slug[$slug]) ? $this->by_slug[$slug] : null;
    }

    /**
     * Test if includes
     * @param  array  $include
     * @return boolean
     */
    public function includes($include = array())
    {
        $this->filter(function($extension) use ($include) {
            return in_array($extension->slug, $include);
        });
    }

    /**
     * Test if excludes
     * @param  array  $exclude
     * @return boolean
     */
    public function excludes($exclude = array())
    {
        $this->filter(function($extension) use ($exclude) {
            return ! in_array($extension->slug, $exclude);
        });
    }
}
