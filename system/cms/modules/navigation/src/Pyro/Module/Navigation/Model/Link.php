<?php namespace Pyro\Module\Navigation\Model;

use Pyro\Module\Navigation\Model\Group;
use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Groups;

/**
 * Navigation model for the navigation module.
 *
 * @author      Phil Sturgeon
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Navigation\Models
 */
class Link extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'navigation_links';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relationship: Parent
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Pyro\Module\Navigation\Model\Link', 'parent');
    }

    /**
     * Relationship: Children
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Pyro\Module\Navigation\Model\Link', 'parent');
    }

    /**
     * Get a navigation link with all the trimmings
     *
     *
     * @param  int   $id The ID of the item
     * @return mixed
     */
    public static function getUrl($id = 0)
    {
        $link = parent::find($id);

        if (! $link) {
            return;
        }

        return self::makeUrl($link);
    }

    /**
     * Find link by Group ID and order by position
     *
     * @param int    $group_id  The group_id of the link
     * @param string $direction The direction of the sort
     *
     * @return void
     */
    public static function findByGroupIdAndOrderByPosition($group_id, $direction = 'asc')
    {
        return static::where('navigation_group_id', '=', $group_id)->orderBy('position',$direction)->first();
    }

    /**
     * Get links by Group ID and order by position
     *
     * @param int    $group_id  The group_id of the links
     * @param string $direction The direction of the sort
     *
     * @return void
     */
    public static function findManyByGroupIdAndOrderByPosition($group_id, $direction = 'asc')
    {
        return static::where('navigation_group_id', '=', $group_id)->orderBy('position',$direction)->get();
    }

    /**
     * Reset the parent > child
     *
     * @param int $parent_id The parent_id of the link
     *
     * @return void
     */
    public static function resetChildByParentId($parent_id)
    {
        return static::where('parent', '=', $parent_id)->update(array('parent'=> 0));
    }

    /**
     * Build a multi-array of parent > children.
     *
     * @param  string $group Either the group abbrev or the group id
     * @return array  An array representing the link tree
     */
    public static function getTreeByGroup($group, $params = array())
    {
        // the plugin passes the abbreviation
        if ( ! is_numeric($group)) {
            $row = Group::findGroupByAbbrev($group);
            $group = $row ? $row->id : null;
        }

        $front_end = (isset($params['front_end']) and $params['front_end']);

        $user_group = (isset($params['user_group'])) ? $params['user_group'] : false;

        $all_links = self::with('children')->where('navigation_group_id','=',$group)->where('parent', '=', 0)->orderBy('position')->get();

        $all_links = self::makeUrlArray($all_links, $user_group, $front_end);

        return $all_links;
    }

    /**
     * Set order of links
     *
     * @param  array $link
     * @return void
     */
    public static function setOrder($order = array(), $group = null)
    {
        //reset all parent > child relations
        $group = Group::find($group);
        foreach ($group->links as $link) {
            $link->parent = 0;
            $link->save();
        }

        foreach ($order as $i => $link) {
            //set the order of the root links
            ci()->pdb
                ->table('navigation_links')
                ->where('id', str_replace('link_', '', $link['id']))
                ->update(array('position' => $i));

            //iterate through children and set their order and parent
            self::setChildren($link);
        }
    }

    /**
     * Set the parent > child relations and child order
     *
     * @param  array $link
     * @return void
     */
    public static function setChildren($link)
    {
        if (isset($link['children'])) {
            foreach ($link['children'] as $i => $child) {
                ci()->pdb
                    ->table('navigation_links')
                    ->where('id', str_replace('link_', '', $child['id']))
                    ->update(array('parent' => str_replace('link_', '', $link['id'])));

                //repeat as long as there are children
                if (isset($child['children'])) {
                    self::setChildren($child);
                }
            }
        }
    }

    /**
     * Get a link's children IDs
     *
     * @param  array $link
     * @return void
     */
    public static function getChildrenIds($parent_id = null)
    {
        $children = ci()->pdb->table('navigation_links')
            ->where('parent', '=', $parent_id)->get();

        $ids = array();

        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, self::getChildrenIds($child->id));
        }

        return $ids;
    }

    /**
     * Delete a link and its children
     *
     * @param  int   $id The ID of the link to delete
     * @return array
     */
    public static function deleteLinkChildren($id = 0)
    {
        $ids = array($id);
        $ids = array_merge($ids, self::getChildrenIds($id));

        return self::whereIn('id', $ids)->delete();
    }

    /**
     * Format an array
     *
     * @param  array $input The data to format
     * @return array
     */
    public static function formatArray($input)
    {
        // If the url is not empty and not just the default http://
        if ( ! empty($input['url']) && $input['url'] != 'http://') {
            $input['uri'] = '';
            $input['module_name'] = '';
            $input['page_id'] = 0;
        }

        // If the uri is empty reset the others
        if ( ! empty($input['uri'])) {
            $input['url'] = '';
            $input['module_name'] = '';
            $input['page_id'] = 0;
        }

        // You get the idea...
        if ( ! empty($input['module_name'])) {
            $input['url'] = '';
            $input['uri'] = '';
            $input['page_id'] = 0;
        }

        if ( ! empty($input['page_id'])) {
            $input['url'] = '';
            $input['uri'] = '';
            $input['module_name'] = '';
        }

        return $input;
    }

    /**
     * Make URL
     *
     * @param  array $row Navigation record
     * @return mixed Valid url
     */
    public static function makeUrl($row)
    {
        // If its any other type than a URL, it needs some help becoming one
        switch ($row->link_type) {
            case 'uri':
                $row->url = site_url($row->uri);
                break;
            case 'module':
                $row->url = site_url($row->module_name);
                break;
            case 'page':

                if ($status = (is_subclass_of(ci(), 'Public_Controller') ? 'live' : null)) {
                    $page = Page::findByIdAndStatus($row->page_id, $status);
                } else {
                    $page = Page::find($row->page_id);
                }

                $row->url = site_url($page->uri);
                $row->is_home = $page->is_home;
                break;
        }

        return $row;
    }

    /**
     * Make a URL array
     *
     * @param  array $row Array of links
     * @return mixed Array of links with valid urls
     */
    public static function makeUrlArray($links, $user_group = false, $front_end = false)
    {
        // We have to fetch it ourselves instead of just using $current_user because this
        // will all be cached per user group
        $group = Groups\Model\Group::findByName($user_group);

        foreach ($links as $key => &$row) {
            // Looks like it's restricted. Let's find out who
            if ($row->restricted_to and $front_end) {
                $row->restricted_to = (array) explode(',', $row->restricted_to);

                if ( ! $user_group or
                    ($user_group != 'admin' AND
                    ! in_array($group->id, $row->restricted_to))
                ) {
                    unset($links[$key]);
                }
            }

            // If its any other type than a URL, it needs some help becoming one
            switch ($row->link_type) {
                case 'uri':
                    $row->url = site_url($row->uri);
                    break;
                case 'module':
                    $row->url = site_url($row->module_name);
                    break;
                case 'page':

                    if ($front_end) {
                        $page = Page::findByIdAndStatus($row->page_id, 'live');
                    } else {
                        $page = Page::find($row->page_id);
                    }

                    // Fuck this then
                    if (! $page) {
                        unset($links[$key]);
                        break;
                    }

                    $row->url = site_url($page->uri);
                    $row->is_home = $page->is_home;

                    // But wait. If we're on the front-end and they don't have access to the page then we'll remove it anyway.
                    if ($front_end and $page->restricted_to) {
                        $page->restricted_to = (array) explode(',', $page->restricted_to);

                        if ( ! $user_group or ($user_group != 'admin' and ! in_array($group->id, $page->restricted_to))) {
                            unset($links[$key]);
                        }
                    }
                    break;
            }
        }

        return $links;
    }

}
