<?php namespace Pyro\Module\Pages\Model;

use Pyro\Model\Eloquent;
use Pyro\Model\Collection;

/**
 * Pages model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Pages\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Pages.Model.Page.html
 */
class Page extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * Cache minutes
     *
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Array containing the validation rules
     *
     * @var array
     */
    public function validate()
    {
        ci()->load->library('form_validation');

        $rules = array(
            array(
                'field' => 'title',
                'label' => 'lang:global:title',
                'rules' => 'trim|required|max_length[250]'
            ),
            'slug' => array(
                'field' => 'slug',
                'label' => 'lang:global:slug',
                'rules' => 'trim|required|alpha_dot_dash|max_length[250]', //|callback__check_slug'
            ),
            array(
                'field' => 'css',
                'label' => 'lang:pages:css_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'js',
                'label' => 'lang:pages:js_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'meta_title',
                'label' => 'lang:pages:meta_title_label',
                'rules' => 'trim|max_length[250]'
            ),
            array(
                'field' => 'meta_keywords',
                'label' => 'lang:pages:meta_keywords_label',
                'rules' => 'trim|max_length[250]'
            ),
            array(
                'field' => 'meta_description',
                'label' => 'lang:pages:meta_description_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'restricted_to[]',
                'label' => 'lang:pages:access_label',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'rss_enabled',
                'label' => 'lang:pages:rss_enabled_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'comments_enabled',
                'label' => 'lang:pages:comments_enabled_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'is_home',
                'label' => 'lang:pages:is_home_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'strict_uri',
                'label' => 'lang:pages:strict_uri_label',
                'rules' => 'trim'
            ),
            array(
                'field' => 'status',
                'label' => 'lang:pages:status_label',
                'rules' => 'trim|alpha|required'
            ),
            array(
                'field' => 'navigation_group_id[]',
                'label' => 'lang:pages:navigation_label',
                'rules' => 'numeric'
            )
        );

        ci()->form_validation->set_rules($rules);
        ci()->form_validation->set_data($this->toArray());

        return ci()->form_validation->run();
    }

    /**
     * Get all pages their children
     *
     * @param array $columns
     * @return mixed
     */
    public function tree(array $columns = array('*'))
    {
        return $this
            ->with(
                array(
                    'children.entry',
                    'entry'
                )
            )
            ->where('entry_id', '>', '')
            ->orderBy('order')
            ->get($columns)
            ->tree();
    }

    /**
     * Relationship: Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('Pyro\Module\Pages\Model\PageType');
    }

    /**
     * Relationship: Parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Pyro\Module\Pages\Model\Page', 'parent_id');
    }

    /**
     * Relationship: Children
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Pyro\Module\Pages\Model\Page', 'parent_id');
    }

    /**
     * Find page by id and status
     *
     * @param string $status Live or draft?
     * @return Page
     */
    public static function findStatus($status)
    {
        return static::where('status', '=', $status)->get();
    }

    /**
     * Find page by id and status
     *
     * @param int    $id     The id of the page.
     * @param string $status Live or draft?
     * @return Page
     */
    public static function findByIdAndStatus($id, $status)
    {
        return static::where('id', '=', $id)
            ->where('status', '=', $status)
            ->first();
    }

    /**
     * Find page by id and status
     *
     * @param int    $id     The id of the page.
     * @param string $status Live or draft?
     * @return Page
     */
    public static function findManyByParentAndStatus($parent_id, $status)
    {
        return static::where('parent_id', '=', $parent_id)
            ->where('status', '=', $status)
            ->get();
    }

    public static function findManyByTypeId($type_id = null)
    {
        return static::where('type_id', $type_id)->get();
    }

    /**
     * Find a page by its URI
     *
     * @param string $uri        The uri of the page.
     * @param bool   $is_request Is this an http request or called from a plugin
     * @return Page
     */
    public static function findByUri($uri, $is_request = false)
    {
        // it's the home page
        if ($uri === null) {

            $page = static::where('is_home', '=', true)
                ->with('type')

                ->take(1)
                ->first();

        } else {
            // If the URI has been passed as an array, implode to create a string of uri segments
            is_array($uri) && $uri = trim(implode('/', $uri), '/');

            // $uri gets shortened so we save the original
            $original_uri = $uri;
            $page         = false;
            $i            = 0;

            while (!$page and $uri and $i < 15) { /* max of 15 in case it all goes wrong (this shouldn't ever be used) */
                $page = static::where('uri', '=', $uri)
                    ->with('type')
                    ->take(1)
                    ->first();

                // if it's not a normal page load (plugin or etc. that is not cached)
                // then we won't do our recursive search
                if (!$is_request) {
                    break;
                }

                // if we didn't find a page with that exact uri AND there's more than one segment
                if (!$page and strpos($uri, '/') !== false) {
                    // pop the last segment off and we'll try again
                    $uri = preg_replace('@^(.+)/(.*?)$@', '$1', $uri);
                } // we didn't find a page and there's only one segment; it's going to 404
                elseif (!$page) {
                    break;
                }
                ++$i;
            }

            if ($page) {
                // so we found a page but if strict uri matching is required and the unmodified
                // uri doesn't match the page we fetched then we pretend it didn't happen
                if ($is_request and (bool)$page->strict_uri and $original_uri !== $uri) {
                    return false;
                }

                // things like breadcrumbs need to know the actual uri, not the uri with extra segments
                $page->base_uri = $uri;
            }
        }

        // looks like we have a 404
        if (!$page) {
            return false;
        }

        // ---------------------------------
        // Get Stream Entry
        // ---------------------------------

        if ($page->id and $page->entry) {

            $fields = $page->entry->getAttributes();

            foreach ($fields as $key => $value) {
                $page->{$key} = $value;
            }
        }

        return $page;
    }

    public function updateAllEntryTypes()
    {
        $page_types = ci()->pdb->table('page_types')
            ->join('data_streams', 'page_types.stream_id', '=', 'data_streams.id')
            ->select('page_types.id', 'data_streams.stream_slug', 'data_streams.stream_namespace')
            ->get();

        // Update the pages entry types
        foreach ($page_types as $type) {
            static::where('type_id', $type->id)
                ->update(array('entry_type' => $type->stream_slug . '.' . $type->stream_namespace));
        }
    }

    //    // --------------------------------------------------------------------------

    // /**
    //  * Get a page from the database.
    //  *
    //  * Also retrieves the content fields for that page.
    //  *
    //  * @param int $id The page id.
    //  * @param bool $get_data Whether to retrieve the stream data for this page or not. Defaults to true.
    //  *
    //  * @return array The page data.
    //  */
    // public function get($id, $get_data = true)
    // {
    // 	$page = $this->db
    // 		->select('pages.*, page_types.id as page_type_id, page_types.stream_id, page_types.body')
    // 		->select('page_types.save_as_files, page_types.slug as page_type_slug, page_types.title as page_type_title, page_types.js as page_type_js, page_types.css as page_type_css')
    // 		->join('page_types', 'page_types.id = pages.type_id', 'left')
    // 		->where('pages.id', $id)
    // 		->get($this->_table)
    // 		->row();

    // 	$page->stream_entry_found = false;

    // 	if ($page and $page->type_id and $get_data) {
    // 		// Get our page type files in case we are grabbing
    // 		// the body/html/css from the filesystem.
    // 		$this->page_type_m->get_page_type_files_for_page($page);

    // 		$this->load->driver('Streams');
    // 		$stream = $this->streams_m->get_stream($page->stream_id);

    // 		if ($stream) {
    // 			$params = array(
    // 				'stream' 	=> $stream->stream_slug,
    // 				'namespace' => $stream->stream_namespace,
    // 				'where' 	=> "`id`='".$page->entry_id."'",
    // 				'limit' 	=> 1
    // 			);

    // 			$ret = $this->streams->entries->get_entries($params);

    // 			if (isset($ret['entries'][0])) {
    // 				// For no collisions
    // 				$ret['entries'][0]['entry_id'] = $ret['entries'][0]['id'];
    // 				unset($ret['entries'][0]['id']);

    // 				$page->stream_entry_found = true;

    // 				return (object) array_merge((array) $page, (array) $ret['entries'][0]);
    // 			}

    // 			$this->page_type_m->get_page_type_files_for_page($page);
    // 		}
    // 	}

    // 	return $page;
    // }

    /**
     * Set the parent > child relations and child order
     *
     * @param array $page
     */
    public static function setChildren($page)
    {
        if (isset($page['children'])) {
            foreach ($page['children'] as $i => $child) {
                $child_id = (int)str_replace('page_', '', $child['id']);
                $page_id  = (int)str_replace('page_', '', $page['id']);

                // Since we are skipping validation on the model we are doing a little validation of our own
                if (is_numeric($child_id) and is_numeric($page_id)) {
                    $model                  = static::find($child_id);
                    $model->skip_validation = true;
                    $model->parent_id       = $page_id;
                    $model->order           = $i;
                    $model->save();
                }

                //repeat as long as there are children
                if (!empty($child['children'])) {
                    static::setChildren($child);
                }
            }
        }
    }

    /**
     * Does the page have children?
     *
     * @param int $parent_id The ID of the parent page
     * @return bool
     */
    public function has_children($parent_id)
    {
        return parent::count_by(array('parent_id' => $parent_id)) > 0;
    }

    /**
     * Get the child IDs
     *
     * @param int   $id       The ID of the page?
     * @param array $id_array ?
     * @return array
     */
    public static function getDescendantIds($id, $id_array = array(), array $columns = array('id'))
    {
        $id_array[] = $id;

        $children = static::where('parent_id', '=', $id)
            ->get($columns);

        if (!$children->isEmpty()) {
            // Loop through all of the children and run this function again
            foreach ($children as $child) {
                $id_array = static::getDescendantIds($child->id, $id_array);
            }
        }

        return $id_array;
    }

    public function setEntryType($always = false)
    {
        if ((!$this->entry_type and $this->type_id) or $always) {
            $page_type = PageType::find($this->type_id);

            $this->entry_type = $page_type->stream->stream_slug . '.' . $page_type->stream->stream_namespace;
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Build a lookup
     *
     * @param int $id The id of the page to build the lookup for.
     * @return array
     */
    public function buildLookup($id = null)
    {
        // Either its THIS page, or one we said
        $current_id = $id ? : $this->id;

        if ($current_page = static::find($current_id)) {
            $current_page->skip_validation = true;

            $segments = array();
            do {
                // Only want a bit of this data
                $page = static::select('slug', 'parent_id')
                    ->find($current_id);

                $current_id = $page->parent_id;
                array_unshift($segments, $page->slug);
            } while ($page->parent_id > 0);

            // Save this new uri by joining the array
            $current_page->uri = implode('/', $segments);

            return $current_page->save();
        } else {
            return false;
        }
    }

    /**
     * Reindex child items
     *
     * @param int $id The ID of the parent item
     */
    public static function reindexDescendants($id)
    {
        $ids = static::getDescendantIds($id);

        $instance = new static;

        array_walk($ids, array($instance, 'buildLookup'));
    }

    /**
     * Update lookup.
     * Updates lookup for entire page tree used to update
     * page uri after ajax sort.
     *
     * @param array $root_pages An array of top level pages
     */
    public static function updateLookup($root_pages)
    {
        // first reset the URI of all root pages
        static::where('parent_id', 0)
            ->raw('UPDATE `table` SET uri=slug');

        foreach ($root_pages as $page) {
            static::reindexDescendants($page);
        }
    }

    /**
     * Set the homepage
     */
    public function setHomePage()
    {
        $this->where('is_home', '=', 1)
            ->update(array('is_home' => 0));

        $this->where('id', '=', $this->id)->update(array('is_home' => 1));
    }

    public function delete()
    {
        $children_ids = $this->getDescendantIds($this->id);

        $children = $this->whereIn('parent_id', $children_ids)
            ->get(array('id', 'entry_type', 'entry_id'));

        if (!$children->isEmpty()) {
            foreach ($children as $page) {
                $page->entry()->delete();

                $page->delete();
            }
        }

        $this->entry()->delete();

        return parent::delete();
    }

    public static function resetParentByIds($ids = array())
    {
        return static::whereIn('id', $ids)->update(array('parent_id' => 0));
    }

    // --------------------------------------------------------------------------

    /**
     * Check Slug for Uniqueness
     * Slugs should be unique among sibling pages.
     *
     * @param string $slug      The slug to check for.
     * @param int    $parent_id The parent_id if any.
     * @param int    $id        The id of the page.
     * @return bool
     */
    public static function isUniqueSlug($slug, $parent_id)
    {
        return (bool)static::where('slug', $slug)
            ->where('parent_id', $parent_id)
            ->count() > 0;
    }

    // --------------------------------------------------------------------------

    /**
     * Callback to check uniqueness of slug + parent
     *
     * @param $slug slug to check
     * @return bool
     */
    public function _check_slug($slug)
    {
        $page_id = ci()->uri->segment(4);

        $instance = new static;

        if ($instance->isUniqueSlug($slug, ci()->input->post('parent_id'), (int)$page_id)) {
            if (ci()->input->post('parent_id') == 0) {
                $parent_folder = lang('pages:root_folder');
                $url           = '/' . $slug;
            } else {
                $page_obj      = $this->find($page_id);
                $url           = '/' . trim(dirname($page_obj->uri), '.') . $slug;
                $page_obj      = $this->get(ci()->input->post('parent_id'));
                $parent_folder = $page_obj->title;
            }

            ci()->form_validation->set_message(
                '_check_slug',
                sprintf(lang('pages:page_already_exist_error'), $url, $parent_folder)
            );
            return false;
        }

        return true;
    }

    public function entry()
    {
        return $this->morphTo();
    }
}
