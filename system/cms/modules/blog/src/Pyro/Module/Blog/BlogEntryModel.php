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
     * Find an entry based on the preview hash
     *
     * @return string
     */
    public function findByPreviewHash($hash)
    {
        return $this->where('preview_hash', '=', $hash)->first();
    }

    /**
     * Find an entry based on the slug value
     *
     * @return string
     */
    public function findBySlug($slug)
    {
        return $this->where('slug', '=', $slug)->first();
    }

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

    public function getUrlAttribute()
    {
        if ($this->status === 'live') {
            return site_url('blog/' . date('Y/m', strtotime($this->created_at)) . '/' . $this->slug);
        } else {
            return site_url('blog/preview/' . $this->preview_hash);
        }
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
