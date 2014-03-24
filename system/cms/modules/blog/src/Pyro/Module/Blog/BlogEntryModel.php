<?php namespace Pyro\Module\Blog;

use Pyro\Module\Streams\Model\BlogsBlogEntryModel;

class BlogEntryModel extends BlogsBlogEntryModel
{

    public $searchIndexTemplate = array(
        'singular'     => 'blog:post',
        'plural'       => 'blog:posts',
        'title'        => '{{ entry:title }}',
        'description'  => '{{ entry:body }}',
        'keywords'     => '{{ post:meta_keywords }}',
        'uri'          => '{{ post:uri }}',
        'cp_uri'       => 'admin/blog/edit/{{ entry:id }}',
        'group_access' => null,
        'user_access'  => null
    );

    protected $appends = array('url');

    /**
     * Find Many Blog Entries
     *
     * @return \Pyro\Module\Streams\Entry\EntryCollection
     */
    public function findManyPosts($take = 0, $skip = null, $eager = array())
    {
        $query = static::eager($eager)->live()->orderBy('created_at', 'DESC');

        if ($take > 0) {
            $query = $query->take($take)->skip($skip);
        }

        return $query->get();
    }

    public static function getMutatorCache()
    {
        return static::$mutatorCache;
    }

    public static function findManyByCategoryId($categoryId = null, $take = null, $skip = null)
    {
        if (!$categoryId) {
            return false;
        }

        return static::published($take, $skip)
            ->where('category_id', '=', $categoryId)
            ->get();
    }

    public function findBySlug($slug)
    {

    }

    public function getUrlAttribute()
    {
        return site_url('blog/' . date('Y/m', strtotime($this->created_at)) . '/' . $this->slug);
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopePublished($query, $take = 0, $skip = null)
    {
        $query = $query->live()->orderBy('created_at', 'DESC');

        if ($take > 0) {
            $query = $query->take($take)->skip($skip);
        }

        return $query;
    }

    public function category()
    {
        return $this->belongsTo('Pyro\Module\Blog\BlogCategoryModel');
    }
}
