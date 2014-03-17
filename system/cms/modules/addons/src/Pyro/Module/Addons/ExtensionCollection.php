<?php namespace Pyro\Module\Addons;

use Pyro\Model\EloquentCollection;

class ExtensionCollection extends EloquentCollection
{
    /**
     * By slug
     *
     * @var array
     */
    protected $by_slug = null;

    /**
     * Construct
     *
     * @param array $extensions
     */
    public function  __construct($extensions = array())
    {
        parent::__construct($extensions);

        foreach ($extensions as $extension) {
            // Index by slug
            if (isset($extension->slug)) {
                $this->by_slug[$extension->slug] = $extension;
            }
        }
    }

    /**
     * Find extension by slug
     *
     * @param  string $slug
     * @return object
     */
    public function findBySlug($slug = null)
    {
        return isset($this->by_slug[$slug]) ? $this->by_slug[$slug] : null;
    }

    /**
     * Test if includes
     *
     * @param  array $include
     * @return boolean
     */
    public function includes($include = array())
    {
        $this->filter(
            function ($extension) use ($include) {
                return in_array($extension->slug, $include);
            }
        );
    }

    /**
     * Test if excludes
     *
     * @param  array $exclude
     * @return boolean
     */
    public function excludes($exclude = array())
    {
        $this->filter(
            function ($extension) use ($exclude) {
                return !in_array($extension->slug, $exclude);
            }
        );
    }

    /**
     * Available
     *
     * @param $extensions
     * @return mixed
     */
    public function available()
    {
        $extensions = array();

        foreach ($this->items as $slug => $extension) {

            // Remove where dependent module is not installed
            if ($extension->module and module_installed($extension->module)) {
                if (ci()->current_user->hasAccess($extension->module . '.*')) {
                    $extensions[$slug] = $extension;
                }
            }

            // Remove where user does not have permission
            if ($extension->role and $permission = ci()->module_details['slug'] . '.' . $extension->role) {
                if (ci()->current_user->hasAccess($permission)) {
                    $extensions[$slug] = $extension;
                }
            } else {
                $extensions[$slug] = $extension;
            }
        }

        return new ExtensionCollection($extensions);
    }
}
